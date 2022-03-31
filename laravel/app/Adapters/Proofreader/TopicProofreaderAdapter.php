<?php

namespace App\Adapters\Proofreader;

use App\Models\Topic;

class TopicProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Topic::class;
        $this->contentName = 'Topic';
    }

    public function getMeta(): array
    {
        //Topic Model - specific to this class
        return [
            self::NAME => 'Topics',
            self::PUB_ROUTE_LIST => 'topics',
            self::ADMIN_ROUTE_LIST => 'topic_list',
            self::PUB_ROUTE => 'topic_show',
            self::ADMIN_ROUTE => 'topic_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('topic_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('topic_topic', $row['slug']);
    }

}



