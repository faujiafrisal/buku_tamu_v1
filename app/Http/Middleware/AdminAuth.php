<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request for Admin-only routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('admin_authenticated') !== true) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Unauthenticated admin request.'], 401);
            }

            return redirect()->guest(route('admin.login'))
                ->with('error', 'Akses ditolak. Silakan login terlebih dahulu.');
        }

        $response = $next($request);

        // Add no-cache headers to prevent back-button caching after logout
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}
