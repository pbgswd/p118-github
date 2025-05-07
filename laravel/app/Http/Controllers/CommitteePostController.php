<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteePost\DestroyCommitteePostRequest;
use App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
use App\Http\Requests\CommitteePost\UpdateCommitteePostRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\Message;
use App\Models\Options;
use App\Services\AttachmentService;
use App\Services\MessageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommitteePostController extends Controller
{
    private AttachmentService $attachmentService;

    private MessageService $messageService;

    public function __construct(AttachmentService $attachmentService, MessageService $messageService)
    {
        $this->attachmentService = $attachmentService;
        $this->messageService = $messageService;
    }

    /**
     * @throws AuthorizationException
     */
    public function create(Committee $committee): View
    {
        $this->authorize('create', [CommitteePost::class, $committee]);

        $post = new CommitteePost;
        $post['committee'] = $committee;

        $data = [
            'post' => $post,
            'action' => 'Create',
            'access_levels' => Options::access_levels(),
            'title' => 'Create a Committee Post',
        ];

        return view('committee_post_form', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreCommitteePostRequest $request, Committee $committee): RedirectResponse
    {
        $this->authorize('create', [CommitteePost::class, $committee]);

        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;
        $post->author_name = Auth::user()->name;

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

        return redirect()->route('committee_post_edit_form', [$committee->slug, $post->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Committee $committee, CommitteePost $committeePost): View
    {
        $this->authorize('update', [CommitteePost::class, $committeePost]);

        $committeePost->load('creator', 'committee', 'attachments');

        if (Message::where('source_url', env('APP_URL').'/committee/'.$committee->slug.'/post/'.$committeePost->slug)->exists()) {
            $existing_message = Message::where('source_url', env('APP_URL').'/committee/'.$committee->slug.'/post/'.$committeePost->slug)->first();
        } else {
            $existing_message = false;
        }

        return view('committee_post_form', [$committee->slug, $committeePost->slug], [
            'data' => [
                'post' => $committeePost,
                'action' => 'Edit',
                'existing_message' => $existing_message,
                'access_levels' => Options::access_levels(),
                'title' => 'Edit '.$committeePost->title,
            ],
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateCommitteePostRequest $request,
        Committee $committee, CommitteePost $committeePost): RedirectResponse
    {
        $this->authorize('update', [CommitteePost::class, $committeePost]);

        $committeePost->fill($request['post']);
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

        return redirect()->route('committee_post_edit_form', [$committee->slug, $committeePost->slug]);
    }

    public function show(Committee $committee, CommitteePost $committeePost): View
    {
        $data = [];
        $data['committeepost'] = $committeePost->loadWithoutGlobalScopes(['creator', 'committee']);
        $user = Auth::user();

        $data['canManage'] = 0;
        if ($user->hasRole('committee') &&
            $user->hasPermissionTo('manage committee') ||
            $user->hasRole('super-admin') ||
            $user->id == $data['committeepost']->user_id
        ) {
            $data['canManage'] = 1;
        }

        $source_url = env('APP_URL').'/committee/'.$committee->slug.'/post/'.$committeePost->slug;

        if (Message::where('source_url', $source_url)->exists()) {
            $data['existing_message'] = Message::where('source_url', $source_url)->first();
        } else {
            $data['existing_message'] = false;
        }

        $data['title'] = $committeePost->title;

        $data['next'] = CommitteePost::where('updated_at', '>', $committeePost->updated_at)
            ->where('committee_id', $committeePost->committee_id)
            ->where('live', 1)
            ->orderBy('updated_at')
            ->first();

        $data['previous'] = CommitteePost::where('updated_at', '<', $committeePost->updated_at)
            ->where('committee_id', $committeePost->committee_id)
            ->where('live', 1)
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('committee_post', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyCommitteePostRequest $request,
        Committee $committee, CommitteePost $committeePost): RedirectResponse
    {
        $this->authorize('delete', [CommitteePost::class, $committeePost]);

        CommitteePost::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (CommitteePost $post) {
                $post->delete();
            });

        Session::flash('success', 'Committee '.
            Str::plural('post', count($request->id)).' deleted.');

        return redirect()->route('committee', $committee->slug);
    }
}
