<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guard_name = 'web';

    protected $dates =
        [
            'created_at',
            'updated_at'
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'unique_name',
    ];

    /**
     * relationships
     */

    // user

    // page

    // post

    // topic

    // member

}
