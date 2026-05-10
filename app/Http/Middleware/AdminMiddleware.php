<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // belum login
        if (!Auth::check()) {

            return redirect('/admin/login');
        }

        // bukan admin
        if (Auth::user()->role !== 'admin') {

            Auth::logout();

            return redirect('/admin/login');
        }

        return $next($request);
    }
}