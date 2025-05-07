<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AccessLevelConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\DestroyTopicRequest;
use App\Http\Requests\Topic\StoreTopicRequest;
use App\Http\Requests\Topic\UpdateTopicRequest;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminTopicController extends Controller
{
    private AttachmentService $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Topic::class);

        $topics = Topic::withoutGlobalScopes()
            ->sortable()
            ->with('user', 'attachments', 'pages', 'posts')
            ->paginate(20);

        return view('admin.listtopics', ['data' => ['topics' => $topics]]);
    }

    public function create(): View
    {
        Gate::authorize('create', Topic::class);

        $topic = new Topic;
        $topic['user_id'] = Auth::id();
        $access_levels = array_combine(AccessLevelConstants::getConstants(),
            AccessLevelConstants::getConstants());

        $data = [
            'topic' => $topic,
            'access_levels' => $access_levels,
            'action' => 'Create',
        ];

        return view('admin.topic', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreTopicRequest $request): RedirectResponse
    {
        Gate::authorize('create', Topic::class);
        $topic = new Topic($request->input('topic'));
        $topic->user_id = Auth::id();

        $topic->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $topic);
            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }
        Session::flash('success', 'You have saved a new topic');

        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Topic $topic): View
    {
        Gate::authorize('update', Topic::class);

        $data = [
            'topic' => $topic->load('user', 'attachments'),
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
            'action' => 'Edit',
        ];

        return view('admin.topic', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateTopicRequest $request, Topic $any_topic): RedirectResponse
    {
        Gate::authorize('update', Topic::class);

        $any_topic->fill($request->topic);
        $any_topic->save();

        $result = $this->attachmentService->updateAttachment($request, $any_topic);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_topic);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the topic');

        return redirect()->route('topic_edit', [$any_topic->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyTopicRequest $request): RedirectResponse
    {
        Gate::authorize('delete', Topic::class);

        Topic::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Topic $topic) {
                $topic->pages()->detach();
                $topic->posts()->detach();
                $this->attachmentService->destroyAttachments($topic);
                $topic->delete();
            });

        Session::flash('success', Str::plural('Topic', count([$request->id])).' deleted.');

        return redirect()->route('topics_list');
    }
}
