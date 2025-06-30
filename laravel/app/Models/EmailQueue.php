<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class EmailQueue extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'email_queue';

    protected $fillable = [
        'message_id',
        'user_id',
    ];

    public $sortable = [
        'id',
        'section',
        'category',
        'user_id',
        'count',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
