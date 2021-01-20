<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Topic;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TopicController extends Controller
{
    /**
     * @return Factory|View
     */
    public function list()
    {
        // public
        if (Auth::check()) {
            $topics = Topic::sortable()
                ->with('tagged')
                ->orderBy('sort_order', 'desc')
                ->paginate(10);
        } else {
            $topics = Topic::sortable()
                ->where('access_level', '=', AccessLevelConstants::PUBLIC)
                ->with('tagged')
                ->paginate(10);
        }

        return view('topics', ['data' => ['topics' => $topics]]);
    }

    /**
     * @param Topic $topic
     * @return Factory|RedirectResponse|View
     */
    public function show(Topic $topic)
    {
        if (false === Auth::check() && $topic->access_level != AccessLevelConstants::PUBLIC) {
            Session::flash('warning', 'Login to view this topic.');

            return redirect('login');
        }

        $topic->attachments = $topic->attachments->sortByDesc('created_at');
        $topic->pages = $topic->pages->sortByDesc('created_at');
        $topic->posts = $topic->posts->sortByDesc('created_at');

        $data = ['topic' => $topic];

        return view('topic', ['data' => $data]);
    }
}
