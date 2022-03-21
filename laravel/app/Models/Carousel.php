<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

class Carousel extends LiveableModel implements HasAttachment
{
    use Sortable;
    //migration attachment_carousel

    /**
     * @var string
     */
    private $access_level;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->access_level = AccessLevelConstants::PUBLIC;
    }

    /*
     * thoughts on schema
     *  id for image to associate with image stored in attachaments, added in relation?
     * separate upload for each image.
     * relation table attachments_carousel
     */
    public $fillable = [
        'name',
        'title',
        'link',
        'description',
        'color',
        'align',
        'button',
        'credit',
        'live',
        'order',
        '2000_image',
        '2000_file',
        '1400_image',
        '1400_file',
        '800_image',
        '800_file',
        '600_image',
        '600_file',

    ];

    public $sortable = [

    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];

    public $casts = [
        'live' => 'boolean',
    ];

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
        return $this->belongsToMany(Attachment::class, 'attachment_carousel');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'public';
    }

    public function keepDissociatedAttachments(): bool
    {
        return false;
    }

    public function getAttachmentAccessLevel(): string
    {
        return AccessLevelConstants::MEMBERS;
    }
}
