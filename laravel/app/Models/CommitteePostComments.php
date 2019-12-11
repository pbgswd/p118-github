<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property int $committee_id
 * @property int $user_id
 * @property int $post_id
 * @property int $parent_id
 * @property string $content
 * @property boolean $live
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */

class CommitteePostComments extends Model
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $table = 'committee_post_comments';

    protected $guard_name = 'web';  //????

    protected $policies = [
        //Committee::class=>CommitteePolicy::class,
    ];

    public $sortable = [
        'id',
        'content',
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'live',
    ];

    public function commentAuthor()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
