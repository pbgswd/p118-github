<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int          $id
 * @property string       $title
 * @property string       $description
 * @property string       $access_level
 * @property boolean      $live
 * @property User         $user
 * @property Attachment[] $attachments
 * @property \DateTime    $created_at
 * @property \DateTime    $updated_at
 * @property \DateTime    $date
 */

class Bylaw extends Model implements HasAttachment, Searchable
{
    use Sortable;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'access_level',
        'live',
        'date',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'live' => 'boolean',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            \route('bylaw_show', $this->id),
        );
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_bylaw');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'bylaws';
    }
}
