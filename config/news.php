<?php

return [
    'news_api' => [
        'api_url' => env('NEWS_SOURCE_NEWS_API_URL'),
        'api_key' => env('NEWS_SOURCE_NEWS_API_KEY')
    ],

    'the_guardian' => [
        'api_url' => env('NEWS_SOURCE_THE_GUARDIAN_API_URL'),
        'api_key' => env('NEWS_SOURCE_THE_GUARDIAN_API_KEY')
    ],

    'ny_times' => [
        'api_url' => env('NEWS_SOURCE_NY_TIMES_API_URL'),
        'api_key' => env('NEWS_SOURCE_NY_TIMES_API_KEY')
    ]
];
