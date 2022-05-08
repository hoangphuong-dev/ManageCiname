<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        list($user) = $this->getCurrentUserLogin();
        return array_merge(parent::share($request), ViewComposeMiddleware::share(),  [
            'isSuccess' => Session::get('success'),
            'isError' => Session::get('error'),
            'timestamp' => time(),
            'user' => $user,
            'customer' => Auth::guard('customer')->user(),
            // 'api' => $token
        ]);
    }

    private function makeData($guard)
    {
        $user = Auth::guard($guard)->user();
        return [
            $user
        ];
    }

    private function getCurrentUserLogin()
    {
        if (Auth::guard('staff')->check()) {
            return $this->makeData('staff');
        }
        if (Auth::guard('admin')->check()) {
            return $this->makeData('admin');
        }
        if (Auth::guard('superadmin')->check()) {
            return $this->makeData('superadmin');
        }
        if (Auth::guard('customer')->check()) {
            return $this->makeData('customer');
        }
        return null;
    }
}
