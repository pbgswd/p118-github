<?php

return [

    'disks' => [
        'users' => [
            'driver' => 'local',
            'root' => storage_path('app/users'),
            'url' => env('APP_URL').'/users',
            'visibility' => 'public',
        ],

        'meetings' => [
            'driver' => 'local',
            'root' => storage_path('app/meetings'),
            'url' => env('APP_URL').'/meetings',
            'visibility' => 'public',
        ],

        'employment' => [
            'driver' => 'local',
            'root' => storage_path('app/employment'),
            'url' => env('APP_URL').'/employment',
            'visibility' => 'public',
        ],

        'agreements' => [
            'driver' => 'local',
            'root' => storage_path('app/agreements'),
            'url' => env('APP_URL').'/agreements',
            'visibility' => 'public',
        ],

        'bylaws' => [
            'driver' => 'local',
            'root' => storage_path('app/bylaws'),
            'url' => env('APP_URL').'/bylaws',
            'visibility' => 'public',
        ],

        'policies' => [
            'driver' => 'local',
            'root' => storage_path('app/policies'),
            'url' => env('APP_URL').'/policies',
            'visibility' => 'public',
        ],

        'committees' => [
            'driver' => 'local',
            'root' => storage_path('app/committees'),
            'url' => env('APP_URL').'/committees',
            'visibility' => 'public',
        ],

        'memoriam' => [
            'driver' => 'local',
            'root' => storage_path('app/memoriam'),
            'url' => env('APP_URL').'/memoriam',
            'visibility' => 'public',
        ],

        'org_venue' => [
            'driver' => 'local',
            'root' => storage_path('app/org_venue'),
            'url' => env('APP_URL').'/org_venue',
            'visibility' => 'public',
        ],

        'carousel' => [
            'driver' => 'local',
            'root' => storage_path('app/carousel'),
            'url' => env('APP_URL').'/carousel',
            'visibility' => 'public',
        ],

        'qrcodes' => [
            'driver' => 'local',
            'root' => storage_path('app/qrcodes'),
            'url' => env('APP_URL').'/qrcodes',
            'visibility' => 'public',
        ],

        'messages' => [
            'driver' => 'local',
            'root' => storage_path('app/messages'),
            'url' => env('APP_URL').'/messages',
            'visibility' => 'public',
        ],
    ],

];
