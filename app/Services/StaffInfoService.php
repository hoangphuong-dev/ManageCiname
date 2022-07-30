<?php

namespace App\Services;

use App\Models\StaffInfo;
use App\Notifications\ChangeStatusStaff;
use App\Repositories\StaffInfoRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class StaffInfoService
 * @package App\Services
 */
class StaffInfoService extends BaseService
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
        $password = NULL;

        if ($data['status'] == StaffInfo::STATUS_NOT_APPROVED) {
            // update password user 
            $password = Str::random(12);
            $staff = $this->staffInfoRepository->updateById($id, ['status' => StaffInfo::STATUS_WORKING]);
            $this->userRepository->updateUserById(['password' => Hash::make($password)], $staff->user_id);
        } else {
            // nếu nghỉ việc => set pass = NULL để hủy quyền đăng nhập
            $staff = $this->staffInfoRepository->updateById($id, ['status' => StaffInfo::STATUS_RESIGN]);
            $this->userRepository->updateUserById(['password' => $password], $staff->user_id);
        }
        Notification::send($staff->user, new ChangeStatusStaff($staff, $password));
        return;
    }

    public function delete($id)
    {
        $this->staffInfoRepository->deleteById($id);
    }
}
