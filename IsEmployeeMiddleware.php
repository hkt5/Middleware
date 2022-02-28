<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployeeMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if (Auth::check())
        {

            if(Auth::user()->isEmployee())
            {
                return $next($request);
            }
        }

        return redirect('login');
    }
}
