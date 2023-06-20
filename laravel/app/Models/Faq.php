<?php

namespace App\Models;


use App\Policies\FaqPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use App\Constants\AccessLevelConstants;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int          $id
 * @property string       $slug
 * @property string       $faq_topic
 * @property string       $description
 * @property string       $access_level
 * @property bool         $live
 * @property User         $user
 * @property int          $user_id
 * @property DateTime     $created_at
 * @property DateTime     $updated_at
 * @method static withoutGlobalScopes()
 */


class Faq extends LiveableModel implements Searchable
{
    use Sortable;
    use HasFactory;

    protected $table = 'faqs';

    protected $guard_name = 'web';

    protected $policies = [
        self::class => FaqPolicy::class,
        ];

    public $fillable = [
        'faq_topic',
        'description',
        'live',
        'access_level'
        ];

    public $sortable = [
        'faq_topic',
        'live',
        'access_level',
        'created_at',
        'updated_at',
    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];

    public $casts = [
        'live' => 'boolean',
    ];

    /**
     * in urls, what field value is used to identify a Faq record?
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
    public function setFaqTopicAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['faq_topic'] = $value;
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function faqs_data(): HasMany
    {
        return $this->hasMany(FaqData::class)->orderBy('sort_order', 'desc');
    }

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Faq');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_faq_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('faq_show', $this->id)
        );
    }

}
