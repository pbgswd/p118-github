<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalSearch extends Model
{
    public $sortable = [
        'id',
        'name',
        'title',
        'created_at',
        'updated_at',
    ];
}
