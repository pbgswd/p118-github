<?php

namespace App\Http\View\Composers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use App\Repositories\UserRepository;
use DB;
use Illuminate\View\View;

/**
 * Class ContentFeature
 * @property $compose
 * @property View
 * @param View $view
 */
class ContentFeature
{
    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $topicFilter = function ($query) {
            $query->where('slug', 'news');
        };
//todo expand filter for home page view
        $topics = Topic::where('live', 1)->orderBy('created_at', 'desc')->take(10)->get();
        $posts = Post::where('live', 1)->where('in_menu', 1)->orderBy('created_at', 'desc')->take(10)->get();
        $pages = Page::where('live', 1)->where('in_menu', 1)->orderBy('created_at', 'desc')->take(10)->get();

        $data = ['topics' => $topics, 'posts' => $posts, 'pages' => $pages];

       // $posts->short_body = substr($posts->content, 0, 60) . '...';
            // dangerous! body is in html -- truncation could split a tag

        // dd($data);

        $view->with('data', $data);
    }

}
