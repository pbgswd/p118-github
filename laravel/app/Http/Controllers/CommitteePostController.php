<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommitteePostController extends Controller
{
    //todo implement policies for Committee post controller
    /**
     * Display a listing of the resource.
     *
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return Response
     */
    public function index(CommitteePost $committeePost, Committee $committee)
    {
        // $this->authorize('list', Auth::user());
        $data = [];
        $data['committee'] = $committee;
        $data['posts'] = CommitteePost::sortable()
            ->where('committee_id', '=', $committee->id)
            ->orderBy('created_at')
            ->paginate(10);

        return view('admin.committee_posts_list', ['data' => array('data' => $data)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Committee $committee)
    {
        // $this->authorize('create', Auth::user());
        $post = new CommitteePost;
        $post['committee'] = $committee;

        return view('admin.committee_post', ['data' => ['post' => $post, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Committee $committee
     * @param User $user
     * @return Response
     */
    public function store(Request $request, Committee $committee, User $user)
    {
        //$this->authorize('create', Auth::user());
        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;
        $post->user_id = Auth::id();

        $post->save();

        Session::flash('success', "You have saved a new post in " . $committee->name);

        return redirect()->route('committee_post', [$committee->slug, $post->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @param CommitteePostComment $committeePostComments
     * @return Response
     */
    public function show(Committee $committee, CommitteePost $committeePost, CommitteePostComment $committeePostComments)
    {
        // $this->authorize('create', Auth::user());
        $committeePost->load('creator', 'committee', 'post_comments.commentAuthor');

        $data['committeepost'] = $committeePost;
        $data['action'] = 'Add';
        $data['committeepost']->post_comments = $data['committeepost']->post_comments->sortByDesc('created_at');

        return view('committee_post', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return Response
     */
    public function edit(Committee $committee, CommitteePost $committeePost)
    {
        // $this->authorize('update', Auth::user());
        $committeePost->creator;
        $data['post'] = $committeePost;
        $data['action'] = 'Edit';

        return view('admin.committee_post', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $post blank parameter to handle order of arguments in url
     * @param CommitteePost $committeePost
     * @return Response
     */
    public function update(Request $request, $post, CommitteePost $committeePost)
    {
        // $this->authorize('update', Auth::user());
        $data = $request['post'];

        $committeePost->fill($data);
        $committeePost->save();

        Session::flash('success', "You have edited the post");

        $committeePost->committee;

        return redirect()->route('committee_post_edit', [$committeePost->committee->slug, $committeePost->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CommitteePost $committeePost
     * @return Response
     */
    public function destroy(CommitteePost $committeePost)
    {
        // $this->authorize('delete', Auth::user());
        dd(__METHOD__);
        // delete comments associated with it
        // delete the post

    }
}
