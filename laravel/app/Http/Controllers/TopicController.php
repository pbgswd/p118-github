<?php

namespace App\Http\Controllers;

use App\Http\Requests\Topic\DestroyRequest;
use App\Http\Requests\Topic\StoreRequest;
use App\Http\Requests\Topic\UpdateRequest;
use App\Models\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $topics = Topic::sortable()->with('tagged')->paginate(20);

        return view('admin.listtopics', ['data'=>array('topics'=>$topics )]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $topics = Topic::sortable()->with('tagged')->paginate(10);

        return view('topics', ['data'=>array('topics'=>$topics )]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return Response
     */
    public function show(Topic $topic)
    {
        $topic->pages;
        $topic->posts;
        $data = ['topic'=>$topic];

        return view('topic', ['data'=> $data]);
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

        return view('admin.topic', ['data' => ['topic' => $topic, 'action' => 'Create']]);
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

        $topic->image = $this->uploadImage($request);

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
     * @param  \App\Topic  $topic
     * @return Response
     */
    public function edit(Topic $topic)
    {
        $data = ['topic'=>$topic, 'action'=>'Edit'];

        return view('admin.topic', ['data'=> $data]);
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

        $data['image'] = $this->uploadImage($request);

        if (isset( $request['topic']['delete_image']))
        {
            Storage::disk('public')->delete( $request->topic['image'] );
            Session::flash('info', "You have deleted " . $data['image']);
            $data['image'] = NULL;
        }

        $topic->fill($data);
        $topic->save();

        if (empty($request->tags))
        {
            $topic->untag();
        }
        else
        {
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

        if ($topic->image) {
            Storage::disk('public')->delete($topic->image);
        }

        $topic->untag();

        $topic->pages()->detach();
        $topic->posts()->detach();

        Topic::destroy($request->id);

        Session::flash('success', Str::plural('Topic', count($request->id)) . ' deleted.');

        return redirect()->route('topics_list');
    }

    protected function uploadImage(FormRequest $request)
    {
        if (!$request->image) {
            return null;
        }

        $imageName = $request->image->getClientOriginalName();

        if (!$request->image->storeAs('public', $imageName)) {
            Session::flash('warning', "Did not store " . $imageName);

            return null;
        }

        return $imageName;
    }

}
