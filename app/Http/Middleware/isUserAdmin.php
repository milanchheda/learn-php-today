<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isUserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->hasRole('administrators')) {
            // abort(403, 'Unauthorized action.');
            return $next($request);
        }
        return redirect()->route('/');
        // abort(403, 'Unauthorized action.');
    }
}
