<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\DestroyPost;
use App\Http\Requests\Posts\StorePost;
use App\Http\Requests\Posts\UpdatePost;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        //admin
        $this->authorize('viewAny', Auth::user());

        $posts = Post::sortable()->with('tagged')->paginate(20);

        return view('admin.listposts', ['data' => array('posts' => $posts)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request)
    {
        //public
        //todo post control public & members content
        $posts = Post::sortable()->with('tagged')->paginate(10);

        return view('posts', ['data' => array('posts' => $posts)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $post = new post;
        $post->topics;
        $topics = Topic::all();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.post', ['data' => ['post' => $post, 'assignedTopics' => [], 'topics' => $topics, 'access_levels' => $access_levels, 'action' => 'Create']]);
    }

    /**
     * @param StorePost $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePost $request)
    {

        $this->authorize('create', Auth::user());

        $post = new Post($request->input('post'), $request->input('tags'));

        $post->user_id = Auth::id();
        $post->save();

        if (!empty($request->input('post.topic_id'))) {
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
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        // public
        //todo control display of info, public or members
        $post->load('user', 'topics');
        $data = ['post' => $post];

        return view('post', ['data' => $data]);
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Post $post)
    {
        $this->authorize('update', Auth::user());

        $post->user;

        $assignedTopics = [];
        foreach ($post->topics as $topic) {
            $assignedTopics[] = $topic->pivot->topic_id;
        }

        $topics = Topic::all();
        $access_levels = $this->getFormOptions(['access_levels']);

        $data = ['post' => $post, 'topics' => $topics, 'assignedTopics' => $assignedTopics, 'access_levels' => $access_levels, 'action' => 'Edit'];

        return view('admin.post', ['data' => $data]);
    }

    /**
     * @param UpdatePost $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePost $request, Post $post)
    {
        $this->authorize('update', Auth::user());

        $data = $request['post'];

        $post->fill($data);
        $post->save();

        if (empty($data['topic_id'])) {
            $assignedTopics = [];
            foreach ($post->topics as $topic) {
                $assignedTopics[] = $topic->pivot->topic_id;
            }
            $post->topics()->detach($assignedTopics);
        } else {
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
     * @param DestroyPost $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyPost $request)
    {
        $this->authorize('delete', Auth::user());

        $post = Post::find($request->id)->first();

        $post->untag();

        $assignedTopics = [];
        foreach ($post->topics as $topic) {
            $assignedTopics[] = $topic->pivot->topic_id;
        }
        $post->topics()->detach($assignedTopics);

        post::destroy($request->id);

        Session::flash('success', Str::plural('post', count($request->id)) . ' deleted.');

        return redirect()->route('posts_list');
    }

}
