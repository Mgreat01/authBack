<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider; // Assurez-vous que cette constante existe ou adaptez la redirection
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Rediriger vers une route appropriée, par exemple '/home' ou '/dashboard'
                // Pour l'instant, on retourne une réponse JSON pour éviter des erreurs si la route n'existe pas.
                // Idéalement, cela devrait être RouteServiceProvider::HOME ou une route nommée.
                return $request->expectsJson()
                            ? response()->json(['message' => 'Already authenticated.'], 200)
                            : redirect('/home'); // Assurez-vous que '/home' ou une route similaire existe
            }
        }

        return $next($request);
    }
}
