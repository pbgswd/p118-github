<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;


/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $content
 * @property string $access_level
 * @property boolean $live
 * @property int $sort_order
 * @property boolean $in_menu
 * @property boolean $allow_comments
 * @property User $users
 * @property Page $pages
 * @property Post $posts
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */

class Topic extends Model
{

    use Sortable;
    use Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'name',
            'description',
            'content',
            'access_level',
            'sort_order',
            'live',
            'in_menu',
            'allow_comments',
        ];

    public $sortable = [
        'id',
        'name',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
        'allow_comments',
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

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
