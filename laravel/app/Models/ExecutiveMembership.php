<?php

namespace App\Models;

use App\Policies\ExecutiveMembershipPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class ExecutiveMembership extends Model implements Searchable
{
    protected $table = 'executive_user';

    protected $policies = [
        self::class => ExecutiveMembershipPolicy::class,
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
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $user = User::where('id', $this->user_id)->first();

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $user,
                $user->name,
                \route('user_edit', $user->id)
            );
        }

        return new SearchResult(
            $user,
            $user->name,
            \route('member', $user->id)
        );
    }

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
