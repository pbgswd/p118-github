<?php

namespace App\Adapters\Proofreader;

use App\Models\Committee;

class CommitteeProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Committee::class;
        $this->contentName = 'Committee';
    }

    public function getMeta(): array
    {
        //Committee Model - specific to this class
        return [
            self::NAME => 'Committees',
            self::PUB_ROUTE_LIST => 'committees',
            self::ADMIN_ROUTE_LIST => 'committees_list',
            self::PUB_ROUTE => 'committee',
            self::ADMIN_ROUTE => 'committee_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('committee_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('committee', $row['slug']);
    }

}



