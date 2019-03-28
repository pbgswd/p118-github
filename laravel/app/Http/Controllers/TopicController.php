<?php

namespace App\Http\Controllers;


use DB;
use Session;
use Validator;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
        //echo __METHOD__ . "method, line " . __LINE__ ."\n";

        $rules = [
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.scope' => 'required',
            'topic.sort_order' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        //echo __METHOD__ . "method, line " . __LINE__ ."\n";

        if ($validator->fails()) {

           // need to identify which field has failed, to put it into an error messge with
           // Session::flash('warning', "bla bla 1");
           // Session::flash('info', "bla bla 2");
           // dd($validator->errors());

           // echo __METHOD__ . "method, line " . __LINE__ ."\n";

            return redirect('admin/topic')
                ->withErrors($validator)
                ->withInput();

        //echo __METHOD__ . "method, line " . __LINE__ ."\n";

        }

      //  echo __METHOD__ . "method, line " . __LINE__ ."\n";

        $topic = new Topic($request->input('topic'));

        $topic->save();

        //echo __METHOD__ . "method, line " . __LINE__ ."\n";

        Session::flash('success', "You have saved a new topic");
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

        // what to do with content under said topic?
        //delete data
        Topic::destroy($request['id']);

        Session::flash('success', str_plural('Topic', count($request['id'])) . ' deleted.');
        return redirect()->route('listtopics');

    }
}
