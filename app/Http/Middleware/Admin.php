<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!Auth::user() || (Auth::user() && !Auth::user()->hasRole('admin'))) {

            Session::flash('note.error', 'You have not admin permission to access this page');
            return redirect('/');
        }

        return $next($request);
    }
}
