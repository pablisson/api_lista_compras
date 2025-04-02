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


/*
Route::get('/callback', function (Request $request) {
    $code = $request->query('code');

    if (!$code) {
        return redirect('/')->with('error', 'Erro ao autenticar com Keycloak.');
    }

    // Troca o código pelo token de acesso
    $response = Http::asForm()->post(env('KEYCLOAK_SERVER_URL') . "/realms/" . env('KEYCLOAK_REALM') . "/protocol/openid-connect/token", [
        'client_id' => env('KEYCLOAK_CLIENT_ID'),
        'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => env('APP_URL') . '/callback',
    ]);

    if ($response->failed()) {
        return redirect('/')->with('error', 'Erro ao obter token do Keycloak.');
    }

    $tokenData = $response->json();
    $accessToken = $tokenData['access_token'];

    // Obter informações do usuário
    $userInfoResponse = Http::withToken($accessToken)
        ->get(env('KEYCLOAK_SERVER_URL') . "/realms/" . env('KEYCLOAK_REALM') . "/protocol/openid-connect/userinfo");

    if ($userInfoResponse->failed()) {
        return redirect('/')->with('error', 'Erro ao obter informações do usuário.');
    }

    $userInfo = $userInfoResponse->json();

    // Criar ou atualizar usuário no banco
    $user = User::updateOrCreate(
        ['email' => $userInfo['email']],
        [
            'name' => $userInfo['name'] ?? 'Usuário Keycloak',
        ]
    );

    // Autenticar o usuário
    Auth::login($user);

    return redirect('/home');
});

Route::middleware(['keycloak'])->group(function () {
    Route::get('/user', function () {
        return response()->json(Auth::guard('api')->user());
    });

    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Bem-vindo ao painel!']);
    });

    Route::resource('/home', HomeController::class)->only([
        'index', 'show'
    ]);
});
*/
