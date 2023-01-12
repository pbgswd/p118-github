<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int       $id
 * @property DateTime  $membership_date
 * @property DateTime  $membership_expires
 * @property int       $seniority_number
 * @property string    $status
 * @property string    $membership_type
 * @property string    $admin_notes
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 */
class Membership extends Model
{
    use HasRoles;
    use HasFactory;

    /** @var string */
    protected $guard_name = 'web';

    /** @var array */
    protected $casts = [
        'membership_date' => 'datetime',
        'membership_expires' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_type',
        'membership_date',
        'membership_expires',
        'seniority_number',
        'status',
        'admin_notes',
    ];
}
