<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property bool      $live
 * @property User         $user
 * @property Attachment[] $attachments
 * @property DateTime     $date
 * @property DateTime     $created_at
 * @property DateTime     $updated_at
 */
class Meeting extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;
    use HasFactory;

    protected $policies = [
        self::class => MeetingPolicy::class,
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

    protected $casts = [
        'date' => 'datetime',
        'live' => 'boolean',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Meeting');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('meeting_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('meeting', $this->id)
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

    public function getDefaultLiveStatus(): bool
    {
        return true;
    }
}
