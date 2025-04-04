<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class keycloakMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return response()->json(['error' => 'Token JWT ausente'], 401);
        }

        /**
         * a função Auth::guard('keycloak')->check()
         * busca verifica se o usuário existena classe app/Services/KeycloakGuard.php que criamos.
         * Esse keycloakGuard nós associamos no provider
         *  */
        if (!Auth::guard('keycloak')->check()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        return $next($request);
    }
}
