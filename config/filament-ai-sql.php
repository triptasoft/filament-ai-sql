<?php

// config for Triptasoft/FilamentAiSql
return [
    'gemini_api_key' => env('GEMINI_API_KEY', ''),
    'allowed_sql_functions' => [
        'select',
        'insert',
        'update',
    ],
];
