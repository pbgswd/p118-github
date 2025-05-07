<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Policies\AdminDestroyPolicy;
use App\Http\Requests\Policies\AdminStorePolicy;
use App\Http\Requests\Policies\AdminUpdatePolicy;
use App\Models\Message;
use App\Models\Options;
use App\Models\Policy;
use App\Services\AttachmentService;
use App\Services\FeatureService;
use App\Services\MessageService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPolicyController extends Controller
{
    private AttachmentService $attachmentService;

    private MessageService $messageService;

    private FeatureService $featureService;

    /**
     * AdminPolicyController constructor.
     */
    public function __construct(AttachmentService $attachmentService, MessageService $messageService, FeatureService $featureService)
    {
        $this->attachmentService = $attachmentService;
        $this->messageService = $messageService;
        $this->featureService = $featureService;
    }

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

    public function create(): View
    {
        $data = [
            'policy' => new Policy,
            'action' => 'Create',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.policy', ['data' => $data]);
    }

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
        Session::flash('success', 'policy policying saved');

        return redirect()->route('admin_policy_edit', [$policy->id]);
    }

    public function edit(Policy $any_policy): View
    {
        $data = [
            'policy' => $any_policy->loadWithoutGlobalScopes('user', 'attachments'),
            'action' => 'Edit',
            'existing_message' => Message::where('source_url', env('APP_URL').'/policies/'.$any_policy->id)->exists(),
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.policy', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
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
     * @throws Exception
     */
    public function destroy(AdminDestroyPolicy $request): RedirectResponse
    {
        // todo permissions for Policy controller
        Gate::authorize('delete', Auth::user());

        /** @var Collection $policy */
        Policy::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Policy $policy) {
                $this->attachmentService->destroyAttachments($policy);
                $policy->delete();
            });

        Session::flash('success', Str::plural(count([$request->id]).' policying', count([$request->id])).
            ' and any related files deleted.');

        return redirect()->route('policies_list');
    }

    public function message(Policy $policy): RedirectResponse
    {
        // $this->authorize('update', Policy::class);

        $source_url = env('APP_URL').'/policies/'.$policy->id;

        if (Message::where('source_url', $source_url)->exists()) {
            Session::flash('warning', 'A message from this content has already been created');

            return redirect()->route('admin_policy_edit', [$policy->id]);
        }

        $policy->load('user');
        $policy->source_url = $source_url;

        $msg = $this->messageService->createPolicyMessage($policy);

        Session::flash('success', 'new message from policys saved');

        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }

    public function feature(Policy $policy): RedirectResponse
    {
        Gate::authorize('update', Auth::user());

        $policy->source_url = env('APP_URL').'/policies/'.$policy->id;
        $msg = $this->featureService->createPolicyFeature($policy);
        Session::flash('success', 'new feature from policies saved');

        return redirect()->route('admin_feature_edit', [$msg->slug]);
    }
}
