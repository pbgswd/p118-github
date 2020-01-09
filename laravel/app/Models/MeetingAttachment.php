<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $meeting_id
 * @property string $file
 * @property string $extension
 * @property string $description
 * @property DateTime created_at
 * @property DateTime updated_at
 */

class MeetingAttachment extends Model
{

    protected $guard_name = 'web';

    protected $table = 'meeting_attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'file',
        'description',
    ];

    protected $dates =
        [
            'created_at',
            'updated_at'
        ];
}
