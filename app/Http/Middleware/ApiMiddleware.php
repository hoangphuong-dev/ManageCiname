<?php

namespace App\Http\Middleware;

use App\Helper\JwtHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiMiddleware
{
    protected $except = [
        '/api/jobs',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }


    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (is_null($guard)) {
            return $next($request);
        }

        if($guard === 'common') {
            if(Auth::guard('caretaker')->check() || Auth::guard('hospital')->check()) {
                return $next($request);
            }
        }

        if(!Auth::guard($guard)->check() && !$this->inExceptArray($request)) {
            abort(401);
        }

        return $next($request);
    }
}
