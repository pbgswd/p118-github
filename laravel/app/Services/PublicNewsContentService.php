<?php

namespace App\Services;

use App\Models\Topic;

class PublicNewsContentService
{
    public function getNewsPages()
    {
        return Topic::with('public_news_pages')->get();
    }

    public function getNewsPosts()
    {
        return Topic::with('public_news_posts')->get();
    }
}
