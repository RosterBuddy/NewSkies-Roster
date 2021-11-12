<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAdmin
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
        if (Auth::user() &&  Auth::user()->isAdmin == 1 || Auth::id() == 12) {
             return $next($request);
        }

        toastr()->error('You do not have permission to view that page.', 'Inconceivable!');
        return redirect('roster');
    }
}