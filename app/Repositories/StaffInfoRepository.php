<?php

namespace App\Repositories;

use App\Models\StaffInfo;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class StaffInfoRepository.
 */
class StaffInfoRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return StaffInfo::class;
    }

    public function updateStatus($id, $data)
    {
        $data['status'] == StaffInfo::STATUS_NOT_APPROVED ?
            $data['status'] = StaffInfo::STATUS_WORKING :
            $data['status'] = StaffInfo::STATUS_RESIGN;

        $staff = $this->model->with(['cinema', 'user'])->where('user_id', $id)->first();

        $staff->update($data);

        return $staff;
    }
}
