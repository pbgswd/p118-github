<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\UserPolicy;
use DateTime;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string $password
 * @property DateTime created_at
 * @property DateTime updated_at
 * @property PhoneNumber $phone_number
 * @property UserInfo $user_info
 * @property Address $address
 * @property Membership $membership
 * @property Attachment $attachments
 * @property Committee $committee_membership
 *
 */
class User extends Authenticatable implements HasAttachment
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

    protected $policies = [
        User::class => UserPolicy::class,
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
            'updated_at'
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
        'email_verified_at',
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

    public function phone_number()
    {
        return $this->hasOne(PhoneNumber::class);
    }

    public function user_info()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class);
    }

    public function committee_membership()
    {
        return $this->belongsToMany(Committee::class)->withPivot('role');
            //TODO pluralize method name
    }

    public function getAttachmentFolder(): string
    {
        return 'users';
    }

}
