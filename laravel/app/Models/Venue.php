<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;


class Venue extends Model
{
        use Sortable;

        public $sortable = [
        'id',
        'name',
        'image',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
        'created_at',
        'updated_at',
    ];

    protected $dates =
    [
        'created_at',
        'updated_at'
    ];

    protected $casts =
    [
        'in_menu'           => 'boolean',
        'allow_comments'    => 'boolean',
        'live'              => 'boolean',
    ];

}
