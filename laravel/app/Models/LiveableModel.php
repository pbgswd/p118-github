<?php

namespace App\Models;

use App\Scopes\LiveScope;
use Illuminate\Database\Eloquent\Model;

/**
 * Extend this class for models that have a boolean `$live` field.
 *
 * @property bool $live
 * @method static withoutGlobalScope() Builder
 */
class LiveableModel extends Model
{
    /**
     * Override boot method.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new LiveScope());
    }

    /**
     * @param string|array $relations
     * @param string|array $scopes
     *
     * @return $this
     */
    public function loadWithoutGlobalScopes($relations, $scopes = []): self
    {
        $relations = (array) $relations;
        $scopes = (array) $scopes;

        $builders = \collect($relations)
            ->mapWithKeys(static function ($relation, $key) use ($scopes) {
                if (\is_string($relation)) {
                    return [$relation => static function ($query) use ($scopes) {
                        return $query->withoutGlobalScopes($scopes);
                    }];
                }
                \assert(\is_callable($relation), 'Unexpected parameters to `loadWithoutGlobalScopes()`.');

                return [$key => static function ($query) use ($scopes, $relation) {
                    return $relation($query->withoutGlobalScopes($scopes));
                }];
            })
            ->toArray();

        return $this->load($builders);
    }
}
