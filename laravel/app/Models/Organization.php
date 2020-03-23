<?php

namespace App\Models;

use App\Policies\OrganizationPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property string $access_level
 * @property boolean $live
 * @property int $sort_order
 * @property User $users
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Organization extends Model implements Searchable
{
    use Sortable;

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        //todo organization route for front end, needed for search
        //$url = route('meeting', $this->id);
        $url = '';

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url,
        );
    }

    protected $policies = [
        Organization::class => OrganizationPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
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

    protected $dates =
        [
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'live' => 'boolean',
        ];

    /**
     * in urls, what field value is used to identify a Topic record?
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
        return $this->attributes['name'] = $value;
    }

    public function users()
    {
        return $this->hasOne(User::class);
    }

}
