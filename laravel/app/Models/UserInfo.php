<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $image
 * @property string $about
 * @property bool $show_profile
 * @property bool $show_picture
 * @property bool $share_email
 * @property bool $share_phone
 * @property User $user
 */
class UserInfo extends Model implements Searchable
{
    use HasFactory;

    protected $guard_name = 'web';

    protected $table = 'users_info';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'show_profile',
        'show_picture',
        'share_email',
        'share_phone',
        'file_name',
        'image',
        'about',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'show_profile' => 'boolean',
            'show_picture' => 'boolean',
            'share_email' => 'boolean',
            'share_phone' => 'boolean',
        ];
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
