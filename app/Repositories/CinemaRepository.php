<?php

namespace App\Repositories;

use App\Models\AdminInfo;
use App\Models\Cinema;
use App\Models\Movie;
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
            }])
            ->where('id', $id)
            ->firstOrFail();
    }

    public function createCinema($fill, $admin_info_id)
    {
        return $this->create([
            'admin_info_id' => $admin_info_id,
            'name' => $fill['name'],
            'hotline' => $fill['hotline'],
            'address' => $fill['address'],
        ]);
    }

    public function getListCinema($request, $province_id)
    {
        return $this->model->newQuery()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->orderBy('created_at', 'desc')
            ->where('province_id', $province_id)
            ->paginate($request->query('limit', 10));
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
