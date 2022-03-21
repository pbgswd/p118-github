<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Post;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @param Request $request
     * @return View
     */
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

        return view('posts', ['data' => ['posts' => $posts]]);
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Post $post)
    {
        // $this->authorize('view', Post::class);

        if (false === Auth::check() && $post->access_level != AccessLevelConstants::PUBLIC) {
            Session::flash('warning', 'Login to view this post.');

            return redirect('login');
        }

        $post->load('user', 'topics', 'attachments');
        $data = ['post' => $post];

        return view('post', ['data' => $data]);
    }
}
