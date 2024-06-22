<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
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
