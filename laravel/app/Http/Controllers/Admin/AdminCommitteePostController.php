<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommitteePost\DestroyCommitteePostRequest;
use App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
use App\Http\Requests\CommitteePost\UpdateCommitteePostRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\Message;
use App\Models\Options;
use App\Models\User;
use App\Services\AttachmentService;
use App\Services\MessageService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCommitteePostController extends Controller
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
    public function index(CommitteePost $committeePost, Committee $committee): View
    {
        $this->authorize('update', $committee);

        $data = [
            'committee' => $committee,
            'posts' => CommitteePost::withoutGlobalScopes()
                ->with('attachments')
                ->sortable()
                ->where('committee_id', $committee->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ];

        return view('admin.committee.committee_posts_list', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(Committee $committee): View
    {
        $this->authorize('update', $committee);

        $data = [
            'post' => new CommitteePost,
            'committee' => $committee,
            'action' => 'Create',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.committee.committee_post', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreCommitteePostRequest $request, Committee $committee, User $user): RedirectResponse
    {
        $this->authorize('update', $committee);

        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;
        $post->user_id = Auth::id();

        $post->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $post);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have saved a new post in '.$committee->name);

        return redirect()->route('admin_committee_post_edit', [$committee->slug, $post->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Committee $committee, CommitteePost $any_committee_post): View
    {
        $this->authorize('update', $committee);

        $any_committee_post->load('creator', 'admin_post_comments', 'attachments');

        $data = [
            'post' => $any_committee_post,
            'committee' => $committee,
            'existing_message' => Message::where('source_url',  env('APP_URL') . '/committee/'. $committee->slug .'/post/' . $any_committee_post->slug)->exists(),
            'action' => 'Edit',
            'access_levels' => Options::access_levels(),
        ];

        return view('admin.committee.committee_post', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateCommitteePostRequest $request, Committee $committee,
        CommitteePost $committeePost): RedirectResponse
    {
        $this->authorize('update', $committee);

        $committeePost->fill($request->post);
        $committeePost->save();

        $result = $this->attachmentService->updateAttachment($request, $committeePost);
        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $committeePost);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have edited the post');

        return redirect()->route('admin_committee_post_edit',
            [$committeePost->committee->slug, $committeePost->slug]);
    }

    public function message(Committee $committee, CommitteePost $any_committee_post): RedirectResponse
    {
        $this->authorize('update', $committee);

        $source_url = env('APP_URL') . '/committee/'. $committee->slug .'/post/' . $any_committee_post->slug;

        if(Message::where('source_url',  $source_url)->exists()) {
            Session::flash('warning', 'A message from this content has already been created');
            return redirect()->route('admin_committee_post_edit', [$committee->slug, $any_committee_post->slug]);
        }

        $any_committee_post->load('creator', 'attachments', 'committee');
        $any_committee_post->source_url = $source_url;
        $msg = $this->messageService->createCommitteePostMessage($any_committee_post);

        Session::flash('success', 'new message from posts saved');
        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }


    /**
     * @throws Exception
     */
    public function destroy(DestroyCommitteePostRequest $request, Committee $committee): RedirectResponse
    {
        $this->authorize('update', $committee);

        CommitteePost::withoutGlobalScopes()
            ->find($request->id)
            ->each(static function (CommitteePost $post) {
                $service = new AttachmentService;
                $service->destroyAttachments($post);
                $post->delete();
            });

        Session::flash('success', 'Committee '.Str::plural('post', count($request->id)).' deleted.');

        return redirect()->route('committee_posts_list', $committee->slug);
    }
}
