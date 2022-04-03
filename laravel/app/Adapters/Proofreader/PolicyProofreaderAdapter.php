<?php

namespace App\Adapters\Proofreader;

use App\Models\Policy;

class PolicyProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Policy::class;
        $this->contentName = 'Policy';
    }

    public function getMeta(): array
    {
        //Policy Model - specific to this class
        return [
            self::NAME => 'Policies',
            self::PUB_ROUTE_LIST => 'policies_list_public',
            self::ADMIN_ROUTE_LIST => 'policies_list',
            self::PUB_ROUTE => 'policies_show_public',
            self::ADMIN_ROUTE => 'admin_policy_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('policies_list', $row['id']);
    }

    public function getPublicRoute($row): string
    {
        return route('policy_show_public', $row['id']);
    }
}
