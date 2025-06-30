<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Post;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PostController extends Controller
{
    private AttachmentService $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function list(Request $request): View
    {
        if (Auth::check()) {
            $posts = Post::where('live', 1)
                ->with('topics')
                ->paginate(9);
        } else {
            $posts = Post::where([['access_level', AccessLevelConstants::PUBLIC], ['live', 1]])
                ->with('topics')
                ->paginate(9);
        }

        return view('posts', ['data' => ['posts' => $posts, 'title' => 'Posts']]);
    }

    public function show(Post $post): View
    {
        if (Auth::check() === false
            && $post->access_level != AccessLevelConstants::PUBLIC) {
            Session::flash('warning', 'Login to view this post.');

            return view('auth.login');
        }

        $post->load('user', 'topics', 'attachments');
        $data = ['post' => $post, 'title' => $post->title];

        return view('post', ['data' => $data]);
    }
}
