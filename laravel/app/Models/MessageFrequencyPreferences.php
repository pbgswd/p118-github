<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageFrequencyPreferences extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table = 'message_frequency_preferences';
    public $timestamps = false;

    protected $fillable = [
        'preference'
        ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
