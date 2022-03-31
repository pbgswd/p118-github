<?php

namespace App\Adapters\Proofreader;

use App\Models\Memoriam;

class MemoriamProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Memoriam::class;
        $this->contentName = 'Memoriam';
    }

    public function getMeta(): array
    {
        //Memoriam Model - specific to this class
        return [
            self::NAME => 'In Memoriam',
            self::PUB_ROUTE_LIST => 'memoriam_list',
            self::ADMIN_ROUTE_LIST => 'admin_memoriam_list',
            self::PUB_ROUTE => 'memoriam',
            self::ADMIN_ROUTE => 'admin_memoriam_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('admin_memoriam_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('memoriam', $row['slug']);
    }

}



