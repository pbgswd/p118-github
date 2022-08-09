<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Bylaws\DestroyBylawRequest;
use App\Http\Requests\Bylaws\StoreBylawRequest;
use App\Http\Requests\Bylaws\UpdateBylawRequest;
use App\Models\Bylaw;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminByLawController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    /**
     * BylawController constructor.
     *
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Bylaw::class);
        $data = [];
        $data['bylaws'] = Bylaw::withoutGlobalScopes()
            ->sortable()
            ->with('attachments')
            ->orderBy('date', 'desc')
            ->paginate(20);

        $data['count'] = Bylaw::withoutGlobalScopes()->count();

        return view('admin.bylaws_list', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Bylaw::class);
        $data = [
            'bylaw' => new Bylaw,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
            'action' => 'Create',
        ];

        return view('admin.bylaw', ['data' => $data]);
    }

    /**
     * @param StoreBylawRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreBylawRequest $request): RedirectResponse
    {
        $this->authorize('create', Bylaw::class);

        $bylaw = new Bylaw($request->bylaw);

        $bylaw->save();

        Session::flash('success', 'bylaw posting saved');

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $bylaw);

            if ($result) {
                Session::flash('success', 'You uploaded '
                    .count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        return redirect()->route('admin_bylaw_edit', [$bylaw->id]);
    }

    /**
     * @param Bylaw $bylaw
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Bylaw $bylaw): View
    {
        $this->authorize('update', Bylaw::class);
        $data = [
            'bylaw' => $bylaw->load('user', 'attachments'),
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
            'action' => 'Edit',
        ];

        return view('admin.bylaw', ['data' => $data]);
    }

    /**
     * @param UpdateBylawRequest $request
     * @param Bylaw $any_bylaw
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateBylawRequest $request, Bylaw $any_bylaw): RedirectResponse
    {
        $this->authorize('update', Bylaw::class);

        $any_bylaw->fill($request->bylaw);

        $any_bylaw->save();

        $result = $this->attachmentService->updateAttachment($request, $any_bylaw);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_bylaw);

            if ($result) {
                Session::flash('success', 'You uploaded '
                    .count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the bylaw information');

        return redirect()->route('admin_bylaw_edit', [$any_bylaw->id]);
    }

    /**
     * @param DestroyBylawRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyBylawRequest $request): RedirectResponse
    {
        $this->authorize('delete', Bylaw::class);
        /** @var Collection $bylaws */
        $bylaws = Bylaw::withoutGlobalScopes()
            ->find($request->ids)
            ->each(function (Bylaw $bylaw) {
                $this->attachmentService->destroyAttachments($bylaw);
                $bylaw->delete();
            });

        Session::flash('success', Str::plural(count([$bylaws]))
                .' bylaw', count([$bylaws]) .' and any related files deleted.');

        return redirect()->route('admin_bylaws_list');
    }
}
