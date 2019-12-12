<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property string $access_level
 * @property boolean $live
 * @property int $sort_order
 * @property User $users
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */

class Agreement extends Model
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
        ];

    protected $dates =
        [
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'allow_comments' => 'boolean',
            'live' => 'boolean',
        ];

    public function users()
    {
        return $this->hasOne(User::class);
    }

}
