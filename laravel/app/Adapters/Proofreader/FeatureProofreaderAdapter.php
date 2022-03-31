<?php

namespace App\Adapters\Proofreader;

use App\Models\Feature;

class FeatureProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Feature::class;
        $this->contentName = 'Feature';
    }

    public function getMeta(): array
    {
        //Feature Model - specific to this class
        return [
            self::NAME => 'Features',
            self::PUB_ROUTE_LIST => 'features',
            self::ADMIN_ROUTE_LIST => 'admin_feature_list',
            self::PUB_ROUTE => 'feature',
            self::ADMIN_ROUTE => 'admin_feature_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('admin_feature_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('feature', $row['slug']);
    }

}



