<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;


class Member extends Model
{
    protected $table = 'users';

    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

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
     * Get model for phone data associated with the user.
     */

    public function phone_number()
    {
        return $this->hasOne(PhoneNumber::class, 'user_id');
    }

    public function user_info()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }

    public function membership()
    {
        return $this->hasOne(Membership::class, 'user_id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'user_id');
    }

}
