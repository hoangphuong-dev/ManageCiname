<?php

namespace App\Http\Controllers\Backs;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;

class AuthenticationController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showLogin()
    {
        return inertia('Backs/Login/Login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $fill = $request->validated();
            $route = $this->userService->loginSystem($fill);
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            if(isset($message)) {
                return back()->with($message);
            }
            // return redirect(isset($route) ? $route : route('back.login.get'));
            return redirect($route);
        }
    }

    public function logoutAdmin()
    {
        $this->userService->logoutAdmin();
        return redirect()->route('back.login.get');
    }

    public function logoutSuperAdmin()
    {
        $this->userService->logoutSuperAdmin();
        return redirect()->route('back.login.get');
    }

    public function logoutStaff()
    {
        $this->userService->logoutSuperAdmin();
        return redirect()->route('back.login.get');
    }
}
