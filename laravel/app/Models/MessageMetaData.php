<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageMetaData extends Model
{
    use HasFactory;

    protected $table = 'message_metadata';

    protected $fillable = [
        'message_id',
        'source_id',
        'source_slug',
        'source_type',
        'source_type_name',
        'source_url',
    ];

    public function message(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
