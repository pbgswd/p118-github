<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

class Carousel extends LiveableModel implements HasAttachment
{
    use Sortable;
    use HasFactory;
    //todo migration attachment_carousel

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
     *  id for image to associate with image stored in attachments, added in relation?
     * separate upload for each image.
     * relation table attachments_carousel
     */
    public $fillable = [
        'caption',
        'caption2',
        'button',
        'link',
        'align',
        'credit',
        'color',
        'live',
        'order',
        'image_2000',
        'file_2000',
        'image_1400',
        'file_1400',
        'image_800',
        'file_800',
        'image_600',
        'file_600',
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
        return 'carousel';
    }

    /**
     * @return int[]
     */
    public function getImageWidthSizes(): array
    {
        return [2000, 1400, 800, 600];
    }

    public function getImageSizes(): array
    {
        return ['2000x500', '1400x500', '800x500', '600x500'];
    }

    /**
     * @return array
     */
    public function getImageData(): array
    {
        $data = [];

        $data[] = ['size' => '2000x500', 'width' => 2000, 'filesize' => 300, 'blank' => 'qox20XLuDz6g6IAnUjisNQt8qQVOU9yJq0WqcAt5.png'];
        $data[] = ['size' => '1400x500', 'width' => 1400, 'filesize' => 300, 'blank' => 'C8ik1J8OqDQqsfgGUw6vt4PFLx5ukhDnbgtHLdvp.png'];
        $data[] = ['size' => '800x500', 'width' => 800, 'filesize' => 100, 'blank' => 'hEucTumAZtAu6TFPf95ASEKhb1ped3prLplCVl52.png'];
        $data[] = ['size' => '600x500', 'width' => 600, 'filesize' => 100, 'blank' => 'TVWxK0pdgrqpS3Ow54mk4ZvodhKDw77SYiBaL5f5.png'];

        return $data;
    }


















    public function keepDissociatedAttachments(): bool
    {
        return false;
    }

    public function getAttachmentAccessLevel(): string
    {
        return AccessLevelConstants::PUBLIC;
    }
}
