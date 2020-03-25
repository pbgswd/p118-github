<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int       $id
 * @property DateTime  $membership_date
 * @property DateTime  $membership_expires
 * @property int       $seniority_number
 * @property string    $status
 * @property string    $admin_notes
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 */
class Membership extends Model
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
        'membership_date',
        'membership_expires',
        'seniority_number',
        'status',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'membership_date' => 'datetime',
        'membership_expires' => 'datetime',
    ];
}
