<?php

namespace App\Http\Controllers;

use App\Http\Requests\Topic\DestroyRequest;
use App\Http\Requests\Topic\StoreRequest;
use App\Http\Requests\Topic\UpdateRequest;
use App\Models\Topic;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;


class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $topics = Topic::sortable()->with('tagged', 'user')->paginate(20);

        return view('admin.listtopics', ['data' => array('topics' => $topics)]);
    }

    /**
     * @return Factory|View
     */
    public function list()
    {
        if (Auth::check()) {
            $topics = Topic::sortable()->with('tagged')->paginate(10);
        }
        else {
            $topics = Topic::sortable()->where('access_level', '=', 'public')->with('tagged')->paginate(10);
        }

        return view('topics', ['data' => array('topics' => $topics)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Topic $topic
     * @return Response
     */
    public function show(Topic $topic)
    {
        //todo check for access to topic by loading it.

        $topic->pages;
        $topic->posts;
        $data = ['topic' => $topic];

        return view('topic', ['data' => $data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $topic = new Topic;
        $topic['user_id'] = Auth::id();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.topic', ['data' => ['topic' => $topic, 'access_levels' => $access_levels, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $topic = new Topic($request->input('topic'), $request->input('tags'));

        $topic->save();

        if (!empty($request->tags)) {
            $topic->tag(trim($request->tags, ','));
        }
        Session::flash('success', "You have saved a new topic");

        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Topic $topic
     * @return Response
     */
    public function edit(Topic $topic)
    {
        $topic->user;

        $access_levels = $this->getFormOptions(['access_levels']);
        $data = ['topic' => $topic, 'access_levels' => $access_levels, 'action' => 'Edit'];

        return view('admin.topic', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Topic $topic)
    {
        $data = $request['topic'];

        $topic->fill($data);
        $topic->save();

        if (empty($request->tags)) {
            $topic->untag();
        } else {
            $topic->retag(trim($request->tags, ','));
        }

        Session::flash('success', "You have edited the topic");

        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @return RedirectResponse
     */
    public function destroy(DestroyRequest $request)
    {
        $topic = Topic::find($request->id)->first();

        $topic->untag();

        $topic->pages()->detach();
        $topic->posts()->detach();

        Topic::destroy($request->id);

        Session::flash('success', Str::plural('Topic', count($request->id)) . ' deleted.');

        return redirect()->route('topics_list');
    }
}
