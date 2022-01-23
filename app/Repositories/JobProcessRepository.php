<?php

namespace App\Repositories;

use App\Models\JobProcess;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class JobProcessRepository.
 */
class JobProcessRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return JobProcess::class;
    }

    public function findFirstProcess($jobId) {
        return $this->model->newQuery()->where('job_id', $jobId)->orderBy('order')->first();
    }

    public function findNextProcess($id)
    {
        $process = $this->model->newQuery()->findOrFail($id);
        return $this->model->newQuery()->where([
            'job_id' => $process->job_id,
            'order' => $process->order + 1
        ])->first();

    }
}
