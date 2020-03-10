<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\AgreementPolicy;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $access_level
 * @property boolean $live
 * @property User $user
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime from
 * @property \DateTime until
 */

class Agreement extends Model implements HasAttachment
{
    use Sortable;

    /**
     * @var array
     */
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
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'description',
        'access_level',
        'live',
        'from',
        'until'
        ];

    /**
     * @var array
     */
    protected $dates =
        [
            'from',
            'until',
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
