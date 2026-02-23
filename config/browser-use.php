<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Browser Use API Key
    |--------------------------------------------------------------------------
    |
    | Your Browser Use Cloud API key. You can find this in your
    | Browser Use Cloud dashboard.
    |
    */
    'api_key' => env('BROWSER_USE_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Browser Use Cloud API.
    |
    */
    'base_url' => env('BROWSER_USE_BASE_URL', rtrim((string) env('APP_URL', 'http://localhost'), '/') . '/api/v2'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout in seconds for API requests.
    |
    */
    'timeout' => env('BROWSER_USE_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    |
    | Number of times to retry failed requests and the delay between retries.
    |
    */
    'retry' => [
        'times' => env('BROWSER_USE_RETRY_TIMES', 3),
        'sleep' => env('BROWSER_USE_RETRY_SLEEP', 1000), // milliseconds
    ],
];
