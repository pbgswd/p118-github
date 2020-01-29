<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $live
 * @property boolean $status
 * @property User $users
 * @property \DateTime $deadline
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property Attachment $attachments
 * @property string $getAttachmentFolder
 */

class Employment extends Model
{
    use Sortable;

    protected $table = 'employment';

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
        'live',
        'deadline',
        ];

    /**
     * @var array
     */
    public $sortable = [
        'title',
        'description',
        'status',
        'live',
        'deadline',
        ];

    protected $dates =
        [
            'deadline',
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'live' => 'boolean',
            'status' => 'boolean',
        ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'attachment_employment');
    }

    public function getAttachmentFolder(): string
    {
        return 'employment';
    }
}
