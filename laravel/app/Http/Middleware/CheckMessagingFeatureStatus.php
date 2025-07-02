<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMessagingFeatureStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (env('ENABLE_MESSAGING_FEATURE') == 0) {
            return redirect('/');
        }

        return $next($request);
    }
}
