<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\PostPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $access_level
 * @property bool $live
 * @property bool $front_page
 * @property bool $landing_page
 * @property User $user
 * @property Topic[] $topics
 * @property Attachment[] $attachments
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @method static withoutGlobalScopes()
 */
class Post extends LiveableModel implements HasAttachment, Searchable
{
    use HasFactory;
    use Sortable;

    protected $policies = [
        self::class => PostPolicy::class,
    ];

    public $sortable = [
        'title',
        'access_level',
        'live',
        'front_page',
        'landing_page',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'front_page' => 'boolean',
        'landing_page' => 'boolean',
        'live' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'access_level',
        'live',
        'front_page',
        'landing_page',
    ];

    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Post');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('post_edit', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('post_show', $this->slug)
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function setTitleAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['title'] = $value;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_post');
    }

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
