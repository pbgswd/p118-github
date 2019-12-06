<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $phone_numer
 * @property string $label
 * @property boolean $primary
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */

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
