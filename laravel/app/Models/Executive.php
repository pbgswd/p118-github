<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

/**
 * Class Executive
 * @package App\Models
 * @property int            $id
 * @property string         $title
 * @property boolean        $current
 * @property int            $user_id
 * @property User           $user
 * @property DateTime       $start_date
 * @property DateTime       $end_date
 * @property DateTime       $created_at
 * @property DateTime       $updated_at
 */
class Executive extends Model
{
    use Sortable;

    public $sortable = [
        'user_id',
        'title',
        'email',
        'start_date',
        'end_date',
        'current',
    ];

    protected $fillable = [
      'user_id',
      'title',
      'email',
      'start_date',
      'end_date',
      'current',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'current' => 'boolean',
    ];

    /**
     * @return HasOne
     */
    //todo executive to user relationship could be many titles, rows, to one user
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
