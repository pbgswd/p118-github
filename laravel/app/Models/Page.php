<?php

namespace App\Models;

use App\Policies\PagePolicy;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;

class Page extends Model
{
    use Sortable;
    use Taggable;

    protected $policies = [
        Page::class => PagePolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'image',
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'user_id',
            'title',
            'description',
            'content',
            'image',
            'access_level',
            'sort_order',
            'live',
            'in_menu',
            'allow_comments',
        ];

    /**
     * in urls, what field value is used to identify a Topic record?
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
        return $this->attributes['title'] = $value;
    }

    // relationship to users table

    public function users()
    {
        return $this->hasOne(User::class);
    }

}
