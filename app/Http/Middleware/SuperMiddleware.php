<?php

namespace App\Http\Middleware;
use Redirect;
use \View;
use Closure;
use Illuminate\Http\Request;
class SuperMiddleware
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
        if (!$request->session()->has('super_login')) {
            return view::make('super.index')->with('message', '登录超时，请重新登录！');
        }
        
        return $next($request);
    }
}
