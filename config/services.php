<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials and configurations for third
    | party services such as Mailgun, Postmark, AWS, and others. By using
    | environment variables, sensitive data is kept secure and dynamic.
    |
    */

    // Postmark Configuration
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    // Amazon SES Configuration
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Resend Email API Configuration
    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    // Slack Notifications
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Mailgun Configuration
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    // AWS S3 Configuration
    's3' => [
        'bucket' => env('AWS_BUCKET'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'url' => env('AWS_URL'),
    ],

    // Example Custom Service (Add more as needed)
    'custom_service' => [
        'client_id' => env('CUSTOM_SERVICE_CLIENT_ID'),
        'client_secret' => env('CUSTOM_SERVICE_CLIENT_SECRET'),
        'redirect' => env('CUSTOM_SERVICE_REDIRECT_URI'),
    ],

];
