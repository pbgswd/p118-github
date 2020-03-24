<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\AgreementPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int           $id
 * @property string        $title
 * @property string        $description
 * @property string        $access_level
 * @property boolean       $live
 * @property User          $user
 * @property Attachment[]  $attachments
 * @property DateTime      $created_at
 * @property DateTime      $updated_at
 * @property DateTime      $from
 * @property DateTime      $until
 */

class Agreement extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;

    protected $policies = [
        Agreement::class => AgreementPolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'from',
        'until',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'access_level',
        'live',
        'from',
        'until'
    ];

    protected $dates = [
        'from',
        'until',
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
            \route('agreement_show', $this->id),
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
        return $this->belongsToMany(Attachment::class, 'attachment_agreement');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'agreements';
    }
}
