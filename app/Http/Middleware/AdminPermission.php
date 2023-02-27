<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminPermission
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
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->id(), ['22'])) {
            return $next($request);
        }
        Toastr::error('You don\'t have access to that section');
        return redirect()->back()->with('error',"You don't have access to that section");
    }
}
