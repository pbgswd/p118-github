<?php

namespace App\Adapters\Proofreader;

use App\Models\Organization;

class OrganizationProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Organization::class;
        $this->contentName = 'Organization';
    }

    public function getMeta(): array
    {
        // Organization Model - specific to this class
        return [
            self::NAME => 'Organizations',
            self::PUB_ROUTE_LIST => 'organizations',
            self::ADMIN_ROUTE_LIST => 'organizations_list',
            self::PUB_ROUTE => 'organization',
            self::ADMIN_ROUTE => 'organization_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('organization_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('organization', $row['slug']);
    }
}
