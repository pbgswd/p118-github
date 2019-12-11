<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property string $access_level
 * @property boolean $live
 * @property int $sort_order
 * @property boolean $in_menu
 * @property User $users
 * @property DateTime created_at
 * @property DateTime updated_at
 */
class Venue extends Model
{
    use Sortable;

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

    protected $dates =
        [
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'in_menu' => 'boolean',
            'allow_comments' => 'boolean',
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
