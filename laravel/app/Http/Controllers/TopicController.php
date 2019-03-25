<?php

namespace App\Http\Controllers;


use DB;
use Validator;
use App\Models\Topic;
//use App\Http\Requests;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;




class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view('admin.listtopics', ['data'=>$data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topic = new \App\Models\Topic;
        return view('admin.topic', ['data'=>['topic'=>$topic, 'action'=>'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,
            [
                'topic.name' => 'required'
            ]);

        $topic = new Topic($request->input('topic'));

        $topic->save();

        flash()->success('You have created this topic.');
        return redirect()->route('topic_edit', [$topic->slug]);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Models\Topic $topic)
    {

        //edit version of form for initial loading
        $data = ['topic'=>$topic, 'action'=>'Edit'];
        return view('admin.topic', ['data'=> $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        // form submission from update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        //delete data
    }
}
