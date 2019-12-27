<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $email
 * @property User $creator
 * @property Committee $committee_members
 * @property Committee $committee_posts
 * @property Committee $membership
 * @property CommitteePost $posts
 * @property boolean $in_menu
 * @property boolean $live
 * @property boolean $allow_comments
 * @property DateTime created_at
 * @property DateTime updated_at
 */
class Committee extends Model
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';  //????

    protected $policies = [
        //Committee::class=>CommitteePolicy::class,
    ];

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
            'in_menu' => 'boolean',
            'allow_comments' => 'boolean',
            'live' => 'boolean',
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'email',
        'access_level',
        'live',
        'sort_order',
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

    public function setNameAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
        return $this->attributes['name'] = $value;
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function committee_members()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(CommitteePost::class);
    }

}
