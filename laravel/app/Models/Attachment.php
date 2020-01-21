<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property User $users
 * @property DateTime created_at
 * @property DateTime updated_at
 */
class Attachment extends Model
{
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     * @var array
     *
     */
    protected $fillable = [
        'name',
        'extension',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * relationships
     */
    // relationship to users table

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // page

    // post

    // topic

    // member

}
