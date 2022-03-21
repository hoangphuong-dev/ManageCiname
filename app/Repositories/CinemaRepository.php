<?php

namespace App\Repositories;

use App\Models\AdminInfo;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\ViewCinemaByProvince;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class CinemaRepository.
 */
class CinemaRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Cinema::class;
    }

    public function listCinemaByProvince($id)
    {
        return $this->model
            ->select('id', 'name')
            ->where('province_id', $id)->get()->toArray();
    }

    public function getCinemaByAdmin($admin_id)
    {
        return $this->model->where('user_id', $admin_id)->firstOrFail()->toArray();
    }

    public function getCinemaById($id)
    {
        return $this->model->where('id', $id)->firstOrFail()->toArray();
    }

    public function getMovieByCinema($id)
    {
        return $this->model
            ->newQuery()
            ->with(["movies" => function ($q) {
                $q->where('status', Movie::MOVIE_ACTIVE);
            }, 'user'])
            ->where('id', $id)
            ->firstOrFail();
    }

    public function createCinema($fill, $admin_id)
    {
        return $this->create([
            'user_id' => $admin_id,
            'province_id' => $fill['province_id'],
            'name' => $fill['name'],
            'address' => $fill['address'],
        ]);
    }

    public function getMasterCinema($request)
    {
        return ViewCinemaByProvince::when($request->name, function ($query) use ($request) {
            return $query->where("name", "like", "%{$request->name}%");
        })
            ->paginate($request->query('limit', 12));
    }

    public function getListCinema($request, $province_id)
    {
        return $this->model->newQuery()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->where('province_id', $province_id)
            ->paginate($request->query('limit', 12));
    }

    public function getArrayIdCinemaByAdminInfo($arrayAdminInfo)
    {
        $id_adminInfo = array();
        foreach ($arrayAdminInfo as $item) {
            $id_adminInfo[] = $item['id'];
        }
        $cinema = $this->model->query()
            ->select('id')
            ->whereIn('admin_info_id', $id_adminInfo)
            ->get()
            ->toArray();
        return $cinema;
    }

    public function getAllCinemaByAdmin($admin_id)
    {
        $admin_info = AdminInfo::where('user_id', $admin_id)->firstOrFail();
        $cinema = $this->model->select('id')->where('admin_info_id', $admin_info->id)->get()->toArray();

        $arr_cinema_id = array();
        foreach ($cinema as $item) {
            $arr_cinema_id[] = $item['id'];
        }
        return $arr_cinema_id;
    }
}
