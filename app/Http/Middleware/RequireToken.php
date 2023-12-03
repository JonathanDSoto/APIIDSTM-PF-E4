<?php
// app/Http/Middleware/RequireToken.php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Http\Request;

class RequireToken
{
    // Lista de rutas a excluir del middleware
    protected $excludedRoutes = [
        'api/user/login',
        'api/session',
        // Agrega más rutas según sea necesario
    ];

    public function handle(Request $request, Closure $next)
    {
        // Verifica si la ruta actual está en la lista de rutas excluidas
        if (in_array($request->path(), $this->excludedRoutes)) {
            // Si es una ruta excluida, permite que la solicitud pase sin validar el token
            return $next($request);
        }

        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Token de autenticación requerido'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);
        $session = Session::where('api_token', $token) -> first();

        if(!$session) {
            return response() -> json([
                'message' => 'token invalido'
            ], 401);
        }

        return $next($request);
    }
}
?>