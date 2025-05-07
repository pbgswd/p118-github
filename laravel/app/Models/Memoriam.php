<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Memoriam extends LiveableModel implements Searchable
{
    use HasFactory;
    use Sortable;

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
