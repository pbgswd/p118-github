<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBanned
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        if (auth()->check() && (auth()->user()->is_banned == 1)) {
            auth()->logout();
            $message = 'Your account has been suspended. Please contact the administrator to sort it out.';

            return redirect()->route('login')->withMessage($message);
        }

        return $next($request);
    }
}
