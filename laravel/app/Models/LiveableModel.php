<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Scopes\LiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Extend this class for models that have a boolean `$live` field.
 *
 * @property bool $live
 *
 * @method static withoutGlobalScope() Builder
 */
#[ScopedBy([LiveScope::class])]
class LiveableModel extends Model
{
    use HasFactory;

    /**
     * @param  string|array  $relations
     * @param  string|array  $scopes
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
