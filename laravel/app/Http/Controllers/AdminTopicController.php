<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Topic\DestroyTopicRequest;
use App\Http\Requests\Topic\StoreTopicRequest;
use App\Http\Requests\Topic\UpdateTopicRequest;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminTopicController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

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
        $this->authorize('viewAny', Topic::class);

        $topics = Topic::withoutGlobalScopes()
            ->sortable()
            ->with('tagged', 'user')
            ->paginate(20);

        return view('admin.listtopics', ['data' => ['topics' => $topics]]);
    }


    public function create()
    {
        $this->authorize('create', Topic::class);

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
     * @param StoreTopicRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreTopicRequest $request): RedirectResponse
    {
        $this->authorize('create', Topic::class);

        $topic = new Topic($request->input('topic'), $request->input('tags'));
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

        if (! empty($request->tags)) {
            $topic->tag(trim($request->tags, ','));
        }
        Session::flash('success', 'You have saved a new topic');

        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * @param Topic $topic
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Topic $topic): View
    {
        $this->authorize('update', Topic::class);

        $data = [
            'topic' => $topic->load('user', 'attachments'),
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
            'action' => 'Edit',
            ];

        return view('admin.topic', ['data' => $data]);
    }

    /**
     * @param UpdateTopicRequest $request
     * @param Topic $any_topic
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateTopicRequest $request, Topic $any_topic): RedirectResponse
    {
        $this->authorize('update', Topic::class);

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

        if (empty($request->tags)) {
            $any_topic->untag();
        } else {
            $any_topic->retag(trim($request->tags, ','));
        }

        Session::flash('success', 'You have edited the topic');

        return redirect()->route('topic_edit', [$any_topic->slug]);
    }

    /**
     * @param DestroyTopicRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyTopicRequest $request): RedirectResponse
    {
        $this->authorize('delete', Topic::class);

        Topic::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Topic $topic) {
                $topic->untag();
                $topic->pages()->detach();
                $topic->posts()->detach();
                $this->attachmentService->destroyAttachments($topic);
                $topic->delete();
            });

        Session::flash('success', Str::plural('Topic', count($request->id)).' deleted.');

        return redirect()->route('topics_list');
    }
}
