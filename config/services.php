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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
        'webhook_endpoint_host' => env('GOOGLE_WEBHOOK_ENDPOINT_HOST', env('APP_URL')),
        'service_account_email' => env('GOOGLE_SERVICE_ACCOUNT_EMAIL'),
        'scopes' => [
            'https://www.googleapis.com/auth/gmail.modify',
        ],
        'topics' => [
            'email-event' => env('GOOGLE_EMAIL_EVENT_TOPIC'),
        ],
    ],
    'notion' => [
        'webhook_token' => env('NOTION_WEBHOOK'),
        'token' => env('NOTION_TOKEN'),
        'databases' => [
            'projects' => env('NOTION_PROJECTS_DATABASE_ID'),
            'tasks' => env('NOTION_TASKS_DATABASE_ID'),
        ],
    ],

    'todoist' => [
        'token' => env('TODOIST_TOKEN'),
    ],

    'homeassistant' => [
        'host' => env('HOMEASSISTANT_HOST'),
        'token' => env('HOMEASSISTANT_TOKEN'),
    ],

];
