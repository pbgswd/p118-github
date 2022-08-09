<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agreements\DestroyAgreementRequest;
use App\Http\Requests\Agreements\StoreAgreementRequest;
use App\Http\Requests\Agreements\UpdateAgreementRequest;
use App\Models\Agreement;
use App\Models\Options;
use App\Models\Organization;
use App\Models\Venue;
use App\Services\AttachmentService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminAgreementController extends Controller
{
    /** @var AttachmentService */
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
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Agreement::class);

        $data['agreements'] = Agreement::withoutGlobalScopes()
            ->sortable()
            ->with('attachments')
            ->orderBy('until', 'desc')
            ->paginate(20);
        $data['count'] = Agreement::withoutGlobalScopes()->count();

        return view('admin.agreements_list', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Agreement::class);
        $agreement = new Agreement;

        $data = [
            'agreement' => $agreement,
            'access_levels' => Options::access_levels(),
            'orgs' => Organization::all(),
            'venues' =>Venue::all(),
            'action' => 'Create',
        ];

        return view('admin.agreement', ['data' => $data]);
    }

    /**
     * @param StoreAgreementRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreAgreementRequest $request): RedirectResponse
    {
        $this->authorize('create', Agreement::class);

        $agreement = new Agreement($request->agreement);

        $agreement->save();

        if (isset($request->agreement['client'])) {
            foreach ($request->agreement['client'] as $client) {
                list($client_type, $client_id) = explode(' ', $client);

                if ($client_type === 'organization') {
                    $agreement->organizations()->attach($client_id);
                }

                if ($client_type === 'venue') {
                    $agreement->venues()->attach($client_id);
                }
            }
        }

        Session::flash('success', 'agreement posting saved');

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $agreement);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        return redirect()->route('agreement_edit', [$agreement->id]);
    }

    /**
     * @param Agreement $agreement
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Agreement $agreement): View
    {
       // dd($agreement);
        $this->authorize('update', Agreement::class);

        $agreement->load('user', 'attachments', 'organizations', 'venues');

        $ass_orgs = [];
        foreach ($agreement['organizations']->toArray() as $aa) {
            $ass_orgs[] = $aa['id'];
        }

        $ass_venues = [];
        foreach ($agreement['venues']->toArray() as $vv) {
            $ass_venues[] = $vv['id'];
        }

        $data = [
            'agreement' => $agreement,
            'access_levels' => Options::access_levels(),
            'orgs' => Organization::orderBy('name')->get(),
            'venues' => Venue::orderBy('name')->get(),
            'ass_orgs' => $ass_orgs,
            'ass_venues' => $ass_venues,
            'action' => 'Edit',
        ];

        return view('admin.agreement', ['data' => $data]);
    }

    /**
     * @param UpdateAgreementRequest $request
     * @param Agreement $any_agreement
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateAgreementRequest $request, Agreement $any_agreement): RedirectResponse
    {
        $this->authorize('update', Agreement::class);

        $any_agreement->fill($request->agreement);

        $any_agreement->save();

        $any_agreement->organizations()->detach();
        $any_agreement->venues()->detach();

        if (isset($request->agreement['client'])) {
            foreach ($request->agreement['client'] as $client) {
                list($client_type, $client_id) = explode(' ', $client);

                if ($client_type === 'organization') {
                    $any_agreement->organizations()->attach($client_id);
                }

                if ($client_type === 'venue') {
                    $any_agreement->venues()->attach($client_id);
                }
            }
        }

        $result = $this->attachmentService->updateAttachment($request, $any_agreement);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_agreement);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the agreement information');

        return redirect()->route('agreement_edit', [$any_agreement->id]);
    }

    /**
     * @param DestroyAgreementRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(DestroyAgreementRequest $request): RedirectResponse
    {
        $this->authorize('delete', Agreement::class);
        Agreement::withoutGlobalScopes()
            ->find($request->ids)
            ->each(function (Agreement $agreement) {
                $this->attachmentService->destroyAttachments($agreement);
                $agreement->delete();
            });

        Session::flash('success', count([$request->ids]) . Str::plural(' agreement', count([$request->ids])).
            ' and any related files have been deleted.');

        return redirect()->route('agreements_list');
    }
}
