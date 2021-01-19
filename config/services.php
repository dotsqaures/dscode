<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
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
        'region' => env('AWS_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],


    'facebook' => [
       // 'client_id' => '893832020979337',
       // 'client_secret' => 'c8b59295c99a27a7cef015b06e2681ae',
        'client_id' => '430650871160294',
        'client_secret' => '74ef1854c8e444d4a8805051933275fe',
        'redirect' => 'https://webappdeveloment.24livehost.com/public/auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '417508604115-tfr99s6ilio73sb7b0pbdklm0gld8gjk.apps.googleusercontent.com',
        'client_secret' => 'zd8qhqzDMfbr9yFJY1iepIS1',
        'redirect' => 'https://webappdeveloment.24livehost.com/public/auth/google/callback',
    ],

];
