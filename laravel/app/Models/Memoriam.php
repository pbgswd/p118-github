<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Memoriam extends LiveableModel implements Searchable
{
    use Sortable;
    use HasFactory;

    protected $table = 'memoriams';

    protected $policies = [
        self::class => MemoriamPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'live',
        'file_name',
        'image',
        'date',
    ];

    public $sortable = [
        'id',
        'title',
        'live',
        'date',
        'created_at',
        'updated_at',
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
        $this->info = $modelList->getModelInfo('Memoriam');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_memoriam_edit', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('memoriam', $this->slug)
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
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'memoriam';
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
