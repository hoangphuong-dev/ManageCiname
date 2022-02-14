<?php

namespace App\Services;

use App\Http\Resources\AdminInfoResource;
use App\Repositories\AdminInfoRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class AdminInfoService
{
    protected $adminInfoRepository;
    protected $provinceRepository;
    protected $userRepository;


    public function __construct(AdminInfoRepository $adminInfoRepository, ProvinceRepository $provinceRepository, UserRepository $userRepository)
    {
        $this->adminInfoRepository = $adminInfoRepository;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
    }

    public function getProvince()
    {
        return $this->provinceRepository->all();
    }

    public function store($request)
    {
        $fill = $request->validated();
        try {
            DB::beginTransaction();
            $user = $this->userRepository->createAdminInfo($fill);

            $this->adminInfoRepository->store($fill, $user->id);

            $user->load('adminInfo');

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function list($request)
    {
        $admins = $this->adminInfoRepository->list($request);
        return AdminInfoResource::collection($admins);
    }
}
