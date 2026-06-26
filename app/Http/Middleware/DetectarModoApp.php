<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectarModoApp
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si la URL trae ?app=1, marcamos la sesión como "modo APK"
        if ($request->query('app') == '1') {
            session(['modo_app' => true]);
        }

        // Compartir la variable con TODAS las vistas
        view()->share('modoApp', session('modo_app', false));

        return $next($request);
    }
}