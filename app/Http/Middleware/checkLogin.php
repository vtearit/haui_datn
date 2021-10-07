<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

session_start();

class checkLogin
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
        if (Session::get('user_id')) {
            return redirect('/');
        } else {
            return $next($request);
        }
    }
}
