<?php
// app/Http/Middleware/RequireToken.php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RequireTokenWeb
{
    // Lista de rutas a excluir del middleware
    protected $excludedRoutes = [
        '/',
        // Agrega más rutas según sea necesario
    ];

    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request-> cookie('token');
        var_dump($authorizationHeader);
        // Verifica si la ruta actual está en la lista de rutas excluidas
        if (in_array($request->path(), $this->excludedRoutes)) {
            // Si es una ruta excluida, permite que la solicitud pase sin validar el token
            return $next($request);
        }
        
        if (!$authorizationHeader) {
            // return redirect()->route('login')->with('error', 'Token de autenticación no válido, inicie sesión para obtener uno válido');
            // return response()->json(['error' => 'Token de autenticación requerido, inicie sesion para obtenerlo'], 401);
        }

        // $token = str_replace('Bearer ', '', $authorizationHeader);
        $session = Session::where('api_token', $authorizationHeader) -> first();

        if(!$session) {
            // Session::destroy($session -> id);
            // return redirect()->route('login')->with('error', 'Token de autenticación no válido, inicie sesión para obtener uno válido');
        }

        return $next($request);
    }
}
?>