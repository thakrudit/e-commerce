<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route("login");
        }
        $authUser = Auth::user()->role;

        // Log::info('Authenticated user middleware:', ['user' => Auth::user()]);

        switch ($role) {
            case "admin":
                if ($authUser == 1) {
                    return $next($request);
                }
                break;
            case 'user':
                if ($authUser == 2) {
                    return $next($request);
                }
                break;
        }

        switch ($authUser) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('home');
        }
        return redirect()->route('login');
    }
}
