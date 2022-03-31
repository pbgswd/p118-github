<?php

namespace App\Adapters\Proofreader;

use App\Models\Meeting;

class MeetingProofreaderAdapter extends BaseProofreaderAdapter
{
    public function __construct()
    {
        $this->contentClass = Meeting::class;
        $this->contentName = 'Meeting';
    }

    public function getMeta(): array
    {
        //Meeting Model - specific to this class
        return [
            self::NAME => 'Meetings',
            self::PUB_ROUTE_LIST => 'list_meetings',
            self::ADMIN_ROUTE_LIST => 'meetings_list',
            self::PUB_ROUTE => 'meeting',
            self::ADMIN_ROUTE => 'meeting_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('meeting_edit', $row['id']);
    }

    public function getPublicRoute($row): string
    {
        return route('meeting', $row['id']);
    }

}



