<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;

class LiveScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
//        Log::debug(get_class($model).' filtered by '.__CLASS__);
        $builder->where('live', 1);
    }
}
