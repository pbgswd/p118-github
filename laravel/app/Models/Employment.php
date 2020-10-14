<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\EmploymentPolicy;
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
 * @property string       $url
 * @property boolean      $live
 * @property boolean      $status
 * @property User         $user
 * @property int          $user_id
 * @property Attachment[] $attachments
 * @property DateTime     $deadline
 * @property DateTime     $created_at
 * @property DateTime     $updated_at
 */

class Employment extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;

    protected $table = 'employment';

    protected $policies = [
        Employment::class => EmploymentPolicy::class,
    ];

    protected $fillable = [
        'title',
        'description',
        'url',
        'live',
        'deadline',
        'user_id',
    ];

    public $sortable = [
        'title',
        'description',
        'status',
        'live',
        'deadline',
    ];

    protected $dates = [
        'deadline',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'live' => 'boolean',
        'status' => 'boolean',
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
                \route('admin_employment_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('job_view', $this->id)
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
        return $this->belongsToMany(Attachment::class, 'attachment_employment');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'employment';
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
