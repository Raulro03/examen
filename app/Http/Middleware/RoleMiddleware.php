<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Si el usuario no está autenticado, redirige al login
        if (!$request->user()) {
            return redirect()->route('login');  // Redirige al login si no está autenticado
        }

        // Si el rol no es el que esperamos, redirige al dashboard correspondiente
        if ($request->user()->role !== $role) {
            return $this->redirectToDashboard($request);
        }

        // Si el rol coincide, continúa con la solicitud
        return $next($request);
    }

    /**
     * Redirige al dashboard correspondiente según el rol.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function redirectToDashboard(Request $request)
    {
        // Si el usuario es admin, redirige al admin dashboard
        if ($request->user()->role === 'admin') {
            return redirect()->route('pages.admin-dashboard');
        }

        // Si el usuario es cliente, redirige al dashboard del cliente
        return redirect()->route('pages.client-dashboard');
    }
}
