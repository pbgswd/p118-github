<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Posts\DestroyPostRequest;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
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
     * @return View
     * @throws AuthorizationException
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::withoutGlobalScopes()
            ->sortable()
            ->with('topics', 'tagged')
            ->paginate(20);

        return view('admin.listposts', ['data' => ['posts' => $posts]]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Post::class);

        $post = new Post;
        $post->topics;

        return view('admin.post', [
            'data' => [
                'post' => $post,
                'assignedTopics' => [],
                'topics' => Topic::all(),
                'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                    AccessLevelConstants::getConstants()),
                'action' => 'Create',
                'model_name' => 'post',
            ],
        ]);
    }

    /**
     * @param StorePostRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $post = new Post($request->input('post'), $request->input('tags'));

        $post->user_id = Auth::id();
        $post->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $post);

            if ($result) {
                Session::flash('success', 'You uploaded '
                    .count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        if (! empty($request->input('post.topic_id'))) {
            $post->topics()->sync($request->input('post.topic_id'));
        }

        if (! empty($request->tags)) {
            $post->tag(trim($request->tags, ','));
        }

        Session::flash('success', 'You have saved a new post');

        return redirect()->route('post_edit', [$post->slug]);
    }

    /**
     * @param Post $post
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Post $post):View
    {
        $this->authorize('update', Post::class);

        $post->load('user', 'attachments', 'topics');

        $assignedTopics = [];
        foreach ($post->topics as $topic) {
            $assignedTopics[] = $topic->pivot->topic_id;
        }

        $data = [
            'post' => $post,
            'topics' => Topic::all(),
            'assignedTopics' => $assignedTopics,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
            'action' => 'Edit',
            'model_name' => 'post',
            ];

        return view('admin.post', ['data' => $data]);
    }

    /**
     * @param UpdatePostRequest $request
     * @param Post $any_post
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdatePostRequest $request, Post $any_post): RedirectResponse
    {
        $this->authorize('update', Post::class);

        $any_post->fill($request->post);
        $any_post->save();

        $result = $this->attachmentService->updateAttachment($request, $any_post);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_post);

            if ($result) {
                Session::flash('success', 'You uploaded '
                    .count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        if (! empty($request->post['topic_id'])) {
            $assignedTopics = [];

            foreach ($request->post['topic_id'] as $id) {
                $assignedTopics[] = $id;
            }
            $any_post->topics()->sync($request->post['topic_id']);
        } else {
            $any_post->topics()->detach();
        }

        if (empty($request->tags)) {
            $any_post->untag();
        } else {
            $any_post->retag(trim($request->tags, ','));
        }

        Session::flash('success', 'You have edited the post');

        return redirect()->route('post_edit', [$any_post->slug]);
    }

    /**
     * @param DestroyPostRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyPostRequest $request): RedirectResponse
    {
        $this->authorize('delete', Post::class);

        Post::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Post $post) {
                $post->untag();
                $this->attachmentService->destroyAttachments($post);
                $post->topics()->detach();
                $post->delete();
            });

        Session::flash('success', Str::plural('post', count($request->id)).' deleted.');

        return redirect()->route('posts_list');
    }
}
