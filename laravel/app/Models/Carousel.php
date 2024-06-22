<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

class Carousel extends LiveableModel
{
    use HasFactory;
    use Sortable;

    /**
     * @var string
     */
    private $access_level;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->access_level = AccessLevelConstants::PUBLIC;
    }

    /**
     * @var string[]
     */
    public $fillable = [
        'caption',
        'caption2',
        'align',
        'text_color',
        'text_outline_color',
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

    /**
     * @var array
     */
    public $sortable = [

    ];

    /**
     * @var string[]
     */
    public $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    public $casts = [
        'live' => 'boolean',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

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

    public function getImageData(): array
    {
        $data = [];

        $data[] = ['size' => '2000x500', 'width' => 2000, 'filesize' => 300,
            'blank' => 'UsXipWMoF0bNljLprHnzdxYgoHvBpIwILXGSkk9W.png'];
        $data[] = ['size' => '1400x500', 'width' => 1400, 'filesize' => 300,
            'blank' => '4uFQWEZBWo7dxcA1AoKmQMKe30S2hogSPmCSEzFf.png'];
        $data[] = ['size' => '800x500', 'width' => 800, 'filesize' => 100,
            'blank' => 'sldBQCvcPt5hsALPLvUEToioZI8dWbsNFEmkSHIV.png'];
        $data[] = ['size' => '600x500', 'width' => 600, 'filesize' => 100,
            'blank' => '8eSKLkYt7soAjBrVnU2PBixxtBu5bbTenaF7QQ8E.png'];

        return $data;
    }

    public function getAttachmentAccessLevel(): string
    {
        return AccessLevelConstants::PUBLIC;
    }
}
