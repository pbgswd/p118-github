<?php

namespace App\Models;

use App\Policies\AttachmentPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $file
 * @property string $file_name
 * @property User $users
 * @property Meeting $meetings
 * @property DateTime created_at
 * @property DateTime updated_at
 */
class Attachment extends Model
{
    protected $guard_name = 'web';

    /**
     * @var array
     */
    protected $policies = [
        Attachment::class => AttachmentPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     *
     */
    protected $fillable = [
        'file',
        'file_name',
        'subfolder',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * relationships
     */
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'attachment_meeting');
    }


    // relationship to users table

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
