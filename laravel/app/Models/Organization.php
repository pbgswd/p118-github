<?php

namespace App\Models;

use App\Policies\OrganizationPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int        $id
 * @property string     $name
 * @property string     $description
 * @property string     $url
 * @property string     $access_level
 * @property boolean    $live
 * @property int        $sort_order
 * @property User       $user
 * @property \DateTime  $created_at
 * @property \DateTime  $updated_at
 */
class Organization extends Model implements Searchable
{
    use Sortable;

    protected $policies = [
        Organization::class => OrganizationPolicy::class,
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
    ];

    public $sortable = [
        'id',
        'name',
        'access_level',
        'live',
        'sort_order',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'live' => 'boolean',
    ];


    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        //todo organization route for front end, needed for search
        //$url = route('meeting', $this->id);

        return new SearchResult(
            $this,
            $this->name,
            '',
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
}
