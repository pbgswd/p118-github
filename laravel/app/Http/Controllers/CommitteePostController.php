<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\CommitteePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function create()
    {
        $post = new CommitteePost;
        $post['user_id'] = Auth::id();
        $post['committee'] = $post->committee();
dd($post);
        return view('admin.committee_post', ['data' => ['post' => $post, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommitteePost  $committeePost
     * @return \Illuminate\Http\Response
     */
    public function show(CommitteePost $committeePost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommitteePost  $committeePost
     * @return \Illuminate\Http\Response
     */
    public function edit(CommitteePost $committeePost)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommitteePost  $committeePost
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommitteePost $committeePost)
    {
        //
    }
}
