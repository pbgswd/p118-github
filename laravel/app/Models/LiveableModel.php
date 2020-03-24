<?php

namespace App\Models;

use App\Scopes\LiveScope;
use Illuminate\Database\Eloquent\Model;

/**
 * Extend this class for models that have a boolean `$live` field
 *
 * @property boolean $live
 */
class LiveableModel extends Model
{
    /**
     * Override boot method
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new LiveScope());
    }
}
