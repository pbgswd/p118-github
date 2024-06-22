<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EmailQueue extends Model
{
    use HasFactory;

    protected $table = 'email_queue';

    protected $fillable = [
        'sender',
        'recipient',
        'subject',
        'message',
        'attachments',
    ];

    /**
     * @var string[]
     */
    public function getAttachmentFolder(): string
    {
        return 'messages';
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_message');
    }
}
