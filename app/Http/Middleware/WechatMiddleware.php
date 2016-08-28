<?php

namespace App\Http\Middleware;

use Closure;
use Redirect,Session;

class WechatMiddleware
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
        if (!$request->session()->has('wechat_user')) {
            return Redirect::action('WechatController@pchelp');
        }
        return $next($request);
    }
}
