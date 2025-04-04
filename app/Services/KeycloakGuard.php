<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

/**
 * Esse arquivo contém a lógica para etrari as informações do usuário do token JWT
 */
class KeycloakGuard implements Guard
{
    protected $user;
    protected $provider;
    protected $request;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function guest()
    {
        return !$this->check();
    }

    public function id()
    {
        return $this->user ? $this->user->getAuthIdentifier() : null;
    }

    public function hasUser()
    {
        return !is_null($this->user);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function check()
    {
        return !is_null($this->user());
    }

    public function user()
    {
        // verifica se o usuário existe
        if ($this->user) {
            return $this->user;
        }

        // pega o token e verfica se o mesmo existe
        $token = $this->request->bearerToken();
        if (!$token) {
            return null;
        }

        // decodigica a chave para pegar os dados do arquivo JWT
        try {
            $decoded = JWT::decode($token, new Key(config('keycloak.realm_public_key'), 'RS256'));

            $this->user = User::firstOrCreate([
                'email' => $decoded->email,
            ], [
                'name' => $decoded->name,
                'password' => bcrypt(str()->random(16)),
            ]);

            return $this->user;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function validate(array $credentials = [])
    {
        return false;
    }
}
