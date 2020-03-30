<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteePostComment\DestroyCommitteePostCommentRequest;
use App\Http\Requests\CommitteePostComment\StoreCommitteePostCommentRequest;
use App\Http\Requests\CommitteePostComment\UpdateCommitteePostCommentRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CommitteePostCommentController extends Controller
{
    /**
     * @param CommitteePost $committeePost
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CommitteePost $committeePost)
    {
        //todo enable permission
        //$this->authorize('create', Auth::user());
        $data = [];
        $data['committee_post_comment'] = new CommitteePostComment;
        $data['committee_post_comment']->load('committee', 'committee_post');
        $data['committee_post'] = $committeePost;
        $data['committee'] = $data['committee_post_comment']->committee;
        $data['action'] = 'Create';
        return view('admin.committee_post_comment', ['data' => $data]);
    }

    /**
     * @param CommitteePostComment $any_committee_post_comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CommitteePostComment $any_committee_post_comment)
    {
        // $this->authorize('update', Auth::user());

        $data = [];
        $any_committee_post_comment->load('comment_author', 'committee_post', 'committee');
        // $data['post'] = $any_committee_post;
        $data['post_comment'] = $any_committee_post_comment;

        $data['action'] = 'Edit';
        return view('admin.committee_post_comment', ['data' => $data]);

        //todo idea for loading up

/**
        $post->load([
            'post_comments' => function ($query) {
                return $query->withoutGlobalScope(LiveScope::class);
            },
            'committee' => function ($query) {
                return $query->withoutGlobalScope(LiveScope::class);
            },
            'creator' => function ($query) {
                return $query->withoutGlobalScope(LiveScope::class);
            },
        ]);
*/

    }

    /**
     * @param StoreCommitteePostCommentRequest $request
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCommitteePostCommentRequest $request, Committee $committee, CommitteePost $committeePost)
    {
        //// $this->authorize('create', Auth::user());
        $postComment = new CommitteePostComment($request->input('comment'));
        $postComment->committee_id = $committee->id;
        $postComment->user_id = Auth::id();
        $postComment->post_id = $committeePost->id;
        $postComment->parent_id = null;
        $postComment->save();

        Session::flash('success', "You have added your comment to " . $committeePost->title);

        return redirect()->route('committee_post_show', [$committee->slug, $committeePost->slug]);
    }


    /**
     * @param UpdateCommitteePostCommentRequest $request
     * @param $post
     * @param CommitteePostComment $any_committee_post_comment
     * @return RedirectResponse
     */
    public function update(UpdateCommitteePostCommentRequest $request, $post, CommitteePostComment $any_committee_post_comment): RedirectResponse
    {
        // $this->authorize('update', Auth::user());
        $any_committee_post_comment->fill($request->input('comment'));
        $any_committee_post_comment->save();

        Session::flash('success', "You have edited the post");

        return redirect()->route('committee_post_comment_edit', [$post->slug, $any_committee_post_comment->id]);
    }

    /**
     * @param DestroyCommitteePostCommentRequest $request
     * @return RedirectResponse
     */
    public function destroy(DestroyCommitteePostCommentRequest $request): RedirectResponse
    {
        // $this->authorize('destroy', Auth::user());
        CommitteePostComment::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (CommitteePostComment $post_comment) {
                $post_comment->delete();
            });

        Session::flash('success', 'Committee Post ' . Str::plural('Comment', count($request->id)) . ' deleted.');

        return view('admin.committee_post', ['data' => $post_comment->post_id]);
    }
}
