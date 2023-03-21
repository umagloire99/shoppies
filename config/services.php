<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'momo' => [
        'subscription_key' => env('MOMO_COLLECTION_SUBSCRIPTION_KEY', '635ee7bdbdbb4a33806534435778fbc7'),
        'collection_id' => env('MOMO_COLLECTION_ID', '5dfa73d7-7325-4c3f-84f9-e22f0db39dc9'),
        'collection_secret' => env('MOMO_COLLECTION_SECRET', '24c4c276b58141bc8dd49703f75479fa'),
        'token_uri' => env('MOMO_COLLECTION_TOKEN_URI', 'https://proxy.momoapi.mtn.com/collection/token/'),
        'transaction_uri' => env('MOMO_COLLECTION_TRANSACTION_URI', 'https://proxy.momoapi.mtn.com/collection/v1_0/requesttopay'),
        // Transaction status
        'transaction_status_uri' => env(
            'MOMO_COLLECTION_TRANSACTION_STATUS_URI',
            'https://proxy.momoapi.mtn.com/collection/v1_0/requesttopay'
        ),
        'environment' => env('MOMO_ENVIRONMENT', 'mtncameroon'),
        'callback_uri' => 'https://www.happy-cute.com/momo/callback',
    ],
    'monetbil' => [
        'service_key' => env('MONEBIL_SERVICE_KEY', 'lE0jCVYlgvnAaVGKfmkss3N4EJPtr9U2')
    ]
];
