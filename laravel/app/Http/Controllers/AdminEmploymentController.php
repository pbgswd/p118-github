<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employment\DestroyEmploymentRequest;
use App\Http\Requests\Employment\StoreEmploymentRequest;
use App\Http\Requests\Employment\UpdateEmploymentRequest;
use App\Models\Employment;
use App\Models\Options;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminEmploymentController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;

        Employment::where('deadline', '<', now())
            ->update(['status' => 0]);

        Employment::where('deadline', '>', now())
            ->update(['status' => 1]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Employment::class);

        $jobs = Employment::withoutGlobalScopes()
            ->sortable()
            ->with('attachments')
            ->orderBy('deadline', 'desc')
            ->paginate(20);

        $data['employment'] = $jobs;
        $data['count'] = Employment::withoutGlobalScopes()->count();

        return view('admin.employment_list', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Employment::class);

        $data = [
            'employment' =>  new Employment,
            'action' => 'Add',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.employment', ['data' => $data]);
    }

    /**
     * @param StoreEmploymentRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreEmploymentRequest $request): RedirectResponse
    {
        $this->authorize('create', Employment::class);
        $employment = new Employment($request->employment);

        $employment->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $employment);

            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Log::debug(Auth::user()->name.' created a new Job Posting.');

        Session::flash('success', 'employment posting saved');

        return redirect()->route('admin_employment_edit', [$employment->id]);
    }

    /**
     * @param Employment $employment
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Employment $employment): View
    {
        $this->authorize('update', Employment::class);

        $employment->load('user', 'attachments');

        $data = [
            'employment' => $employment,
            'action' => 'Edit',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.employment', ['data' => $data]);
    }

    /**
     * @param UpdateEmploymentRequest $request
     * @param Employment $any_employment
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateEmploymentRequest $request, Employment $any_employment): RedirectResponse
    {
        $this->authorize('update', Employment::class);

        $any_employment->fill($request->employment);

        $any_employment->save();

        $result = $this->attachmentService->updateAttachment($request, $any_employment);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_employment);

            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Log::debug(Auth::user()->name.' updated an existing Job Posting.');

        Session::flash('success', 'You have edited the employment information');

        return redirect()->route('admin_employment_edit', [$any_employment->id]);
    }

    /**
     * @param DestroyEmploymentRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyEmploymentRequest $request): RedirectResponse
    {
        $this->authorize('delete', Employment::class);

        Employment::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Employment $employment) {
                $this->attachmentService->destroyAttachments($employment);
                $employment->delete();
            });

        Session::flash('success', Str::plural(count($request->id).' posting', count($request->id)).
            ' and any related files deleted.');

        Log::debug(Auth::user()->name.' deleted an existing Job Posting.');

        return redirect()->route('admin_employment_list');
    }
}
