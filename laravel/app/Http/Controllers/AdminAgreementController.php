<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Agreements\DestroyAgreementRequest;
use App\Http\Requests\Agreements\StoreAgreementRequest;
use App\Http\Requests\Agreements\UpdateAgreementRequest;
use App\Models\Agreement;
use App\Services\AttachmentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminAgreementController extends Controller
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
     * @return Factory|View
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
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $agreement = new Agreement;

        return view('admin.agreement', ['data' => ['agreement' => $agreement, 'action' => 'Create']]);
    }

    /**
     * @param StoreAgreementRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreAgreementRequest $request): RedirectResponse
    {
        $this->authorize('create', Auth::user());

        $agreement = new Agreement($request->agreement);
        $agreement->access_level = $agreement->getAttachmentAccessLevel();

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
     *
     * @return Factory|View
     */
    public function edit(Agreement $agreement)
    {
        $this->authorize('update', Auth::user());
        $data = [
            'agreement' => $agreement->load('user', 'attachments'),
            'action' => 'Edit',
        ];

        return view('admin.agreement', ['data' => $data]);
    }

    /**
     * @param UpdateAgreementRequest $request
     * @param Agreement $any_agreement
     *
     * @return RedirectResponse
     */
    public function update(UpdateAgreementRequest $request, Agreement $any_agreement): RedirectResponse
    {
        $this->authorize('update', Auth::user());

        $any_agreement->fill($request->agreement);

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
     *
     * @return RedirectResponse
     */
    public function destroy(DestroyAgreementRequest $request): RedirectResponse
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
