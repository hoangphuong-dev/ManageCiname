<?php

namespace App\Services;

use App\Events\CreateAdmin;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class UserService
{
    protected $userRepository;
    protected $hospitalInfoRepository;

    public function __construct(
        UserRepository $userRepository,
        HospitalInfoRepository $hospitalInfoRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->hospitalInfoRepository = $hospitalInfoRepository;
    }

    public function checkOrderCustomer($data)
    {
        return $this->userRepository->createCustomer($data);
    }



    public function updateUserById($fill, $user_id)
    {
        return $this->userRepository->updateUserById($fill, $user_id);
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

    // private function getTimeToken()
    // {
    //     $tokenExpired = TOKEN_EXPIRED;
    //     return strtotime("+$tokenExpired minutes");
    // }

    // public function forgotPassword($fill)
    // {
    //     try {
    //         $user = $this->userRepository->findByEmail($fill['email']);
    //         if ($user === null) {
    //             throw new ChangePasswordException('email address does not exist');
    //         }

    //         $token = Str::random(30);
    //         $time = $this->getTimeToken(); //expire after 5 minute

    //         $token = "$token.$time";
    //         $user->token_life_time = $token;
    //         $user->save();

    //         Mail::to($user->email)->queue(new ForgotPassword($token));
    //     } catch (ChangePasswordException $e) {
    //         throw $e;
    //     } catch (\Exception $e) {
    //         throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
    //     }
    // }

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

    // public function confirmAccount($token)
    // {
    //     try {
    //         $user = $this->userRepository->findByToken($token);

    //         if ($user === null) {
    //             throw new ChangePasswordException('Url is incorrectly');
    //         }

    //         $user->status = User::CARETAKER_STATUS_DONE;
    //         $user->token_life_time = null;
    //         $user->save();
    //     } catch (ChangePasswordException $e) {
    //         throw $e;
    //     } catch (\Exception $e) {
    //         throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
    //     }
    // }
    public function updateUserByEmail($fill)
    {
        $user = $this->userRepository->findByEmail($fill['email']);
        $this->userRepository->updateUserByEmail();
    }

    public function confirmAdmin($admin_id)
    {
        return $this->userRepository->confirmAdmin($admin_id);
    }

    // đăng nhập khách hàng
    public function login($fill)
    {
        try {
            $this->logoutCustomer();

            $email = $fill['email'];
            $password = $fill['password'];
            $isRemember = $fill['isRemember'];
            $user = $this->userRepository->findByEmail($email);

            //check status
            // if ($user->IsAccountDeActive()) {
            //     throw new LoginFailException(__("Tài khoản của bạn đang bị khóa . Liên hệ admin để được hỗ trợ !"));
            // }

            //check password
            if (!Hash::check($password, $user->password) || !$user->IsCustomer() || $user === null) {
                throw new LoginFailException(__('Email hoặc mật khẩu không chính xác !'));
            }

            //check role
            $guard = $user->guardName();

            Auth::guard($guard)->loginUsingId($user->id, $isRemember);

            return $user->routeRedirect();
        } catch (LoginFailException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }
    // tao tai khoan admin 
    public function createAdmin($fill)
    {
        $password = Str::random(12);

        $data['name'] = $fill['name'];
        $data['phone'] = $fill['phone'];
        $data['email'] = $fill['email'];
        $data['password'] = Hash::make($password);

        $admin = $this->userRepository->createAdmin($data);

        $url = URL::signedRoute('back.confirm.acount', ['admin_id' => $admin->id]);

        event(new CreateAdmin($data['email'], $password, $url));
        return $admin;
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
                throw new LoginFailException(__('Email hoặc mật khẩu không chính xác !'));
            }
            //check status
            if ($user->IsAccountDeActive()) {
                throw new LoginFailException(__("Tài khoản của bạn đang bị khóa . Liên hệ admin để được hỗ trợ !"));
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
