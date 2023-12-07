<?php
// app/Http/Middleware/ExtractToken.php

namespace App\Http\Middleware;

use Closure;

class ExtractToken
{
    public function handle($request, Closure $next)
    {
        $authorizationHeader = $request->cookie('token');

        if ($authorizationHeader) {
            // Establecer el valor de la cookie en la solicitud para que otros middleware lo utilicen
            $request->attributes->add(['token' => $authorizationHeader]);
        }

        return $next($request);
    }
}

?>