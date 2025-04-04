<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrivateController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/public', function () {
    return 'Esta é uma rota pública.';
})->name("public");

Route::get('/home', [HomeController::class, 'index'])->name('home');

/**
  * TRECHO QUE FUNCIONOU */
Route::get('/login/keycloak', function () {
    $query = http_build_query([
        'client_id' => config('keycloak.client_id'),
        'redirect_uri' => config('keycloak.redirect_uri'),
        'response_type' => 'code',
        'scope' => 'openid',
    ]);

    return redirect(config('keycloak.server_url') . "/realms/" . config('keycloak.realm') . "/protocol/openid-connect/auth?$query");
})->name("login");


Route::group(['middleware'=>'auth:api'], function () {
    Route::apiResource('/private',  'App\Http\Controllers\PrivateController', ['only' => ['index']]);
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


