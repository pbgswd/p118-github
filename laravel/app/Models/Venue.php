<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;


class Venue extends Model
{
        use Sortable;

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

    protected $dates =
    [
        'created_at',
        'updated_at'
    ];

    protected $casts =
    [
        'in_menu'           => 'boolean',
        'allow_comments'    => 'boolean',
        'live'              => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'url',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
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
