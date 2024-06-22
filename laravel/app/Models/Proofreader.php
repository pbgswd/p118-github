<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proofreader extends Model
{
    use HasFactory;

    protected $table = 'proofreader';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
