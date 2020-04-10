<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\MeetingPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int          $id
 * @property string       $title
 * @property string       $description
 * @property int          $user_id
 * @property boolean      $live
 * @property User         $user
 * @property Attachment[] $attachments
 * @property DateTime     $date
 * @property DateTime     $created_at
 * @property DateTime     $updated_at
 */
class Meeting extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;

    protected $policies = [
        Meeting::class => MeetingPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'date',
        'live',
        'user_id',
    ];

    public $sortable = [
        'id',
        'title',
        'live',
        'date',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'live' => 'boolean',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            \route('meeting', $this->id),
        );
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_meeting');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'meetings';
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
