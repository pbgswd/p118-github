<?php

namespace App\Models;

use App\Policies\AttachmentPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int       $id
 * @property string    $file
 * @property string    $file_name
 * @property User      $user
 * @property Meeting[] $meetings
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Attachment extends Model
{
    protected $guard_name = 'web';

    protected $policies = [
        Attachment::class => AttachmentPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
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
     * @return BelongsToMany
     */
    public function meetings(): BelongsToMany
    {
        return $this->belongsToMany(Meeting::class, 'attachment_meeting');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
