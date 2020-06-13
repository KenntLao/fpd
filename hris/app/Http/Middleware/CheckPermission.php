<?php

namespace App\Http\Middleware;

include('../../../../includes/support/permissions.php');
use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!in_array($permission, $_SESSION['sys_permissions'])) {
            return redirect()->back();
        }
        return $next($request);
    }

}
