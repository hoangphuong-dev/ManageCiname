<?php

namespace App\Repositories;

use App\Models\JobPostApply;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class JobPostApplyRepository.
 */
class JobPostApplyRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return JobPostApply::class;
    }

    public function update($job_apply_status_id, $job_process_id, $status)
    {
        return $this->model->newQuery()->where([
            'job_apply_status_id' => $job_apply_status_id,
            'job_process_id' => $job_process_id
        ])->update([
            'status' => $status
        ]);
    }

    public function make($fill)
    {
        return $this->create($fill);
    }
}
