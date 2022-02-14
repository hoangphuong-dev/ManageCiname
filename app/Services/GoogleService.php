<?php

namespace App\Services;

use App\Exceptions\LoginGoogleFailException;
use App\Models\User;
use App\Repositories\UserInfoRepository;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoogleService
{

    private $userRepository;
    private $userInfoRepository;

    public function __construct(UserRepository $userRepository, UserInfoRepository $userInfoRepository)
    {
        $this->userRepository = $userRepository;
        $this->userInfoRepository = $userInfoRepository;
    }

    public function login()
    {
        try {
            DB::beginTransaction();
            $googleUser = Socialite::driver('google')->stateless()->user();

            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();
            $avatar = $googleUser->getAvatar();
            $name = $googleUser->getName();

            $user = $this->userRepository->findByEmail($email);

            $userId = null;
            if ($user === null) {
                $user = $this->userRepository->createCaretaker([
                    'name' => $name,
                    'email' => $email,
                    'password' => $googleId
                ]);

                $this->userInfoRepository->make([
                    'user_id' => $user->id
                ]);

                $user->status = User::CARETAKER_STATUS_DONE;
                $user->avatar = $avatar;
                $user->google_id = $googleId;
                $user->save();

                $userId = $user->id;
            } else if ($user->google_id === $googleId) {
                $user->avatar = $avatar;
                $user->name = $name;
                $user->save();
                $userId = $user->id;
            }

            if($userId !== null) {
                DB::commit();
                return Auth::guard('caretaker')->loginUsingId($userId, true);
            }
            throw new LoginGoogleFailException('Tài khoản này đã có nguời sử dụng. Hãy thử lại với tài khoản khác');
        } catch (LoginGoogleFailException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception('Something went wrong');
        } finally {
            DB::rollback();
        }
    }
}
