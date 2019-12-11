<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CommitteePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Committee $committee)
    {
        $data = [];
        $data['committee'] = $committee;
        $data['posts'] = CommitteePost::sortable()->orderBy('created_at')->paginate(10);

        return view('admin.committee_posts_list', ['data'=>array('data'=>$data)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Committee $committee)
    {
        $post = new CommitteePost;
        $post['committee'] = $committee;

        return view('admin.committee_post', ['data' => ['post' => $post, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Committee $committee, User $user)
    {
        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;
        $post->user_id = Auth::id();

        $post->save();

        Session::flash('success', "You have saved a new post in " . $committee->name);

        return redirect()->route('committee_post_edit', [$committee->slug, $post->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommitteePost  $committeePost
     * @return \Illuminate\Http\Response
     */
    public function show(Committee $committee, CommitteePost $committeePost)
    {
         $committeePost->creator;
         $committeePost->committee;

        $data['committeepost'] = $committeePost;
        $data['action'] = 'Add';

        return view('committee_post', ['data'=> $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommitteePost  $committeePost
     * @return \Illuminate\Http\Response
     */
    public function edit(Committee $committee, CommitteePost $committeePost)
    {
        $committeePost->creator;
        $data['post'] = $committeePost;
        $data['action'] = 'Edit';

        return view('admin.committee_post', ['data' => $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommitteePost  $committeePost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommitteePost $committeePost)
    {
        dd(__METHOD__);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommitteePost  $committeePost
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommitteePost $committeePost)
    {
        dd(__METHOD__);
    }
}
