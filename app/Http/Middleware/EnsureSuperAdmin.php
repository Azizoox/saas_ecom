<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role !== 'super_admin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Accès non autorisé.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Accès réservé aux super administrateurs.');
        }

        return $next($request);
    }
}
