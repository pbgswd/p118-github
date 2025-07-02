<?php

namespace App\Composers;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\View\View;

/**
 * Class ViewComposers.
 */
class ViewComposers
{
    public function topics(View $view)
    {
        $topics = Topic::where('in_menu', 1)
            ->orderBy('sort_order', 'ASC')
            ->get();
        $view->with('topics', $topics);
    }

    /**
     * get the main feature article, latest post.
     */
    public function contentFeature(View $view)
    {
        $topicFilter = function ($query) {
            $query->where('slug', 'news');
        };
        $post = Post::published()->whereHas('topic', $topicFilter)
            ->with('topic')
            ->orderBy('id', 'desc')
            ->first();
        // todo clean post->body so markup doesnt break
        $post->short_body = substr($post->body, 0, 3000).'...';
        // dangerous! body is in html -- truncation could split a tag

        $view->with('cont', $post);
    }

    public function postsPreviousNext(View $view)
    {
        /*
          take current id/slug from post
          use id/slug to get 1 slug for post prior to current, and 1 more current.
          if it is the first post, display link to earlier post, and you are at the first post
          if it is the last post,  display newer post, and you are at the oldest post
        */
        $prevNext = 1;
        $view->with('prevNext', $prevNext);
    }

    public function adminTopicsMenu(View $view)
    {
        $menu = Topic::where('is_page', 0)
            ->orderBy('sort_order', 'ASC')
            ->get();
        $view->with('admin_topics_menu', $menu);
    }
}
