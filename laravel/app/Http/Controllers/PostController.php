<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Post;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request)
    {
        if (Auth::check()) {
            $posts = Post::sortable()->with('tagged')->paginate(10);
        }
        else {
            $posts = Post::sortable()->where('access_level', '=', AccessLevelConstants::PUBLIC)->with('tagged')->paginate(10);
        }

        return view('posts', ['data' => ['posts' => $posts]]);
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
        //todo policy control post public view
        $post->load('user', 'topics', 'attachments');
        $data = ['post' => $post];

        return view('post', ['data' => $data]);
    }

}
