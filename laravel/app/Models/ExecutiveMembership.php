<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExecutiveMembership extends Model
{
    use HasFactory;

    protected $table = 'executive_user';

    protected $fillable = [
        'executive_id',
        'current',
        'start_date',
        'end_date',
    ];

    /**
     * @var mixed
     */
    private $user;

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
