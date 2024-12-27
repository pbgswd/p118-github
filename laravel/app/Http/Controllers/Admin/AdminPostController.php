<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AccessLevelConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\DestroyPostRequest;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Attachment;
use App\Models\Message;
use App\Models\MessageCategory;
use App\Models\Post;
use App\Models\Topic;
use App\Services\AttachmentService;
use App\Services\MessageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPostController extends Controller
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService, MessageService $messageService)
    {
        $this->attachmentService = $attachmentService;
        $this->messageService = $messageService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::withoutGlobalScopes()
            ->sortable()
            ->with('topics', 'attachments')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.listposts', ['data' => ['posts' => $posts]]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Post::class);

        $post = new Post;

        return view('admin.post', [
            'data' => [
                'post' => $post,
                'assignedTopics' => [],
                'topics' => Topic::all(),
                'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
                'action' => 'Create',
                'model_name' => 'post',
            ],
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $post = new Post($request->input('post'));

        $post->user_id = Auth::id();
        $post->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $post);

            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        if (! empty($request->input('post.topic_id'))) {
            $post->topics()->sync($request->input('post.topic_id'));
        }

        Session::flash('success', 'You have saved a new post');

        return redirect()->route('post_edit', [$post->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Post $post): View
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
            'existing_message' => Message::where('source_url',  env('APP_URL') . '/post/' . $post->slug)->exists(),
            'assignedTopics' => $assignedTopics,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
            'action' => 'Edit',
            'model_name' => 'post',
        ];

        return view('admin.post', ['data' => $data]);
    }

    /**
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
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
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

        Session::flash('success', 'You have edited the post');

        return redirect()->route('post_edit', [$any_post->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyPostRequest $request): RedirectResponse
    {
        $this->authorize('delete', Post::class);

        Post::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Post $post) {
                $this->attachmentService->destroyAttachments($post);
                $post->topics()->detach();
                $post->delete();
            });

        Session::flash('success', 'You have deleted '. count($request->id) . ' ' .
            Str::plural('post', count($request->id)).'.');

        return redirect()->route('posts_list');
    }

    /**
     * @throws AuthorizationException
     */
    public function message(Post $post): RedirectResponse
    {
        $this->authorize('update', Post::class);

        $source_url = env('APP_URL') . '/post/' . $post->slug;
        if(Message::where('source_url',  $source_url)->exists()) {
            Session::flash('warning', 'A message from this content has already been created');
            return redirect()->route('post_edit', [$post->slug]);
        }

        $post->load('user', 'attachments', 'topics');
        $post->source_url = $source_url;

        $msg = $this->messageService->createPostMessage($post);


        Session::flash('success', 'new message from posts saved');

        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }
}
