<?php

namespace App\Models;

use App\Policies\ExecutiveMembershipPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExecutiveMembership extends Model
{
    protected $table = 'executive_user';

    protected $policies = [
        ExecutiveMembership::class => ExecutiveMembershipPolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'email',
        'start_date',
        'end_date',
    ];

    protected $fillable = [
        'executive_id',
        'current',
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
     * @var mixed
     */
    private $user;

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
