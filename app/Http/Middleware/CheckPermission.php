<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission = null)
    {
        if (Auth::check()) {
            if (!Auth::user()->hasPermissionTo($permission)) {
                return redirect()->route('access-denied');
            }
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized.'], 403);

    }
}
