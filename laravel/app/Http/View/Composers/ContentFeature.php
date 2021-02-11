<?php

namespace App\Http\View\Composers;

use App\Models\Feature;
use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
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

        $topics = Topic::where([['live', 1],['landing_page', 1]])
            ->orderBy('sort_order', 'desc')
            ->get();
        $posts = Post::where([['live', 1],['landing_page', 1]])
            ->orderBy('updated_at', 'desc')
            ->with('topics')
            ->get();
        $pages = Page::where([['live', 1],['landing_page', 1]])
            ->orderBy('updated_at', 'desc')
            ->with('topics')
            ->get();
        $features = Feature::where('live', 1)
            ->orderBy('date', 'desc')
            ->get();

        $user = Auth::user();
        $user->load('user_info');

        $data = [
            'topics' => $topics,
            'posts' => $posts,
            'pages' => $pages,
            'features' => $features,
            'user' => $user,
            ];

        $view->with('data', $data);
    }
}
