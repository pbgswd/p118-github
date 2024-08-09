<?php

namespace App\Composers;

use App\Constants\AccessLevelConstants;
use App\Models\Feature;
use App\Models\Options;
use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;

class FrontPage
{
    public function compose(View $view): void
    {
        $posts = Post::where([['live', 1],
            ['front_page', 1],
            ['access_level', AccessLevelConstants::PUBLIC], ])
            ->orderBy('updated_at', 'desc')
            ->get();

        $pages = Page::where([['live', 1],
            ['front_page', 1],
            ['access_level', AccessLevelConstants::PUBLIC], ])
            ->orderBy('updated_at', 'desc')
            ->get();

        $features = Feature::where([
            ['live', 1],
            ['front_page', 1],
            ['access_level', AccessLevelConstants::PUBLIC],
            ['date', '<', NOW()],
        ])
            ->orderBy('date', 'desc')
            ->get();

        $data = [
            'news' => [
                'posts' => $posts,
                'pages' => $pages,
                'features' => $features,
            ],
            'options' => Options::feature_thumb_values(),
        ];

        $view->with('data', $data);
    }
}
