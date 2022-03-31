<?php

namespace App\Services;

use App\Models\Agreement;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AgreementService
{
    public function get_parent_list(): array
    {
        /**
         * return array
         */
        return DB::SELECT(
            "SELECT
                o.name AS display_name,
                o.slug AS route_parameter,
                'organization' AS route_name
            FROM agreements a
            JOIN agreement_agreement_handler aah ON a.id = aah.agreement_id
            JOIN organizations o ON aah.agreement_handler_id = o.agreement_handler_id
            UNION
            SELECT
                v.name AS display_name,
                v.slug AS route_parameter,
                'venue' AS route_name
            FROM agreements a
            JOIN agreement_agreement_handler aah ON a.id = aah.agreement_id
            JOIN venues v ON aah.agreement_handler_id = v.agreement_handler_id
            UNION
            SELECT
                a.title AS display_name,
                a.id AS route_parameter,
                'agreement_show' AS route_name
            FROM agreements a
            LEFT JOIN agreement_agreement_handler aah ON a.id = aah.agreement_id
            WHERE
                aah.agreement_id is null
            ORDER BY display_name"
        );
    }
}
