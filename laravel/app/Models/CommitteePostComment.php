<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int       $id
 * @property int       $committee_id
 * @property int       $user_id
 * @property int       $post_id
 * @property int       $parent_id
 * @property string    $content
 * @property boolean   $live
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 * @property User      $comment_author
 */
class CommitteePostComment extends LiveableModel
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
        'content',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'live' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'content',
        'live',
    ];

    /**
     * @return HasOne
     */
    public function comment_author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
