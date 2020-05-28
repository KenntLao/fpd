<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserID
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
        if(!isset($_SESSION['sys_id'])){
            return redirect('/');
        }
        return $next($request);
    }
}
