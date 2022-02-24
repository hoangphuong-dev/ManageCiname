<?php

namespace App\Services;

use App\Http\Resources\AdminInfoResource;
use App\Http\Resources\CinemaResource;
use App\Repositories\AdminInfoRepository;
use App\Repositories\CinemaRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class CinemaService extends BaseService
{
    protected $cinemaRepository;
    protected $adminInfoRepository;

    public function __construct(CinemaRepository $cinemaRepository, AdminInfoRepository $adminInfoRepository)
    {
        $this->cinemaRepository = $cinemaRepository;
        $this->adminInfoRepository = $adminInfoRepository;
    }

    public function getCinemaById($id)
    {
        return $this->cinemaRepository->getCinemaById($id);
    }

    public function getMovieByCinema($id)
    {
        return $this->cinemaRepository->getMovieByCinema($id);
        // dd($cinema);
        // return CinemaResource::collection($cinema);
    }

    public function getAdminInfoId()
    {
        $admin_id = $this->getUserId('admin');
        return $this->adminInfoRepository->getIdAdminInfo($admin_id);
    }

    public function store($fill)
    {
        try {
            $cinema = $this->cinemaRepository->createCinema($fill, $this->getAdminInfoId());
            return $cinema;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getListCinema($request)
    {
        $cinemas = $this->cinemaRepository->getListCinema($request, $this->getAdminInfoId());
        return CinemaResource::collection($cinemas);
    }

    public function update($id, $fill)
    {
        return $this->cinemaRepository->updateById($id, [
            'name' => $fill['name'],
            'hotline' => $fill['hotline'],
            'address' => $fill['address'],
        ]);
    }

    public function delete($id)
    {
        // Những rạp đã có phòng thì không thể xóa
        return $this->cinemaRepository->deleteById($id);
    }
}
