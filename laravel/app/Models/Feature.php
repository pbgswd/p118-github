<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Feature extends LiveableModel implements HasAttachment, Searchable
{
    use HasFactory;
    use Sortable;
    use Taggable;

    protected $policies = [
        //self::class => FeaturePolicy::class,
    ];

    public $sortable = [
        'title',
        'date',
        'live',
        'created_at',
        'updated_at',
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
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'image',
        'file_name',
        'date',
        'live',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_feature_edit', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('feature_show', $this->slug)
        );
    }

    /**
     * @return string
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
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_feature');
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
