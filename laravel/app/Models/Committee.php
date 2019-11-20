<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

class Committee extends Model
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';  //????

    public $sortable = [
        'id',
        'name',
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
        return $this->hasOne(User::class);  // many users associated with many groups???
    }

}
