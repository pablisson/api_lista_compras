<?php

use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login/keycloak', function () {
    $query = http_build_query([
        'client_id' => config('keycloak.client_id'),
        'redirect_uri' => config('keycloak.redirect_uri'),
        'response_type' => 'code',
        'scope' => 'openid',
    ]);

    return redirect(config('keycloak.server_url') . "/realms/" . config('keycloak.realm') . "/protocol/openid-connect/auth?$query");
});

Route::get('/auth/callback', function (Request $request) {
    $response = Http::asForm()->post(config('keycloak.server_url') . "/realms/" . config('keycloak.realm') . "/protocol/openid-connect/token", [
        'grant_type' => 'authorization_code',
        'client_id' => config('keycloak.client_id'),
        'client_secret' => config('keycloak.client_secret'),
        'redirect_uri' => config('keycloak.redirect_uri'),
        'code' => $request->query('code'),
    ]);

    return response()->json($response->json());
});

