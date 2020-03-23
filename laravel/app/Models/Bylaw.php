<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $access_level
 * @property boolean $live
 * @property User $user
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime date
 */

class Bylaw extends Model implements HasAttachment, Searchable
{
    use Sortable;

    public function getSearchResult(): SearchResult
    {
        $url = route('bylaw_show', $this->id);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url,
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'access_level',
        'live',
        'date',
    ];

    /**
     * @var array
     */
    protected $dates =
        [
            'date',
            'created_at',
            'updated_at',
        ];

    /**
     * @var array
     */
    protected $casts =
        [
            'live' => 'boolean',
        ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attachments()
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
