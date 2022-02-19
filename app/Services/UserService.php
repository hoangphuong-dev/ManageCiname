<?php

namespace App\Services;

use App\Exceptions\ChangePasswordException;
use App\Exceptions\LoginFailException;
use App\Helper\ImageHelper;
use App\Http\Resources\UserResource;
use App\Mail\CaretakerRegister;
use App\Mail\ForgotPassword;
use App\Mail\MailLoginInfo;
use App\Models\User;
use App\Models\UserInfo;
use App\Repositories\UserRepository;
use App\Repositories\HospitalInfoRepository;
use App\Repositories\UserInfoRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService
{
    protected $userRepository;
    protected $hospitalInfoRepository;
    protected $userInfoRepository;

    public function __construct(
        UserRepository $userRepository,
        HospitalInfoRepository $hospitalInfoRepository,
        UserInfoRepository $userInfoRepository
    ) {
        $this->userRepository = $userRepository;
        $this->hospitalInfoRepository = $hospitalInfoRepository;
        $this->userInfoRepository = $userInfoRepository;
    }



    public function updateStatusHospital($id, $request)
    {
        return $this->userRepository->updateStatus($id, $request->status);
    }

    public function changePassword($fill)
    {
        try {
            $user = $this->userRepository->findByEmail($fill['email']);
            if ($user === null) {
                throw new ChangePasswordException('email address does not exist');
            }

            if (!Hash::check($fill['oldPassword'], $user->password)) {
                throw new ChangePasswordException('old password incorrect');
            }

            $user->password = Hash::make($fill['newPassword']);
            $user->save();
        } catch (ChangePasswordException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }

    private function getTimeToken()
    {
        $tokenExpired = TOKEN_EXPIRED;
        return strtotime("+$tokenExpired minutes");
    }

    public function forgotPassword($fill)
    {
        try {
            $user = $this->userRepository->findByEmail($fill['email']);
            if ($user === null) {
                throw new ChangePasswordException('email address does not exist');
            }

            $token = Str::random(30);
            $time = $this->getTimeToken(); //expire after 5 minute

            $token = "$token.$time";
            $user->token_life_time = $token;
            $user->save();

            Mail::to($user->email)->queue(new ForgotPassword($token));
        } catch (ChangePasswordException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }

    public function checkToken($token)
    {
        try {
            $user = $this->userRepository->findByToken($token);

            if ($user === null) {
                throw new ChangePasswordException('Url is incorrectly');
            }

            $explode = explode('.', $token);
            $time = end($explode);

            $currentTime = time();

            if ((int)$time < $currentTime) {
                throw new ChangePasswordException('Url signature expired');
            }

            return $user;
        } catch (ChangePasswordException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }

    public function resetPassword($fill)
    {
        try {
            $user = $this->checkToken($fill['token']);
            $user->password = Hash::make($fill['newPassword']);
            $user->token_life_time = null;
            $user->save();
        } catch (ChangePasswordException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }

    public function confirmAccount($token)
    {
        try {
            $user = $this->userRepository->findByToken($token);

            if ($user === null) {
                throw new ChangePasswordException('Url is incorrectly');
            }

            $user->status = User::CARETAKER_STATUS_DONE;
            $user->token_life_time = null;
            $user->save();
        } catch (ChangePasswordException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }

    public function listCareTaker($request)
    {
        $listCareTaker = $this->userRepository->listCareTaker($request);
        return UserResource::collection($listCareTaker);
    }

    // đăng nhập khách hàng
    public function login($fill)
    {
        try {
            auth('customer')->logout();

            $email = $fill['email'];
            $password = $fill['password'];
            $isRemember = $fill['isRemember'];
            $user = $this->userRepository->findByEmail($email);

            //check status
            if ($user->IsAccountDeActive()) {
                throw new LoginFailException(__("your account has been suspended. please contact admin support"));
            }

            //check password
            if (!Hash::check($password, $user->password) || !$user->IsCustomer() || $user === null) {
                throw new LoginFailException(__('email or password is incorrect'));
            }

            //check role
            $guard = $user->guardName();
            Auth::guard($guard)->loginUsingId($user->id, $isRemember);
        } catch (LoginFailException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }
    // đăng nhập hệ thống Admin
    public function loginSystem($fill)
    {
        try {
            $this->logoutAllGuard();

            $email = $fill['email'];
            $password = $fill['password'];
            $isRemember = $fill['isRemember'];
            $user = $this->userRepository->findByEmail($email);
            //check password
            if ($user === null || !Hash::check($password, $user->password) || $user->IsCustomer()) {
                throw new LoginFailException(__('email or password is incorrect'));
            }
            //check status
            if ($user->IsAccountDeActive()) {
                throw new LoginFailException(__("your account has been suspended. please contact admin support"));
            }

            $guard = $user->guardName();

            Auth::guard($guard)->loginUsingId($user->id, $isRemember);

            return $user->routeRedirect();
        } catch (LoginFailException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }
    // logout hệ thống
    private function logoutAllGuard()
    {
        auth('admin')->logout();
        auth('superadmin')->logout();
        auth('customer')->logout();
        auth('staff')->logout();
    }

    public function logoutAdmin()
    {
        $this->logout('admin');
    }

    public function logoutSuperAdmin()
    {
        $this->logout('superadmin');
    }

    public function logoutStaff()
    {
        $this->logout('staff');
    }

    public function logoutCustomer()
    {
        $this->logout('customer');
    }

    private function logout($type)
    {
        Auth::guard($type)->logout();
    }
}
