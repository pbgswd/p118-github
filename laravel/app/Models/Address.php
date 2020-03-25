<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int       $id
 * @property string    $unit
 * @property string    $street
 * @property string    $city
 * @property string    $province
 * @property string    $postal_code
 * @property string    $country
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 */
class Address extends Model
{
    /** @var string  */
    protected $guard_name = 'web';

    /** @var array  */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit',
        'street',
        'city',
        'province',
        'postal_code',
        'country',
    ];
}
