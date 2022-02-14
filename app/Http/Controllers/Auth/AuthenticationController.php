<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaretakerRegisterRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\HospitalRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\CustomerService;
use Inertia\Inertia;
use App\Services\HospitalTypeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    private $hospitalTypeService;
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        return inertia('Common/Users/Login');
    }

    public function handleLogin(LoginRequest $request)
    {
        try {
            $fill = $request->validated();
            $route = $this->userService->login($fill);
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            if (isset($message)) {
                return back()->with($message);
            }
            return redirect(isset($route) ? $route : route('home'));
        }
    }

    public function logoutCustomer()
    {
        $this->userService->logoutCustomer();
        return redirect()->route('show_login');
    }

    public function showChangePassword()
    {
        return inertia('Common/Users/ChangePassword');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $fill = $request->validated();

            $this->userService->changePassword($fill);

            $message = ['success' => __('change password success')];
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            if (array_key_exists('error', $message)) {
                return back()->with($message);
            }
            return redirect(route('login'))->with($message);
        }
        $hospitalTypes = $this->hospitalTypeService->all();
        return Inertia::render('Profile/Show', [
            'hospitalTypes' => $hospitalTypes
        ]);
    }

    public function showForgotPassword()
    {
        return inertia('Common/Users/ForgotPassword');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $fill = $request->validated();

            $this->userService->forgotPassword($fill);

            $message = ['success' => __('please check email and reset password')];
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            if (array_key_exists('error', $message)) {
                return back()->with($message);
            }
            return redirect(route('login'))->with($message);
        }
    }

    public function showResetPassword(Request $request)
    {
        try {
            $token = $request->input('token');
            if (empty($token)) {
                throw new \Exception(__('token does not exist'));
            }
            $this->userService->checkToken($token);
            return inertia('Common/Users/FormNewPassword');
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
            return redirect(route('login'))->with($message);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $fill = $request->validated();

            $this->userService->resetPassword($fill);

            $message = ['success' => __('reset password successful')];
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            if (array_key_exists('error', $message)) {
                return back()->with($message);
            }
            return redirect(route('login'))->with($message);
        }
    }

    public function confirmAccount(Request $request)
    {
        try {
            $token = $request->input('token');
            if (empty($token)) {
                throw new \Exception("Url is incorrectly");
            }
            $this->userService->confirmAccount($token);
            $message = ['success' => __('confirm account success')];
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            return redirect(route('login'))->with($message ?? []);
        }
    }
}
