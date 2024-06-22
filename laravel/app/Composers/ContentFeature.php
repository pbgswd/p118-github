<?php

namespace App\Composers;

use App\Models\Feature;
use App\Models\Options;
use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class ContentFeature.
 *
 * @property $compose
 * @property View
 *
 * @param  View  $view
 */
class ContentFeature
{
    public function compose(View $view)
    {
        $topics = Topic::where([['live', 1], ['landing_page', 1]])
            ->orderBy('sort_order', 'desc')
            ->get();
        $posts = Post::where([['live', 1], ['landing_page', 1]])
            ->orderBy('updated_at', 'desc')
            ->with('topics')
            ->get();
        $pages = Page::where([['live', 1], ['landing_page', 1]])
            ->orderBy('updated_at', 'desc')
            ->with('topics')
            ->get();
        $features = Feature::where([['live', 1], ['landing_page', 1], ['date', '<', NOW()]])
            ->orderBy('date', 'desc')
            ->get();

        $features->tn_str = Options::feature_thumb_values()['tn_str'];

        $user = Auth::user();
        $user->load('user_info');

        if ($user->user_info->image) {
            $user->user_info->thumb = Options::member_thumb_values()['tn_str'].$user->user_info->image ?? '';
        }

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
