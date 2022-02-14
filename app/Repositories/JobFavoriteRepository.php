<?php

namespace App\Repositories;

use App\Models\JobFavorite;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


/**
 * Class JobFavoriteRepository.
 */
class JobFavoriteRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return JobFavorite::class;
    }

    public function getModel($userId, $jobId)
    {
        return $this->model->newQuery()->where([
            'user_id' => $userId,
            'job_id' => $jobId
        ]);
    }

    public function deleteFavorite($userId, $jobId)
    {
        return $this->getModel($userId, $jobId)->delete();
    }

    public function make($userId, $jobId) {
        $isExisted = $this->getModel($userId, $jobId)->count();
        
        if($isExisted > 0) {
            return true;
        }
        return $this->create([
            'user_id' => $userId,
            'job_id' => $jobId
        ]);
    }
}
