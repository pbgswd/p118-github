<?php

namespace App\Http\View\Composers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\View\View;

/**
 * Class ContentFeature.
 * @property $compose
 * @property View
 * @param View $view
 */
class ContentFeature
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $topicFilter = function ($query) {
            $query->where('slug', 'news');
        };

        $topics = Topic::where('landing_page', 1)
            ->orderBy('sort_order', 'desc')
            ->get();
        $posts = Post::where('landing_page', 1)
            ->orderBy('updated_at', 'desc')
            ->with('topics')->get();
        $pages = Page::where('landing_page', 1)
            ->orderBy('updated_at', 'desc')
            ->with('topics')->get();

        $data = [
            'topics' => $topics,
            'posts' => $posts,
            'pages' => $pages,
            ];

        $view->with('data', $data);
    }
}
