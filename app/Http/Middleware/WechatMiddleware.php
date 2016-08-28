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
        dd(empty($_SESSION['wechat_user']) && !$request->has('code'));
        if (empty($_SESSION['wechat_user']) && !$request->has('code')) {
            return Redirect::action('WechatController@pchelp');
        }
        return $next($request);
    }
}
