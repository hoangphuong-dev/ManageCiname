<?php

namespace App\Services;

use App\Notifications\ChangeStatusStaff;
use App\Repositories\StaffInfoRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class StaffInfoService
 * @package App\Services
 */
class StaffInfoService
{
    protected $staffInfoRepository;
    protected $userRepository;

    public function __construct(StaffInfoRepository $staffInfoRepository, UserRepository $userRepository)
    {
        $this->staffInfoRepository = $staffInfoRepository;
        $this->userRepository = $userRepository;
    }

    public function updateStatus($id, $data)
    {
        $staff = $this->staffInfoRepository->updateStatus($id, $data);

        $password = NULL;
        // update password user 
        if ($staff->status == 1) {
            $password = Str::random(12);
            $this->userRepository->updateUserById(['password' => Hash::make($password)], $staff->user->id);
        } else {
            // nếu nghỉ việc => set pass = NULL để hủy quyền đăng nhập
            $this->userRepository->updateUserById(['password' => $password], $staff->user->id);
        }
        Notification::send($staff->user, new ChangeStatusStaff($staff, $password));
        return $staff;
    }

    public function getAllStaff
}
