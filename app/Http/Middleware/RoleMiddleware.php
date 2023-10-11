<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = DB::table('akun')->where('auth_id', Session::has('user') ? Session::get('user')['auth_id'] : '')->get();
        if (count($auth) > 0)
        {
            Session::put('user.status', $auth[0]->status);
            return $next($request);
        }
        return abort(403, 'Forbidden');
    }
}
