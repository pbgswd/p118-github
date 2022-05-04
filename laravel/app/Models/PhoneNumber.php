<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $phone_number
 * @property string $label
 * @property bool $primary
 * @property DateTime created_at
 * @property DateTime updated_at
 */
class PhoneNumber extends Model implements Searchable
{
    use HasFactory;

    protected $guard_name = 'web';

    protected $casts =
        [
            'primary' => 'boolean',
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
                \route('user_edit', $this->user_id)
            );
        }

        return new SearchResult(
            $user,
            $user->name,
            \route('member', $this->user_id)
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'phone_number',
            'label',
            'primary',
        ];
}
