<?php
// app/Http/Middleware/RequireToken.php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WebSpecificMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request -> attributes->get('token');
        
        if (!$authorizationHeader) {
            return redirect()->route('login')->with('error', 'Token de autenticación no válido, inicie sesión para obtener uno válido');
        }

        $session = Session::where('api_token', $authorizationHeader) -> first();

        if(!$session) {
            // Session::destroy($session -> id);
            return redirect()->route('login')->with('error', 'Token de autenticación no válido, inicie sesión para obtener uno válido');
        }

        return $next($request);
    }
}
?>