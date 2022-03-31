<?php

namespace App\Adapters\Proofreader;

use App\Models\Agreement;

class AgreementProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Agreement::class;
        $this->contentName = 'Agreement';
    }

    public function getMeta(): array
    {
        //Agreement Model - specific to this class
        return [
            self::NAME => 'Agreements',
            self::PUB_ROUTE_LIST => 'agreements_list_public',
            self::ADMIN_ROUTE_LIST => 'agreements_list',
            self::PUB_ROUTE => 'agreement_show',
            self::ADMIN_ROUTE => 'agreement_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('agreement_edit', $row['id']);
    }

    public function getPublicRoute($row): string
    {
        return route('agreement_show', $row['id']);
    }

}



