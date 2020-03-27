<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $posts = Post::sortable()->with('tagged')->paginate(10);

        return view('posts', ['data' => array('posts' => $posts)]);
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
        $post->load('user', 'topics', 'attachments');
        $data = ['post' => $post];

        return view('post', ['data' => $data]);
    }

}
