<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employment\DestroyEmploymentRequest;
use App\Http\Requests\Employment\StoreEmploymentRequest;
use App\Http\Requests\Employment\UpdateEmploymentRequest;
use App\Models\Employment;
use App\Models\Message;
use App\Models\Options;
use App\Services\AttachmentService;
use App\Services\FeatureService;
use App\Services\MessageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminEmploymentController extends Controller
{
    private AttachmentService $attachmentService;

    private MessageService $messageService;

    private FeatureService $featureService;

    public function __construct(AttachmentService $attachmentService, MessageService $messageService, FeatureService $featureService)
    {
        $this->attachmentService = $attachmentService;
        $this->messageService = $messageService;
        $this->featureService = $featureService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Employment::class);

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
     * @throws AuthorizationException
     */
    public function create(): View
    {
        Gate::authorize('create', Employment::class);

        $data = [
            'employment' => new Employment,
            'action' => 'Add',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.employment', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreEmploymentRequest $request): RedirectResponse
    {
        Gate::authorize('create', Employment::class);
        $employment = new Employment($request->employment);

        if ($employment->deadline > now()) {
            $employment->status = 1;
        }

        $employment->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $employment);

            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' '.
                    Str::plural('file', count($request->file('attachments'))));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }
        Session::flash('success', 'employment posting saved');

        return redirect()->route('admin_employment_edit', [$employment->id]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Employment $employment): View
    {
        Gate::authorize('update', Employment::class);

        $employment->load('user', 'attachments');

        $data = [
            'employment' => $employment,
            'action' => 'Edit',
            'existing_message' => Message::where('source_url', env('APP_URL').'/job/'.$employment->id)->exists(),
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.employment', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateEmploymentRequest $request, Employment $any_employment): RedirectResponse
    {
        Gate::authorize('update', Employment::class);

        $any_employment->fill($request->employment);

        if ($any_employment->deadline > now()) {
            $any_employment->status = 1;
        }

        $any_employment->save();

        $result = $this->attachmentService->updateAttachment($request, $any_employment);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_employment);

            if ($result) {
                Session::flash('success', 'You uploaded '.Str::plural('file', $request->file('attachments').' and any related files deleted.'));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the employment information');

        return redirect()->route('admin_employment_edit', [$any_employment->id]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyEmploymentRequest $request): RedirectResponse
    {
        Gate::authorize('delete', Employment::class);

        Employment::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Employment $employment) {
                $this->attachmentService->destroyAttachments($employment);
                $employment->delete();
            });

        Session::flash('success', Str::plural(count([$request->id]).' posting'.' and any related files deleted.'));

        return redirect()->route('admin_employment_list');
    }

    /**
     * @throws AuthorizationException
     */
    public function message(Employment $employment): RedirectResponse
    {

        Gate::authorize('update', Employment::class);

        $source_url = env('APP_URL').'/job/'.$employment->id;

        if (Message::where('source_url', $source_url)->exists()) {
            Session::flash('warning', 'A message from this content has already been created');

            return redirect()->route('admin_employment_edit', [$employment->id]);
        }

        $employment->load('user');
        $employment->source_url = $source_url;

        $msg = $this->messageService->createEmploymentMessage($employment);

        Session::flash('success', 'new message from Job Postings saved');

        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }

    public function feature(Employment $employment): RedirectResponse
    {
        Gate::authorize('update', Employment::class);
        $employment->source_url = env('APP_URL').'/job/'.$employment->id;
        $msg = $this->featureService->createEmploymentFeature($employment);
        Session::flash('success', 'new feature from Employment saved');

        return redirect()->route('admin_feature_edit', [$msg->slug]);
    }
}
