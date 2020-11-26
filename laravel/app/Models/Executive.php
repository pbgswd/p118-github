<?php

namespace App\Models;

use App\Policies\ExecutivePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * Class Executive
 * @package App\Models
 * @property int            $id
 * @property string         $title
 * @property string         $email
 * @property User           $user
 */
class Executive extends Model  implements Searchable
{
    use Sortable;

    protected $policies = [
        Executive::class => ExecutivePolicy::class,
    ];

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
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {

        if(request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                env('APP_NAME'). " Executive",
                \route('admin_executives')
            );
        }

        return new SearchResult(
            $this,
            env('APP_NAME'). " Executive",
            \route('executive')
        );

    }

    /**
     * @return BelongsToMany
     */

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'executive_user')
            ->withPivot('id', 'start_date', 'end_date', 'current');
    }

    public function current_executive_user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'executive_user')
            ->whereRaw('NOW() > start_date AND NOW() < end_date')
            ->withPivot('id', 'start_date', 'end_date', 'current');
    }

}
