<?php

namespace App\Http\Controllers;

use App\Http\Requests\Topic\DestroyTopicRequest;
use App\Http\Requests\Topic\StoreTopicRequest;
use App\Http\Requests\Topic\UpdateTopicRequest;
use App\Models\Post;
use App\Models\Topic;
use App\Services\AttachmentService;
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
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * @return Factory|View
     */
    public function list()
    {
        // public
        if (Auth::check()) {
            $topics = Topic::sortable()->with('tagged')->orderBy('sort_order', 'desc')->paginate(10);
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
        if (false === Auth::check() && $topic->access_level != 'public'){
            Session::flash('warning', "Login to view " . $topic->name);
            return redirect()->route('topics');
        }
        $topic->attachments = $topic->attachments->sortByDesc('created_at');
        $topic->pages = $topic->pages->sortByDesc('created_at');
        $topic->posts = $topic->posts->sortByDesc('created_at');

        $data = ['topic' => $topic];

        return view('topic', ['data' => $data]);
    }

}
