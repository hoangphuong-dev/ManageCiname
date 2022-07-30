<?php

namespace App\Services;

use App\Http\Resources\CinemaResource;
use App\Repositories\CinemaRepository;

class CinemaService extends BaseService
{
    protected $cinemaRepository;
    protected $userService;
    protected $adminInfoRepository;

    public function __construct(
        CinemaRepository $cinemaRepository,
        UserService $userService,
    ) {
        $this->cinemaRepository = $cinemaRepository;
        $this->userService = $userService;
    }

    public function getProvinceAllCinema()
    {
        $province =  $this->cinemaRepository->getProvinceAllCinema();
        return $province;
    }

    public function getCinemaByIdAdmin($admin_id)
    {
        return $this->cinemaRepository->getCinemaByIdAdmin($admin_id);
    }

    public function getCinemaByAdmin($admin_id)
    {
        return $this->cinemaRepository->getCinemaByAdmin($admin_id);
    }

    public function getCinemaById($id)
    {
        return $this->cinemaRepository->getCinemaById($id);
    }

    public function getMovieByCinema($id)
    {
        return $this->cinemaRepository->getMovieByCinema($id);
    }

    public function getAdminInfoId()
    {
        $admin_id = $this->getUserId('admin');
        return $this->adminInfoRepository->getIdAdminInfo($admin_id);
    }

    public function store($fill)
    {
        try {
            $admin = $this->userService->createAdmin($fill);

            $user = $this->cinemaRepository->createCinema($fill, $admin->id);
            // return $cinema;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getListCinema($request, $province_id)
    {
        $cinemas = $this->cinemaRepository->getListCinema($request, $province_id);

        return CinemaResource::collection($cinemas);
    }

    public function updateCinema($id, $fill)
    {
        return $this->cinemaRepository->updateById($id, [
            'name' => $fill['cinema_name'],
            'address' => $fill['address'],
        ]);
    }

    public function delete($id)
    {
        // Những rạp đã có phòng thì không thể xóa
        return $this->cinemaRepository->deleteById($id);
    }
}
