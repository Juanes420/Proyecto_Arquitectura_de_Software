<?php

return [
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
    'openai' => [
        'key' => env('OPENAI_API_KEY'),
    ],
    'freetogame' => [
        'url' => env('FREETOGAME_URL', 'https://www.freetogame.com/api'),
    ],
    'aliados' => [
        'url' => env('ALIADOS_API_URL'),
        'nombre' => env('ALIADOS_NOMBRE', 'Grupo 9'),
    ],

];
