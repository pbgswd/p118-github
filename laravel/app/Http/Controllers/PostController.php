<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\DestroyPost;
use App\Http\Requests\Posts\StorePost;
use App\Http\Requests\Posts\UpdatePost;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::sortable()->with('tagged')->paginate(20);

        return view('admin.listposts', ['data' => array('posts' => $posts )]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $posts = Post::sortable()->with('tagged')->paginate(10);

        return view('posts', ['data'=>array('posts'=>$posts )]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new post;
        $post->topics;
        $topics = Topic::all();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.post', ['data' => ['post' => $post,  'assignedTopics' => [], 'topics' => $topics, 'access_levels' => $access_levels,  'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePost $post
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $post = new Post($request->input('post'), $request->input('tags'));

        $post->save();

        if(!empty($request->input('post.topic_id'))) {
            $post->topics()->sync($request->input('post.topic_id'));
        }

        if (!empty($request->tags)) {
            $post->tag(trim($request->tags, ','));
        }

        Session::flash('success', "You have saved a new post");

        return redirect()->route('post_edit', [$post->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('user', 'topic', 'page');
        $data = ['post' => $post];

        return view('post', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $post->user;

        $assignedTopics = [];
        foreach($post->topics as $topic)
        {
            $assignedTopics[] = $topic->pivot->topic_id;
        }

        $topics = Topic::all();
        $access_levels = $this->getFormOptions(['access_levels']);

        $data = ['post' => $post, 'topics' => $topics, 'assignedTopics' => $assignedTopics, 'access_levels' => $access_levels, 'action' => 'Edit'];

        return view('admin.post', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePost $request, Post $post)
    {
        if ($gate = Gate::allows('edit articles', $post)) {
            // echo 'Allowed';
        } else {
            abort(403);
        }

        $data = $request['post'];

        $post->fill($data);
        $post->save();

        if(empty($data['topic_id'])){
            $assignedTopics = [];
            foreach($post->topics as $topic)
            {
                $assignedTopics[] = $topic->pivot->topic_id;
            }
            $post->topics()->detach($assignedTopics);
        }
        else
        {
            $post->topics()->sync($data['topic_id']);
        }

        if (empty($request->tags)) {
            $post->untag();
        } else {
            $post->retag(trim($request->tags, ','));
        }

        Session::flash('success', "You have edited the post");

        return redirect()->route('post_edit', [$post->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPost $request)
    {
        $post = Post::find($request->id)->first();

        $post->untag();

        $assignedTopics = [];
        foreach($post->topics as $topic)
        {
            $assignedTopics[] = $topic->pivot->topic_id;
        }
        $post->topics()->detach($assignedTopics);

        post::destroy($request->id);

        Session::flash('success', Str::plural('post', count($request->id)) . ' deleted.');

        return redirect()->route('posts_list');
    }

}
