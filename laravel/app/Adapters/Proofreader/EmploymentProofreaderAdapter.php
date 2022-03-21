<?php

namespace App\Adapters\Proofreader;

use App\Models\Employment;

class EmploymentProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Employment::class;
        $this->contentName = 'Employment';
    }

    public function getMeta(): array
    {
        //Employment Model - specific to this class
        return [
            self::NAME => 'Jobs',
            self::PUB_ROUTE_LIST => 'jobs_list',
            self::ADMIN_ROUTE_LIST => 'admin_employment_list',
            self::PUB_ROUTE => 'job_view',
            self::ADMIN_ROUTE => 'admin_employment_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('admin_employment_edit', $row['id']);
    }

    public function getPublicRoute($row): string
    {
        return route('job_view', $row['id']);
    }
}
