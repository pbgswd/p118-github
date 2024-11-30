<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageCategory extends Model
{
    protected $table = 'message_categories';

    public $fillable = [
        'message_id',
        'type',
        'name',
    ];


}
