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

    'steam' => [
        'key' => env('STEAM_CLIENT_SECRET'),
        'client_id' => null,
        'client_secret' => env('STEAM_CLIENT_SECRET'),
        'redirect' => env('STEAM_REDIRECT_URI')
    ],

    'github' => [
        'token' => env('GITHUB_TOKEN_SECRET')
    ],

    'discord' => [
        'webhook' => env('DISCORD_WEBHOOK_URL')
    ],

    'naver' => [
        'key' => env('NAVER_CLIENT_KEY'),
        'secret' => env('NAVER_CLIENT_SECRET'),
        'cafe' => [
            'id' => env('NAVER_CAFE_ID'),
            'menu' => env('NAVER_CAFE_MENU')
        ]
    ],

    'azure' => [
        'tenant_id' => env('AZURE_TENANT_ID'),
        'subscription_id' => env('AZURE_SUBSCRIPTION_ID'),
        'resource_group_name' => env('AZURE_RESOURCE_GROUP_NAME'),
        'billing_account_id' => env('AZURE_BILLING_ACCOUNT_ID'),
        'budget_name' => env('AZURE_BUDGET_NAME'),
        'key' => env('AZURE_CLIENT_KEY'),
        'secret' => env('AZURE_CLIENT_SECRET'),
    ],

    'vm' => [
        'ssh' => [
            'username' => env('VM_SSH_USERNAME'),
            'password' => env('VM_SSH_PASSWORD')
        ]
    ]
];
