<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\CommitteePostPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int                     $id
 * @property string                  $title
 * @property string                  $slug
 * @property string                  $content
 * @property bool                 $sticky
 * @property bool                 $live
 * @property bool                 $allow_comments
 * @property DateTime                $created_at
 * @property DateTime                $updated_at
 * @property User                    $creator
 * @property Committee               $committee
 * @property CommitteePostComment[]  $post_comments
 * @property int                     $committee_id
 * @method static withoutGlobalScopes()
 */
class CommitteePost extends LiveableModel implements HasAttachment, Searchable
{
    use Notifiable;
    use HasFactory;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

    protected $policies = [
        self::class => CommitteePostPolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'sticky' => 'boolean',
        'allow_comments' => 'boolean',
        'live' => 'boolean',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('CommitteePost');

        $committee = Committee::where('id', $this->committee_id)->first('slug');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_committee_post_edit', [$committee->slug, $this->slug])
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('public_committee_post_show', [$committee->slug, $this->slug])
        );
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'live',
        'sticky',
        'allow_comments',
        'user_id',
    ];

    /**
     * in urls, what field value is used to identify a CommitteePost record?
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function setTitleAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['title'] = $value;
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function committee(): HasOne
    {
        return $this->hasOne(Committee::class, 'id', 'committee_id');
    }

    /**
     * @return HasMany
     */
    public function post_comments(): HasMany
    {
        return $this->hasMany(CommitteePostComment::class, 'post_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function admin_post_comments(): HasMany
    {
        return $this->hasMany(CommitteePostComment::class, 'post_id', 'id')->withoutGlobalScopes()->orderByDesc('updated_at');
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_committee_post');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'committees';
    }

    public function keepDissociatedAttachments(): bool
    {
        return true;
    }

    public function getAttachmentAccessLevel(): string
    {
        return 'members';
    }
}
