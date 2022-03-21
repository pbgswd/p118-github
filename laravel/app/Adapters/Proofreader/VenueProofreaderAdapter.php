<?php

namespace App\Adapters\Proofreader;

use App\Models\Venue;

class VenueProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Venue::class;
        $this->contentName = 'Venue';
    }

    public function getMeta(): array
    {
        //Venue Model - specific to this class
        return [
            self::NAME => 'Venues',
            self::PUB_ROUTE_LIST => 'venues',
            self::ADMIN_ROUTE_LIST => 'venues_list',
            self::PUB_ROUTE => 'venue',
            self::ADMIN_ROUTE => 'venue_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('venue_edit', $row['slug']);
    }

    public function getPublicRoute($row): string
    {
        return route('venue', $row['slug']);
    }
}
