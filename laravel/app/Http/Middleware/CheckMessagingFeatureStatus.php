<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckMessagingFeatureStatus
{
    public function handle(Request $request, Closure $next): RedirectResponse
    {
        if (env('ENABLE_MESSAGING_FEATURE') == 0) {
            return redirect('/');
        }

        return $next($request);
    }
}
