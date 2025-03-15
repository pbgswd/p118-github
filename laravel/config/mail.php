<?php

return [

    'driver' => env('MAIL_DRIVER', 'smtp'),

    'host' => env('MAIL_HOST', 'smtp.mailgun.org'),

    'port' => env('MAIL_PORT', 587),

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'verify_peer' => env('MAIL_VERIFY_PEER'),
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
        ],
    ],

    'admin' => [
        'address' => env('MAIL_ADMIN_EMAIL'),
        'name' => env('MAIL_ADMIN_NAME'),
    ],

    'office_admin' => [
        'address' => env('MAIL_OFFICE_EMAIL_RECIPIENT'),
        'name' => env('MAIL_OFFICE_EMAIL_NAME'),
    ],

    'executive' => [
        'address' => 'executive@iatse118.com',
        'name' => 'IATSE Local 118 Executive',
    ],

    'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),

    'sendmail' => '/usr/sbin/sendmail -bs',

    'log_channel' => env('MAIL_LOG_CHANNEL'),

];
