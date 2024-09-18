<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\FeaturePolicy;
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

    protected $policies = [
        self::class => FeaturePolicy::class,
    ];

    public $sortable = [
        'title',
        'date',
        'live',
        'access_level',
        'front_page',
        'landing_page',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'url',
        'content',
        'image',
        'file_name',
        'date',
        'live',
        'access_level',
        'front_page',
        'landing_page',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'live' => 'boolean',
        ];
    }

    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Feature');

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
            \route('feature', $this->slug)
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

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_feature');
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
