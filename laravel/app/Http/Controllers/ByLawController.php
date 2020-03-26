<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bylaws\DestroyBylawRequest;
use App\Http\Requests\Bylaws\StoreBylaw;
use App\Http\Requests\Bylaws\UpdateBylaw;
use App\Models\Bylaw;
use App\Services\AttachmentService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ByLawController extends Controller
{
    /**
     * BylawController constructor.
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

            if($result) {
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $bylaw_id)
    {
        $this->authorize('update', Auth::user());
        $bylaw = Bylaw::withoutGlobalScopes()->find($bylaw_id);

        $data['bylaw'] = $bylaw->load('user', 'attachments');

        return view('admin.bylaw', ['data' => ['data' => $data, 'action' => 'Edit']]);
    }

    /**
     * @param UpdateBylaw $request
     * @param Bylaw $bylaw
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateBylaw $request, int $bylaw_id)
    {
        $this->authorize('update', Auth::user());
        $bylaw = Bylaw::withoutGlobalScopes()->find($bylaw_id);
        $bylaw->fill($request['bylaw']);

        $bylaw->user_id = Auth::user()->id;
        $bylaw->access_level = 'members';
        $bylaw->save();

        $result = $this->attachmentService->updateAttachment($request, $bylaw);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $bylaw);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the bylaw information");

        return redirect()->route('admin_bylaw_edit', [$bylaw->id]);
    }

    /**
     * @param DestroyBylawRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyBylawRequest $request )
    {

        //todo delete without global scopes
        $this->authorize('delete', Auth::user());
        /** @var Collection $bylaws */
        $bylaws = Bylaw::withoutGlobalScopes()->find($request->id);

        foreach($bylaws as $bylaw)
        {
            //todo scope exclusion issue does not delete, it crashes.
            $result = $this->attachmentService->destroyAttachment($request, $bylaw);

            Bylaw::where('id', $bylaw->id)->delete();  //todo go back to destroy method
        }

        Session::flash('success', Str::plural($bylaws->count() . ' posting', $bylaws->count() . ' and any related files deleted.'));

        return redirect()->route('admin_bylaws_list');
    }
}
