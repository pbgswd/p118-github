<?php

namespace App\Models;

use App\Policies\PagePolicy;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;

class Attachment extends Model
{
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'slug',
    ];

    protected $dates = [
            'created_at',
            'updated_at'
        ];

    /**
     * in urls, what field value is used to identify an attachment record?
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
        return $this->attributes['slug'] = $value;
    }



    /**
     * relationships
     */
    // relationship to users table

    public function users()
    {
        return $this->hasOne(User::class);
    }


    // page

    // post

    // topic

    // member

}
