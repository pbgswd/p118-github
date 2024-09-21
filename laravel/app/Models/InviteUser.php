<?php

namespace App\Models;

use App\Policies\InviteUserPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class InviteUser.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class InviteUser extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use Sortable;

    /** @var string */
    protected $guard_name = 'web';

    /** @var array */
    protected $policies = [
        self::class => InviteUserPolicy::class,
    ];

    /** @var array */
    public $sortable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    /** @var array */

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
