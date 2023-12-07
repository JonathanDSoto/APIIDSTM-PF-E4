<?php
// app/Http/Middleware/RequireToken.php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Http\Request;

class ApiSpecificMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request -> attributes->get('token');
        
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Token de autenticación requerido, inicie sesion para obtenerlo'], 401);
        }

        $session = Session::where('api_token', $authorizationHeader) -> first();

        if(!$session) {
            // Session::destroy($session -> id);
            return response() -> json([
                'message' => 'token invalido, inicie sesion para que se genere de nuevo'
            ], 401);
        }

        return $next($request);
    }
}
?>