<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agreements\DestroyAgreement;
use App\Http\Requests\Agreements\StoreAgreement;
use App\Http\Requests\Agreements\UpdateAgreement;
use App\Models\Agreement;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AgreementController extends Controller
{
    /**
     * AgreementController constructor.
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
        $data['agreements'] = [];

        $data['agreements'] = Agreement::sortable()->with('attachments')->orderBy('until', 'desc')->paginate(20);
        $data['count'] = count(Agreement::all());

        return view('admin.agreements_list', ['data' => ['data' => $data]]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function list()
    {
        //$this->authorize('viewAny', Auth::user());

        $data['agreements'] = Agreement::sortable()->where('live', '1')->with('attachments')->orderBy('until', 'desc')->paginate(20);
        $data['count'] = count(Agreement::all());
//dd($data);

        return view('agreements_list', ['data' => ['data' => $data]]);
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $data = [];
        $data['agreement'] = new Agreement;

        return view('admin.agreement', ['data' => ['data' => $data, 'action' => 'Create']]);
    }

    /**
     * @param StoreMeeting $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreAgreement $request)
    {
        $this->authorize('create', Auth::user());

        $agreement = new Agreement($request->input('agreement'));
        $agreement->user_id = Auth::id();
        $agreement->access_level = 'members';
        $agreement->save();

        Session::flash('success', "agreement posting saved");

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $agreement);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }
        return redirect()->route('agreement_edit', [$agreement->id]);
    }

    /**
     * Display the specified resource.
     * @param Agreement $agreement
     * @return Response
     */
    public function show(Agreement $agreement)
    {
        $agreement->load('user', 'attachments');

        return view('agreement_view', ['data' => ['agreement' => $agreement]]);
    }

    /**
     * @param Agreement $agreement
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Agreement $agreement)
    {
        $this->authorize('update', Auth::user());
        $data['agreement'] = $agreement->load('user', 'attachments');

        return view('admin.agreement', ['data' => ['data' => $data, 'action' => 'Edit']]);
    }

    /**
     * @param UpdateMeeting $request
     * @param Agreement $agreement
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateAgreement $request, Agreement $agreement)
    {
        $this->authorize('update', Auth::user());

        $agreement->fill($request['agreement']);

        $agreement->user_id = Auth::user()->id;
        $agreement->access_level = 'members';
        $agreement->save();

        $result = $this->attachmentService->updateAttachment($request, $agreement);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $agreement);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the agreement information");

        return redirect()->route('agreement_edit', [$agreement->id]);
    }

    /**
     * @param DestroyAgreement $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyAgreement $request)
    {
        // $this->authorize('delete', Auth::user());
        $agreements = Agreement::find($request->id);

        foreach($agreements as $agreement)
        {
            $result = $this->attachmentService->destroyAttachment($agreement);

            Agreement::destroy($agreement->id);
        }

        Session::flash('success', Str::plural(count($request->id) . ' posting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('agreements_list');
    }
}
