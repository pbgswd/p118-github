<?php

namespace App\Http\Controllers;

use App\Http\Requests\Topic\DestroyTopicRequest;
use App\Http\Requests\Topic\StoreTopicRequest;
use App\Http\Requests\Topic\UpdateTopicRequest;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Auth::user());

        $topics = Topic::withoutGlobalScopes()->sortable()->with('tagged', 'user')->paginate(20);

        return view('admin.listtopics', ['data' => ['topics' => $topics]]);
    }

    /**
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $topic = new Topic;
        $topic['user_id'] = Auth::id();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.topic', [
            'data' => [
                'topic' => $topic,
                'access_levels' => $access_levels,
                'action' => 'Create']]);
    }

    /**
     * @param StoreTopicRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTopicRequest $request)
    {
        $this->authorize('create', Auth::user());

        $topic = new Topic($request->input('topic'), $request->input('tags'));
        $topic->user_id = Auth::id();

        $topic->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $topic);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        if (!empty($request->tags)) {
            $topic->tag(trim($request->tags, ','));
        }
        Session::flash('success', "You have saved a new topic");

        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * @param Topic $topic
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Topic $topic)
    {
        $this->authorize('update', Auth::user());

        $topic->load('user','attachments');

        $data = [
            'topic' => $topic,
            'access_levels' => $this->getFormOptions(['access_levels']),
            'action' => 'Edit',
            ];

        return view('admin.topic', ['data' => $data]);
    }

    /**
     * @param UpdateTopicRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTopicRequest $request, Topic $any_topic): RedirectResponse
    {
        $this->authorize('update', Auth::user());

        $any_topic->fill($request->topic);
        $any_topic->save();

        $result = $this->attachmentService->updateAttachment($request, $any_topic);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_topic);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        if (empty($request->tags)) {
            $any_topic->untag();
        } else {
            $any_topic->retag(trim($request->tags, ','));
        }

        Session::flash('success', "You have edited the topic");

        return redirect()->route('topic_edit', [$any_topic->slug]);
    }

    /**
     * @param DestroyTopicRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyTopicRequest $request)
    {
        $this->authorize('delete', Auth::user());

        Topic::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Topic $topic) {
                $topic->untag();
                $topic->pages()->detach();
                $topic->posts()->detach();
                $this->attachmentService->destroyAttachments($topic);
                $topic->delete();
        });

        Session::flash('success', Str::plural('Topic', count($request->id)) . ' deleted.');

        return redirect()->route('topics_list');
    }
}
