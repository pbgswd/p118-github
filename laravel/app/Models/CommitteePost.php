<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property User $creator
 * @property Committee $committee
 * @property Committee $committee_posts
 * @property boolean $sticky
 * @property boolean $live
 * @property boolean $allow_comments
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */

class CommitteePost extends Model
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
        'title',
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
            'sticky'           => 'boolean',
            'allow_comments'    => 'boolean',
            'live'              => 'boolean',
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'live',
        'sticky',
        'allow_comments',
    ];

    /**
     * in urls, what field value is used to identify a CommitteePost record?
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

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function committee()
    {
        return $this->hasOne(Committee::class, 'id', 'committee_id');
    }

    public function committee_posts()
    {
        return $this->belongsToMany(Committee::class, 'committees', 'id', 'committee_id');
    }
}
