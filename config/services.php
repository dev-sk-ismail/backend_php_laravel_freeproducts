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
        'scheme' => 'https',
    ],

    'klaviyo' => [
        'api_key' => env('KLAVIYO_API_KEY'),
        'list_id_first' => env('KLAVIYO_LIST_ID_FIRST'),
        'list_id_final' => env('KLAVIYO_LIST_ID_FINAL'),
        'api_endpoint' => 'https://a.klaviyo.com/api/v2/list',
    ],

    'shopify' => [
        'domain' => env('SHOPIFY_DOMAIN', 'uukia7-p6.myshopify.com'),
        'access_token' => env('SHOPIFY_ACCESS_TOKEN'),
        'api_version' => '2025-01',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
