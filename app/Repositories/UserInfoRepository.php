<?php

namespace App\Repositories;

use App\Models\UserInfo;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class UserInfoRepository.
 */
class UserInfoRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return UserInfo::class;
    }

    public function make($fill)
    {
        return $this->create($fill);
    }
}
