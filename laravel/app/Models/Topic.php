<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Constants\TopicConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\TopicPolicy;
use Conner\Tagging\Taggable;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use phpDocumentor\Reflection\Types\Boolean;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


/**
 * @property int           $id
 * @property string        $slug
 * @property string        $name
 * @property string        $description
 * @property string        $content
 * @property string        $access_level
 * @property boolean       $live
 * @property int           $sort_order
 * @property boolean       $in_menu
 * @property boolean       $allow_comments
 * @property DateTime      $created_at
 * @property DateTime      $updated_at
 * @property User          $user
 * @property Page[]        $pages
 * @property Post[]        $posts
 * @property Attachment[]  $attachments
 * @method static withoutGlobalScope()
 * @method static withoutGlobalScopes()
 */
class Topic extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;
    use Taggable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'content',
        'access_level',
        'sort_order',
        'live',
        'in_menu',
        'allow_comments',
    ];

    protected $policies = [
        Topic::class => TopicPolicy::class,
    ];

    public $sortable = [
        'id',
        'name',
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
                $this->name,
                \route('topic_edit', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->name,
            \route('topic_show', $this->slug)
        );
    }

    /**
     * in urls, what field value is used to identify a Topic record?
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function setNameAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');
        return $this->attributes['name'] = $value;
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
    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class);

    }

    /**
     * @return BelongsToMany
     */
    public function public_pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class)
            ->where([
                ['access_level', AccessLevelConstants::PUBLIC],
                ['live', 1],
            ]);
    }

    /**
     * @return BelongsToMany
     */
    public function news_pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'page_topic')
            ->where([
                ['topic_id', TopicConstants::NEWS],
                ['live', 1],
            ])
            ->withPivot('topic_id');
    }

    /**
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }


    /**
     * @return BelongsToMany
     */
    public function public_posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)
            ->where([
                ['access_level', AccessLevelConstants::PUBLIC],
                ['live', 1],
            ]);
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_topic');
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
