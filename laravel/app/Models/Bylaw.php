<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\BylawPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * Class Bylaw.
 *
 * @property int          $id
 * @property string       $title
 * @property string       $description
 * @property string       $access_level
 * @property bool      $live
 * @property int          $user_id
 * @property User         $user
 * @property Attachment[] $attachments
 * @property DateTime     $created_at
 * @property DateTime     $updated_at
 * @property DateTime     $date
 * @method static withoutGlobalScopes()
 */
class Bylaw extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;

    protected $policies = [
        self::class => BylawPolicy::class,
        ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'access_level',
        'live',
        'date',
        'user_id',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'live' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->access_level = AccessLevelConstants::MEMBERS;
    }

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_bylaw_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route(request()->route()->getName(), $this->id)
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
        return $this->belongsToMany(Attachment::class, 'attachment_bylaw');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'bylaws';
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
