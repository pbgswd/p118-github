<?php

namespace App\Adapters\Proofreader;

use App\Models\Bylaw;

class BylawProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Bylaw::class;
        $this->contentName = 'Bylaw';
    }

    public function getMeta(): array
    {
        //bylaw Model - specific to this class
        return [
            self::NAME => 'Constitution & Bylaws',
            self::PUB_ROUTE_LIST => 'bylaws_list_public',
            self::ADMIN_ROUTE_LIST => 'bylaws_list',
            self::PUB_ROUTE => 'bylaw_show',
            self::ADMIN_ROUTE => 'bylaw_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('admin_bylaw_edit', $row['id']);
    }

    public function getPublicRoute($row): string
    {
        return route('bylaw_show', $row['id']);
    }
}



