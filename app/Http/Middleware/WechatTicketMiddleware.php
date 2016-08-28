<?php

namespace App\Http\Middleware;

use Closure;

class WechatTicketMiddleware
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
            return Redirect::action('Ticket\TicketController@index');
        }
        return $next($request);
    }
}
