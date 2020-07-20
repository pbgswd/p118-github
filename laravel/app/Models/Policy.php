<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * Class Policy
 * @package App\Models
 * @property int       $id
 * @property int       $user_id
 * @property string    $title
 * @property string    $description
 * @property DateTime  $date
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 * @property bool      $live
 */
class Policy extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
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

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {

        if(request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_policy_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('policy_show_public', $this->id),
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
        return $this->belongsToMany(Attachment::class, 'attachment_policies');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'policies';
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
