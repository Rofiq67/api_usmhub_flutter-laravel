<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'storage/photos/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://admin-usmhub.com'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
