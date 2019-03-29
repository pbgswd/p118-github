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
    public function index(\App\Models\Topic $topic)
    {
        $data = [];

        /*
            A thing for manipulating sort order
            same page page=2
            order by clause,
            ascending, descending
        */

        $topics = Topic::orderBy('sort_order', 'ASC')->paginate(20);

        return view('admin.listtopics', ['data'=>array('topics'=>$topics )]);
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
        $rules = [
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.scope' => 'required',
            'topic.sort_order' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect(route('topic_create'))
                ->withErrors($validator)
                ->withInput();
        }

        $topic = new Topic($request->input('topic'));

        $topic->save();

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
        $rules = [
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.scope' => 'required',
            'topic.sort_order' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('topic_edit'))
                ->withErrors($validator)
                ->withInput();
        }
        $topic->fill($request['topic']);
        $topic->save();

        Session::flash('success', "You have edited the topic");
        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Topic $topic)
    {

        // what to do with content under said topic?
        //delete data
       // dd($request->all());

        Topic::destroy($request['id']);

        Session::flash('success', str_plural('Topic', count($request['id'])) . ' deleted.');

        return redirect()->route('topics_list');

    }
}
