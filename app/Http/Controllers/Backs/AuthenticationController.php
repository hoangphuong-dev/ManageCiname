<?php

namespace App\Http\Controllers\Backs;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterStaffRequest;
use App\Services\CinemaService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    private $userService;
    public $cinemaService;

    public function __construct(UserService $userService, CinemaService $cinemaService)
    {
        $this->userService = $userService;
        $this->cinemaService = $cinemaService;
    }

    public function showLogin()
    {
        return inertia('Backs/Login/Login');
    }

    public function registerStaff()
    {
        $provinces = $this->cinemaService->getProvinceAllCinema();
        return inertia('Backs/RegisterStaff', [
            'provinces' => $provinces,
        ]);
    }

    public function registerSubmit(RegisterStaffRequest $request)
    {
        $data = $request->validated();
        try {
            $this->userService->createStaff($data);
            $message = ['success' => 'Đăng ký thành công , Vui lòng chờ xác nhận của quản trị viên rạp phim !'];
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        }
        return redirect()->route('back.login.get')->with($message);
    }


    public function login(LoginRequest $request)
    {
        try {
            $fill = $request->validated();
            $route = $this->userService->loginSystem($fill);
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            if (isset($message)) {
                return back()->with($message);
            }
            // return redirect(isset($route) ? $route : route('back.login.get'));
            return redirect($route);
        }
    }

    public function confirmAdmin(Request $request, $admin_id)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $this->userService->confirmAdmin($admin_id);

        return redirect()->route('back.login.get');
    }

    public function logoutAdmin()
    {
        $this->userService->logoutAllGuard();
        return redirect()->route('back.login.get');
    }

    public function logoutSuperAdmin()
    {
        $this->userService->logoutAllGuard();
        return redirect()->route('back.login.get');
    }

    public function logoutStaff()
    {
        $this->userService->logoutAllGuard();
        return redirect()->route('back.login.get');
    }
}
