<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

class Message extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'subject',
        'content',
        'user_id',
        'live',
        'priority',
        'sent'
        ];



    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'messages';
    }

    public function keepDissociatedAttachments(): bool
    {
        return true;
    }

}
