<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Posts\DestroyPostRequest;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Auth::user());

        $posts = Post::withoutGlobalScopes()->sortable()->with('tagged')->paginate(20);

        return view('admin.listposts', ['data' => ['posts' => $posts]]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $post = new Post;
        $post->topics;

        return view('admin.post', [
            'data' => [
                'post' => $post,
                'assignedTopics' => [],
                'topics' => Topic::all(),
                'access_levels' => array_combine(AccessLevelConstants::getConstants(),AccessLevelConstants::getConstants()),
                'action' => 'Create',
            ]
        ]);
    }

    /**
     * @param StorePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Auth::user());

        $post = new Post($request->input('post'), $request->input('tags'));

        $post->user_id = Auth::id();
        $post->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $post);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        if (!empty($request->input('post.topic_id'))) {
            $post->topics()->sync($request->input('post.topic_id'));
        }

        if (!empty($request->tags)) {
            $post->tag(trim($request->tags, ','));
        }

        Session::flash('success', "You have saved a new post");

        return redirect()->route('post_edit', [$post->slug]);
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Post $post)
    {
        $this->authorize('update', Auth::user());

        $post->load('user', 'attachments', 'topics');

        $assignedTopics = [];
        foreach ($post->topics as $topic)
        {
            $assignedTopics[] = $topic->pivot->topic_id;
        }

        $data = [
            'post' => $post,
            'topics' => Topic::all(),
            'assignedTopics' => $assignedTopics,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),AccessLevelConstants::getConstants()),
            'action' => 'Edit',
            ];

        return view('admin.post', ['data' => $data]);
    }

    /**
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePostRequest $request, Post $any_post): RedirectResponse
    {
        $this->authorize('update', Auth::user());

        $any_post->fill($request->post);
        $any_post->save();

        //todo do I ever want to detach files from a post instead of delete ?
        $result = $this->attachmentService->updateAttachment($request, $any_post);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_post);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            } else {
                Session::flash('error', "You have an upload problem");
            }
        }

        if (!empty($request->post['topic_id'])) {

            $assignedTopics = [];

            foreach ($request->post['topic_id'] as $id)
            {
                $assignedTopics[] = $id;
            }
            $any_post->topics()->sync($request->post['topic_id']);
        } else {
           $any_post->topics()->detach();//no topics selected
        }

        if (empty($request->tags)) {
            $any_post->untag();
        } else {
            $any_post->retag(trim($request->tags, ','));
        }

        Session::flash('success', "You have edited the post");

        return redirect()->route('post_edit', [$any_post->slug]);
    }

    /**
     * @param DestroyPostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyPostRequest $request)
    {
        $this->authorize('delete', Auth::user());

        Post::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Post $post) {
                $post->untag();
                $this->attachmentService->destroyAttachments($post);
                $post->topics()->detach();
                $post->delete();
            });

        Session::flash('success', Str::plural('post', count($request->id)) . ' deleted.');

        return redirect()->route('posts_list');
    }
}
