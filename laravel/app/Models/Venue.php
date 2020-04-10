<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Policies\VenuePolicy;
use DateTime;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int        $id
 * @property string     $slug
 * @property string     $name
 * @property string     $description
 * @property string     $url
 * @property string     $access_level
 * @property boolean    $live
 * @property int        $sort_order
 * @property boolean    $in_menu
 * @property User       $user
 * @property DateTime   $created_at
 * @property DateTime   $updated_at
 */
class Venue extends LiveableModel implements Searchable
{
    use Sortable;

    protected $policies = [
        Venue::class => VenuePolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'url',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
    ];

    public $sortable = [
        'id',
        'name',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
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
        return new SearchResult(
            $this,
            $this->name,
            \route('venue', $this->slug),
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
     * @return string
     */
    public function setNameAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');
        return $this->attributes['name'] = $value;
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getAccessLevel(): string
    {
        return AccessLevelConstants::MEMBERS;
    }
}
