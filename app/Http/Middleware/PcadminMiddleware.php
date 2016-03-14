<?php

namespace App\Http\Middleware;

use Closure;

class PcadminMiddleware
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
        if (!$request->session()->has('admin_login')) {
            return view::make('Admin.index')->with('message', '登录超时，请重新登录！');
        }
        
        return $next($request);
    }
}
