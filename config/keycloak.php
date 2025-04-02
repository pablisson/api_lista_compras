<?php

return [
    // 'realm' => env('KEYCLOAK_REALM', 'lista_compras'),

    // 'base_url' => env('KEYCLOAK_BASE_URL', 'http://localhost:8080'),

    // 'client_id' => env('KEYCLOAK_CLIENT_ID', 'laravel-app'),

    // 'client_secret' => env('KEYCLOAK_CLIENT_SECRET', null),

    // 'redirect_uri' => env('KEYCLOAK_REDIRECT_URI', '/callback'),

    // 'public_key' => env('KEYCLOAK_PUBLIC_KEY', null),

    // 'user_roles_attribute' => env('KEYCLOAK_USER_ROLES_ATTRIBUTE', 'realm_access.roles'),


    'client_id' => env('KEYCLOAK_CLIENT_ID', 'laravel-app'),
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET', null),
    'realm' => env('KEYCLOAK_REALM', 'lista_compras'),
    'server_url' => env('KEYCLOAK_SERVER_URL', 'http://localhost:8080'),
    'redirect_uri' => env('KEYCLOAK_REDIRECT_URI', 'http://localhost:8000/auth/callback'),
];
