<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Temporairement, permettre à tous les utilisateurs connectés d'accéder au tableau de bord administrateur
        if (Auth::check()) {
            return $next($request);
        }

        // Rediriger vers la page d'accueil avec un message d'erreur
        return redirect()->route('home')->with('error', 'Vous n\'avez pas les droits d\'accès à cette section.');
    }
}
