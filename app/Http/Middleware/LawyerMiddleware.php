<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LawyerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasRole('lawyer')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the professional dashboard.');
        }

        return $next($request);
    }
}
