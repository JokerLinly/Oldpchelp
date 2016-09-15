<?php

namespace App\Http\Middleware;

use Redirect,Session;
use Closure;

class PcerMiddleware
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
            return Redirect::action('WechatController@pcer');
        }
        return $next($request);
    }
}
