<?php

namespace App\Http\View\Composers;

use App\Models\Post;
use App\Repositories\UserRepository;
use DB;
use Illuminate\View\View;

/**
 * Class ContentFeature
 * @property $compose
 */
class ContentFeature
{
    public function __construct()
    {

    }

    /**
     * get the main feature article, latest post.
     */
    public function compose(View $view)
    {
        $topicFilter = function ($query) {
            $query->where('slug', 'news');
        };
        $post = Post::orderBy('id', 'desc')
            ->first();
        $post->short_body = substr($post->content, 0, 60) . '...';
            // dangerous! body is in html -- truncation could split a tag
//dd($post);
        $view->with('post', $post);
    }

}
