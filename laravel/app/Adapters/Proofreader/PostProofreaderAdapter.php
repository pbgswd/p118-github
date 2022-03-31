<?php

namespace App\Adapters\Proofreader;

use App\Models\Post;

class PostProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Post::class;
        $this->contentName = 'Post';
    }

    public function getMeta(): array
    {
        //Post Model - specific to this class
        return [
            self::NAME => 'Posts',
            self::PUB_ROUTE_LIST => 'posts',
            self::ADMIN_ROUTE_LIST => 'post_list',
            self::PUB_ROUTE => 'post_show',
            self::ADMIN_ROUTE => 'post_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('post_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('post_show', $row['slug']);
    }

}



