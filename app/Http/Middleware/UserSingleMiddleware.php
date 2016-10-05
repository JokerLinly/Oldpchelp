<?php

namespace App\Http\Middleware;

use Closure;
use Redirect,Session;

class UserSingleMiddleware
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
        if (!$request->session()->has('wechat_user') && !$request->session()->has('wcuser_id')) {
            return Redirect::action('WechatController@userSingleTicket');
        }
        return $next($request);
    }
}
