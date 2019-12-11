<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $file_name
 * @property string $image
 * @property string $about
 * @property boolean $show_profile
 * @property boolean $show_picture
 * @property boolean $share_email
 * @property boolean $share_phone
 */
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
        'show_picture',
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
        'show_picture' => 'boolean',
        'share_email' => 'boolean',
        'share_phone' => 'boolean',
    ];

}
