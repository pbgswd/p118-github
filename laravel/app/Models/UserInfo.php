<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{

    protected $guard_name = 'web';

    protected $table = 'users_info';


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
        'user_id',
        'share_email',
        'share_phone',
        'image',
        'about',

    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'share_email' => 'boolean',
        'share_phone' => 'boolean',
    ];

}
