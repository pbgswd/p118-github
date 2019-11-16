<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{

    protected $guard_name = 'web';

    protected $table = 'users_info';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'show_profile',
        'show_photo',
        'share_email',
        'share_phone',
        'file_name',
        'image',
        'about',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'show_profile' => 'boolean',
        'show_photo' => 'boolean',
        'share_email' => 'boolean',
        'share_phone' => 'boolean',
    ];

}
