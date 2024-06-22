<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qrcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'qrdata',
        'name',
        'qrtype',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAttachmentFolder(): string
    {
        return 'qrcodes';
    }
}
