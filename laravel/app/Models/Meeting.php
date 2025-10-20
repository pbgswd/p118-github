<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\MeetingPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property bool $live
 * @property User $user
 * @property Attachment[] $attachments
 * @property DateTime $date
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class Meeting extends LiveableModel implements HasAttachment, Searchable
{
    use HasFactory;
    use Sortable;

    protected $table = 'meetings';

    protected $policies = [
        self::class => MeetingPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'meeting_type',
        'date',
        'live',
        'user_id',
    ];

    public $sortable = [
        'id',
        'title',
        'meeting_type',
        'live',
        'date',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'live' => 'boolean',
        ];
    }

    public function getDateAttribute($value)
    {
        return $this->asDateTime($value)->shiftTimezone(env('APP_TIMEZONE'));
    }

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

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function motions(): HasMany
    {
        return $this->hasMany(Motion::class);
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_meeting');
    }

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
