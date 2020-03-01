<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class InviteUser
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property string name
 * @property string email
 * @property string $password
 * @property string $role
 *
 */
class InviteUser extends Model
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

    protected $policies = [
       // User::class => UserPolicy::class,
    ];

    public $sortable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    protected $dates =
        [
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
        'password',
        'role',
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
}
