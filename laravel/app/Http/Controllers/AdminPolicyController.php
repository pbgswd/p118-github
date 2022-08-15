<?php

namespace App\Http\Controllers;

use App\Http\Requests\Policies\AdminDestroyPolicy;
use App\Http\Requests\Policies\AdminStorePolicy;
use App\Http\Requests\Policies\AdminUpdatePolicy;
use App\Models\Options;
use App\Models\Policy;
use App\Services\AttachmentService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPolicyController extends Controller
{
    /** @var AttachmentService */
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
     * @return View
     */
    public function index(): View
    {
        $data = [];
        $data['policies'] = Policy::withoutGlobalScopes()
            ->sortable()
            ->with('attachments')
            ->orderBy('date', 'desc')
            ->paginate(20);
        $data['count'] = Policy::withoutGlobalScopes()->count();

        return view('admin.policies_list', ['data' => $data]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data = [
            'policy' => new Policy,
            'action' => 'Create',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.policy', ['data' => $data]);
    }

    /**
     * @param AdminStorePolicy $request
     * @return RedirectResponse
     */
    public function store(AdminStorePolicy $request): RedirectResponse
    {
        $policy = new Policy($request->policy);

        $policy->save();



        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $policy);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }
        Session::flash('success', 'policy posting saved');
        return redirect()->route('admin_policy_edit', [$policy->id]);
    }

    /**
     * @param Policy $any_policy
     * @return View
     */
    public function edit(Policy $any_policy): View
    {
        $data = [
            'policy' => $any_policy->loadWithoutGlobalScopes('user', 'attachments'),
            'action' => 'Edit',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.policy', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminUpdatePolicy $request
     * @param Policy $any_policy
     * @return RedirectResponse
     */
    public function update(AdminUpdatePolicy $request, Policy $any_policy): RedirectResponse
    {
        $any_policy->fill($request->policy);

        $any_policy->save();

        $result = $this->attachmentService->updateAttachment($request, $any_policy);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_policy);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the policy');

        return redirect()->route('admin_policy_edit', [$any_policy->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AdminDestroyPolicy $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(AdminDestroyPolicy $request): RedirectResponse
    {
        //todo permissions for Policy controller
        //$this->authorize('delete', Auth::user());

        /** @var Collection $policy */
        Policy::withoutGlobalScopes()
            ->find($request->ids)
            ->each(function (Policy $policy) {
                $this->attachmentService->destroyAttachments($policy);
                $policy->delete();
            });

        Session::flash('success', Str::plural(count([$request->id]).' posting', count([$request->id])).
            ' and any related files deleted.');

        return redirect()->route('policies_list');
    }
}
