<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                Session::flash('note.error', 'Please login at first!');

                return redirect()->guest('auth/login');
            }
        }

        if (!Auth::user()->hasRole('user') || Auth::user()->hasRole('admin')) {
            Session::flash('note.error', 'You have not user permission to access this page!');

            return redirect('/');
        }

        $cartCount = Cart::where('user_id', '=', Auth::user()->id)->sum('count');

        view()->share('cartCount', $cartCount);
        return $next($request);
    }
}
