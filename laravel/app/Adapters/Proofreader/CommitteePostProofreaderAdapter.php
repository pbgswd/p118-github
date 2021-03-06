<?php

namespace App\Adapters\Proofreader;

use App\Models\CommitteePost;

class CommitteePostProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = CommitteePost::class;
        $this->contentName = 'CommitteePost';
    }

    public function getMeta(): array
    {
        //Committee Model - specific to this class
        return [
            self::NAME => 'Committee Posts',
            self::PUB_ROUTE_LIST => 'committee',
            self::ADMIN_ROUTE_LIST => 'committee_posts_list',
            self::PUB_ROUTE => 'public_committee_post_show',
            self::ADMIN_ROUTE => 'admin_committee_post_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        //todo get committee for route
        return route('admin_committee_post_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('committee', $row['slug']);
    }

}



