<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommitteePostCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @param User $user
     * @return void
     */
    public function store(Request $request, Committee $committee, CommitteePost $committeePost)
    {
        //todo form validator for committee post comment controller store method

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
}
