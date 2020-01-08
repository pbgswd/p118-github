<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $live
 * @property User $users
 * @property \DateTime $date
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Meeting extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'date',
    ];

    public $sortable = [
        'id',
        'title',
        'live',
        'date',
        'created_at',
        'updated_at',
    ];

    protected $dates =
        [
            'date',
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'live' => 'boolean',
        ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
