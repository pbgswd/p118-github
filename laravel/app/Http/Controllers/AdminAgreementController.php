<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agreements\DestroyAgreementRequest;
use App\Http\Requests\Agreements\StoreAgreementRequest;
use App\Http\Requests\Agreements\UpdateAgreementRequest;
use App\Models\Agreement;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AgreementController extends Controller
{
    /** @var AttachmentService  */
    private $attachmentService;

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

        $data['agreements'] = Agreement::withoutGlobalScopes()->sortable()->with('attachments')->orderBy('until', 'desc')->paginate(20);
        $data['count'] = Agreement::withoutGlobalScopes()->count();

        return view('admin.agreements_list', ['data' => ['data' => $data]]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $agreement = new Agreement;

        return view('admin.agreement', ['data' => ['data' => $agreement, 'action' => 'Create']]);
    }

    /**
     * @param StoreMeeting $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreAgreementRequest $request)
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
     * @param UpdateAgreementRequest $request
     * @param Agreement $any_agreement
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateAgreementRequest $request, Agreement $any_agreement): RedirectResponse
    {
        $this->authorize('update', Auth::user());

        $any_agreement->fill($request['agreement']);

        $any_agreement->user_id = Auth::user()->id;
        $any_agreement->access_level = 'members';
        $any_agreement->save();

        $result = $this->attachmentService->updateAttachment($request, $any_agreement);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $any_agreement);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the agreement information");

        return redirect()->route('agreement_edit', [$any_agreement->id]);
    }

    /**
     * @param DestroyAgreementRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyAgreementRequest $request)
    {
        //todo permissions for Agreement controller
        //$this->authorize('delete', Auth::user());

        Agreement::withoutGlobalScopes()
        ->find($request->id)
            ->each(function(Agreement $agreement) {
                $this->attachmentService->destroyAttachments($agreement);
                $agreement->delete();
            });

        Session::flash('success', Str::plural(count($request->id) . ' posting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('agreements_list');
    }
}
