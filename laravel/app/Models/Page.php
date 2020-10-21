<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\PagePolicy;
use Conner\Tagging\Taggable;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int          $id
 * @property string       $slug
 * @property string       $title
 * @property string       $description
 * @property string       $content
 * @property string       $access_level
 * @property int          $sort_order
 * @property boolean      $live
 * @property boolean      $in_menu
 * @property boolean      $allow_comments
 * @property User         $user
 * @property int          $user_id
 * @property Topic[]      $topics
 * @property Attachment[] $attachments
 * @property DateTime     $created_at
 * @property DateTime     $updated_at
 * @method static withoutGlobalScopes()
 */
class Page extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;
    use Taggable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'access_level',
        'sort_order',
        'live',
        'in_menu',
        'allow_comments',
    ];

    protected $policies = [
        Page::class => PagePolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
        'allow_comments',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'in_menu' => 'boolean',
        'allow_comments' => 'boolean',
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
                \route('page_edit', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('page_show', $this->slug)
        );
    }


    /**
     * in urls, what field value is used to identify a Page record?
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function setTitleAttribute(string $value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['title'] = $value;
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
    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_page');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'public';
    }

    public function keepDissociatedAttachments(): bool
    {
        return true;
    }

    public function getAttachmentAccessLevel(): string
    {
        return $this->access_level;
    }
}
