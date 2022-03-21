<?php

namespace App\Adapters\Proofreader;

use App\Models\Page;

class PageProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Page::class;
        $this->contentName = 'Page';
    }

    public function getMeta(): array
    {
        //Page Model - specific to this class
        return [
            self::NAME => 'Pages',
            self::PUB_ROUTE_LIST => 'pages',
            self::ADMIN_ROUTE_LIST => 'pages_list',
            self::PUB_ROUTE => 'page_show',
            self::ADMIN_ROUTE => 'page_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('page_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('page_show', $row['slug']);
    }
}
