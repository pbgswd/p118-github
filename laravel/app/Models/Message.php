<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Message extends Model implements HasAttachment, Searchable
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
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Message');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_message_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->subject,
            \route('message', $this->id)
        );
    }


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_message');
    }


    /**
     * @return HasOne
     */
    public function messageMeta(): HasOne
    {
        return $this->hasOne(MessageMetaData::class, 'message_id');
    }

    public function messageSending(): HasOne
    {
        return $this->hasOne(MessageSending::class, 'message_id');
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
        return false;
    }

    public function getAttachmentAccessLevel(): string
    {
        return AccessLevelConstants::MEMBERS;
    }

}
