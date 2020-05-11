<?php

namespace App\Http\Controllers;

use App\Http\Requests\Policies\AdminDestroyPolicy;
use App\Http\Requests\Policies\AdminStorePolicy;
use App\Http\Requests\Policies\AdminUpdatePolicy;
use App\Models\Policy;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminPolicyController extends Controller
{
    /** @var AttachmentService  */
    private $attachmentService;

    /**
     * AdminPolicyController constructor.
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['policies'] = Policy::withoutGlobalScopes()->sortable()->with('attachments')->orderBy('date', 'desc')->paginate(20);
        $data['count'] = Policy::withoutGlobalScopes()->count();

        return view('admin.policies_list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'policy' => new Policy,
            'action' => 'Create',
        ];

        return view('admin.policy', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStorePolicy $request)
    {
        $policy = new Policy($request->policy);

        $policy->save();

        Session::flash('success', "policy posting saved");

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $policy);

            if ($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }
        return redirect()->route('admin_policy_edit', [$policy->id]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function edit(Policy $any_policy)
    {

        $data = [
            'policy' => $any_policy->load('user', 'attachments'),
            'action' => 'Edit',
        ];

        return view('admin.policy', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdatePolicy $request, Policy $any_policy): RedirectResponse
    {
        $any_policy->fill($request->policy);

        $any_policy->save();

        $result = $this->attachmentService->updateAttachment($request, $any_policy);

        if (null !== ($request->file('attachments')))
        {
            $result = $this->attachmentService->createAttachment($request, $any_policy);

            if($result){
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        Session::flash('success', "You have edited the policy");

        return redirect()->route('admin_policy_edit', [$any_policy->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminDestroyPolicy $request): RedirectResponse
    {
        //todo permissions for Policy controller
        //$this->authorize('delete', Auth::user());

        /** @var Collection $policy */

        Policy::withoutGlobalScopes()
            ->find($request->id)
            ->each(function(Policy $policy) {
                $this->attachmentService->destroyAttachments($policy);
                $policy->delete();
            });

        Session::flash('success', Str::plural(count($request->id) . ' posting', count($request->id)) . ' and any related files deleted.');

        return redirect()->route('policies_list');
    }
}
