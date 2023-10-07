<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qrcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'qrtype',
        'qrdata',
        'name',
        'file',
        'live',
        'user_id',
    ];

    protected $casts = [
        'date' => 'datetime',
        'live' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'qrcodes';
    }


}
