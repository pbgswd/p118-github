<?php

namespace App\Models;

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
 * @property boolean $show_profile
 * @property boolean $show_picture
 * @property boolean $share_email
 * @property boolean $share_phone
 * @property User $user
 */
class UserInfo extends Model implements Searchable
{
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
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'show_profile' => 'boolean',
        'show_picture' => 'boolean',
        'share_email' => 'boolean',
        'share_phone' => 'boolean',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this->user,
            $this->user->name,
            \route('member', $this->user_id),
        );
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
