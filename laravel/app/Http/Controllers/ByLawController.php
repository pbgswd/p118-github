<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bylaws\DestroyBylawRequest;
use App\Http\Requests\Bylaws\StoreBylaw;
use App\Http\Requests\Bylaws\UpdateBylawRequest;
use App\Models\Bylaw;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ByLawController extends Controller
{
    /** @var AttachmentService  */
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
     * @return Factory|View
     */
    public function index()
    {

        $this->authorize('viewAny', Auth::user());
        $data = [];
        $data['bylaws'] = Bylaw::withoutGlobalScopes()->sortable()->with('attachments')->orderBy('date', 'desc')->paginate(20);
        $data['count'] = Bylaw::withoutGlobalScopes()->count();

        return view('admin.bylaws_list', ['data' => ['data' => $data]]);
    }

    public function list()
    {
        $this->authorize('viewAny', Auth::user());
        $data = [];
        $data['bylaws'] = Bylaw::sortable()->where('live', '1')->with('attachments')->orderBy('date', 'desc')->paginate(20);
        $data['count'] = Bylaw::count();

        return view('bylaws_list', ['data' => ['data' => $data]]);
    }


    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $data = [];
        $data['bylaw'] = new Bylaw;

        return view('admin.bylaw', ['data' => ['data' => $data, 'action' => 'Create']]);
    }

    /**
     * @param StoreBylaw $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreBylaw $request)
    {
        $this->authorize('create', Auth::user());

        $bylaw = new Bylaw($request->input('bylaw'));
        $bylaw->user_id = Auth::id();
        $bylaw->access_level = 'members';
        $bylaw->save();

        Session::flash('success', "bylaw posting saved");

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $bylaw);

            if ($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }
        return redirect()->route('admin_bylaw_edit', [$bylaw->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bylaw  $bylaw
     * @return \Illuminate\Http\Response
     */
    public function show(Bylaw $bylaw)
    {
        $bylaw->load('user', 'attachments');

        return view('bylaw_view', ['data' => ['bylaw' => $bylaw]]);
    }

    /**
     * @param Bylaw $bylaw
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Bylaw $bylaw)
    {
        $this->authorize('update', Auth::user());
        $data = ['bylaw' => $bylaw->load('user', 'attachments')];

        return view('admin.bylaw', ['data' => ['data' => $data, 'action' => 'Edit']]);
    }

    /**
     * @param UpdateBylawRequest $request
     * @param Bylaw $any_bylaw
     *
     * @return RedirectResponse
     */
    public function update(UpdateBylawRequest $request, Bylaw $any_bylaw): RedirectResponse
    {
        $this->authorize('update', Auth::user());
        $any_bylaw->fill($request->bylaw);

        $any_bylaw->user()->save(Auth::user());
        $any_bylaw->access_level = 'members';
        $any_bylaw->save();

        $result = $this->attachmentService->updateAttachment($request, $any_bylaw);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $any_bylaw);

            if ($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the bylaw information");

        return redirect()->route('admin_bylaw_edit', [$any_bylaw->id]);
    }

    /**
     * @param DestroyBylawRequest $request
     * @return RedirectResponse
     */
    public function destroy(DestroyBylawRequest $request)
    {
        $this->authorize('delete', Auth::user());
        /** @var Collection $bylaws */
        $bylaws = Bylaw::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Bylaw $bylaw) {
                $this->attachmentService->destroyAttachments($bylaw);
                $bylaw->delete();
            });

        Session::flash('success', Str::plural($bylaws->count() . ' bylaw', $bylaws->count()) . ' and any related files deleted.');

        return redirect()->route('admin_bylaws_list');
    }
}
