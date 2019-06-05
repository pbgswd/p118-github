<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{

    protected $guard_name = 'web';

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
        'phone_number',
        'label',
        'primary',
    ];
}
