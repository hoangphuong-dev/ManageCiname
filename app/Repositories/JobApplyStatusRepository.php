<?php

namespace App\Repositories;

use App\Models\JobApplyStatus;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class JobApplyStatusRepository.
 */
class JobApplyStatusRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return JobApplyStatus::class;
    }

    private function getTimes($userId, $jobId)
    {
        return $this->model->newQuery()->where([
            'user_id' => $userId,
            'job_id' => $jobId
        ])->groupBy('times')->select('times')->get()->toArray();
    }

    private function checkJobApplied($userId, $jobId)
    {
        return $this->model->newQuery()->where([
            'user_id' => $userId,
            'job_id' => $jobId,
            'status' => JobApplyStatus::PENDING
        ])->count() > 0;
    }

    public function applyJob($userId, $jobId)
    {
        $isApplied = $this->checkJobApplied($userId, $jobId);

        if ($isApplied) {
            return true;
        }

        $times = count($this->getTimes($userId, $jobId));

        return $this->create([
            'user_id' => $userId,
            'job_id' => $jobId,
            'times' => $times + 1
        ]);
    }
}
