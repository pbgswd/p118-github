<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageSelection extends Model
{
    use HasFactory;

    protected $table = 'message_selections';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'type',
        'name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'name', 'name');
    }

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class, 'name', 'slug');
    }
}
