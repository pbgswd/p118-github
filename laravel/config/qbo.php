<?php
return [
    'client_id'     => env('QBO_CLIENT_ID'),
    'client_secret' => env('QBO_CLIENT_SECRET'),
    'redirect_uri'  => env('QBO_REDIRECT_URI'),
    'base_url'      => env('QBO_BASE_URL', 'Development'),
    'realm_id'      => env('QBO_REALM_ID'),
    'scope'         => 'com.intuit.quickbooks.accounting',
];
