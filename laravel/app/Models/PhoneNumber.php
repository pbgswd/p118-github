<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $dates =
    [
        'created_at',
        'updated_at'
    ];

    protected $casts =
    [
        'primary' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
    [
        'user_id',
        'phone_number',
        'label',
        'primary',
    ];
}
