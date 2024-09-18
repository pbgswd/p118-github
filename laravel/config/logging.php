<?php

return [

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    'channels' => [
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 4,
            'replace_placeholders' => true,
            'permission' => 0664,
            'user' => 'www-data',
        ],
    ],

];
