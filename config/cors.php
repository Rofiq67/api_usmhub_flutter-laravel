<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'storage/photos/*'],

    'allowed_methods' => ['*'],

    // 'allowed_origins' => ['http://admin-usmhub.com'],

    'allowed_origins' => ['http://localhost:8000', 'http://127.0.0.1:8000', 'http://192.168.0.105'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
