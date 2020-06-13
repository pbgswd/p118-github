<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

/**
 * Class Executive
 * @package App\Models
 * @property int            $id
 * @property string         $title
 * @property string         $email
 * @property User           $user
 * @property DateTime       $created_at
 * @property DateTime       $updated_at
 */
class Executive extends Model
{
    use Sortable;

    protected $table = 'executives';

    public $sortable = [
        'id',
        'title',
        'email',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'id',
      'title',
      'email',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'start_date',
        'end_date',
    ];

    /**
     * @return BelongsToMany
     */

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'executive_user')
            ->withPivot('id', 'start_date', 'end_date', 'current');
    }

}
