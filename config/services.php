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

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID', '552661084983-rndgpf3gqsvcpsasvrja6nuenj76ojln.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'P6nvdj3B_iHQv-QnFJl_eLeG'),
        'redirect'      => env('APP_URL').'/social-login/google/callback',
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID', '284952809081931'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', 'fce58d0ad5cc7812b6d60d36b3060a67'),
        'redirect'      => env('APP_URL').'/social-login/facebook/callback',
    ],

    'twitter' => [
        'client_id'     => env('TWITTER_CLIENT_ID', 'oS347pUVzMqnCp3z1lijn9sRB'),
        'client_secret' => env('TWITTER_CLIENT_SECRET', 'i3zCEfxzSPdpR3qjEDcwvsErVUdSCgsJMHxSjefJ5fk3YtQaoc'),
        'redirect'      => env('APP_URL').'/social-login/twitter/callback',
    ],

];
