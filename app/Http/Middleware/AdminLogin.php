<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

session_start();

class AdminLogin
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
        if (Session::get('admin_id')) {
            return $next($request);
        } else {
            return redirect('dang-nhap');
        }
    }
}
