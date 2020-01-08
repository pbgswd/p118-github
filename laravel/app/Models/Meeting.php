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
    ];

    public $sortable = [
        'id',
        'title',
        'live',
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

    public function users()
    {
        return $this->hasOne(User::class);
    }

}
