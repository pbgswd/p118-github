<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider as Provider;

return [

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),
];
