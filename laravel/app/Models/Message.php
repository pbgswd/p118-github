<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Message extends Model implements HasAttachment, Searchable
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'source_url',
        'section',
        'category',
        'subject',
        'content',
        'user_id',
        'count',
        'state',
    ];

    public $sortable = [
        'id',
        'user_id',
        'count',
        'created_at',
        'updated_at',
    ];

    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Message');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->subject,
                \route('admin_message_edit', [$this->id, $this->slug])
            );
        }

        return new SearchResult(
            $this,
            $this->subject,
            \route('message', [$this->id, $this->slug])
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['subject'] = $value;
    }

    public function message_categories(): BelongsToMany
    {
        return $this->belongsToMany(MessageCategory::class, 'message_categories');
    }

    public function messageCategories(): HasMany
    {
        return $this->hasMany(MessageCategory::class);
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_message');
    }

    public function email_queue(): BelongsToMany
    {
        return $this->belongsToMany(EmailQueue::class, 'message_id');
    }

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
