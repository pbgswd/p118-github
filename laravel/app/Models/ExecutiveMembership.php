<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExecutiveMembership extends Model
{
    protected $table = 'executive_user';

    public $sortable = [
        'id',
        'title',
        'email',
        'start_date',
        'end_date',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'executive_id',
        'title',
        'email',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'start_date',
        'end_date',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
