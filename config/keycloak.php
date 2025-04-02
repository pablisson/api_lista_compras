<?php

return [
    'client_id' => env('KEYCLOAK_CLIENT_ID', 'laravel-app'),
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET', null),
    'realm' => env('KEYCLOAK_REALM', 'lista_compras'),
    'server_url' => env('KEYCLOAK_SERVER_URL', 'http://localhost:8080'),
    'redirect_uri' => env('KEYCLOAK_REDIRECT_URI', 'http://localhost:8000/auth/callback'),
];
