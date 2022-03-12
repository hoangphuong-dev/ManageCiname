<?php

namespace App\Repositories;

use App\Models\AdminInfo;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class AdminInfoRepository.
 */
class AdminInfoRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return AdminInfo::class;
    }

    public function store($fill, $user_id)
    {
        return $this->create([
            'user_id' => $user_id,
            'province_id' => $fill['province'],
        ]);
    }


    public function list($request)
    {
        return $this->model->query()
            ->with(['user' => function ($query) {
                return $query->where('role', User::ROLE_ADMIN);
            }, 'province'])
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })

            ->paginate($request->query('limit', 12));
    }

    public function getProvinceShowMovie()
    {
        return $this->model->query()
            ->with('province')->get();
    }

    public function getIdAdminInfo($admin_id)
    {
        $admin_info = $this->model->query()->where('user_id', $admin_id)->firstOrFail();
        return !is_null($admin_info) ? $admin_info->id : null;
    }

    public function getArrayIdAdminInfo()
    {
        return $this->model->query()->select('id')->get()->toArray();;
    }
}
