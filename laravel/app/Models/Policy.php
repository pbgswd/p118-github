<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\PolicyPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * Class Policy.
 * @property int       $id
 * @property int       $user_id
 * @property string    $title
 * @property string    $description
 * @property bool      $live
 */
class Policy extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;
    use HasFactory;

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

    protected $policies = [
        self::class => PolicyPolicy::class,
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
        $this->info = $modelList->getModelInfo('Policy');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_policy_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('policy_show_public', $this->id)
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
