<?php


namespace App\Services;


use App\Models\Topic;

class AllNewsContentService
{
    public function getNewsPages()
    {
        return Topic::with('news_pages')->get();
    }

    public function getNewsPosts()
    {
        return Topic::with('news_posts')->get();
    }
}
