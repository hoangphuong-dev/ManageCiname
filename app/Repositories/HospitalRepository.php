<?php

namespace App\Repositories;

use App\Models\JobApplyStatus;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class HospitalRepository extends BaseRepository
{

    public function model()
    {
        return User::class;
    }

    public function analytics($request)
    {
        $daterange = $request->query('daterange');

        $sqlWhere = '';
        if(!is_null($daterange) && is_array($daterange)) {
            $sqlWhere = "AND( jobs.created_at BETWEEN '$daterange[0]' AND '$daterange[1]')";
        }
        $sql = "SELECT COUNT(*) FROM jobs JOIN job_apply_statuses AS jas ON jas.job_id = jobs.id WHERE jobs.user_id = users.id AND jas.status = ? $sqlWhere";

        $analytic = $this->model->newQuery()
        ->where('role', User::ROLE_HOSPITAL)
        ->orderBy('created_at', 'desc')
        ->selectRaw("
        users.id,
        users.name,
        (SELECT COUNT(*) FROM jobs WHERE users.id = jobs.user_id $sqlWhere) as jobCount,
        (" .str_replace('?', JobApplyStatus::PENDING, $sql). ") as jobPending,
        (" .str_replace('?', JobApplyStatus::SUCCESS, $sql). ") as jobSuccess,
        (" .str_replace('?', JobApplyStatus::REJECT, $sql). ") as jobReject
        ")
        ->paginate($request->query('limit', 10));

        return $analytic;
    }

}
