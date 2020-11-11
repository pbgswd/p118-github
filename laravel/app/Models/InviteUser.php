<?php

namespace App\Models;

use App\Policies\InviteUserPolicy;

use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class InviteUser
 *
 * @property int       $id
 * @property int       $user_id
 * @property string    $name
 * @property string    $email
 * @property string    $password
 * @property string    $role
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 *
 */

class InviteUser extends Authenticatable
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    /** @var string  */
    protected $guard_name = 'web';

    /** @var array */
    protected $policies = [
        InviteUser::class => InviteUserPolicy::class,
    ];

    /** @var array  */
    public $sortable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    /** @var array  */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'membership_type',
        'message',
        'password',
        'role',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
