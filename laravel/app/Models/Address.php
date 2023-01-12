<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int       $id
 * @property string    $unit
 * @property string    $street
 * @property string    $city
 * @property string    $province
 * @property string    $postal_code
 * @property string    $country
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 */
class Address extends Model implements Searchable
{
    use HasFactory;

    /** @var string */
    protected $guard_name = 'web';

    /** @var array */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit',
        'street',
        'city',
        'province',
        'postal_code',
        'country',
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
}
