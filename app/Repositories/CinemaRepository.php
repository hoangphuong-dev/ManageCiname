<?php

namespace App\Repositories;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Province;
use App\Models\Room;
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

    public function getProvinceHasCinema()
    {
        return $this->model->distinct('province_id')->pluck('province_id')->all();
    }

    public function getProvinceAllCinema()
    {
        return Province::query()
            ->whereIn('id', $this->getProvinceHasCinema())
            ->withCount('cinemas')->get();
    }

    public function getCinemaByIdAdmin($admin_id)
    {
        return $this->model->newQuery()
            ->with(["bills" => function ($q) {
                $q->with(['user', 'voucher']);
            }])
            ->where('user_id', $admin_id)
            ->first();
    }

    public function listCinemaByProvince($id)
    {
        return $this->model
            ->select('id', 'name', 'address')
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

    // public function cinemaRepository($cinema_id)
    // {
    //     $cinema = $this->model
    //         ->with('user')
    //         ->where('id', $cinema_id)->first();

    //     return $cinema->user;
    // }

    public function getMovieByCinema($id)
    {
        return $this->model
            ->with(['user'])
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

    public function getListCinema($request, $province_id)
    {
        return $this->model->newQuery()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->withCount(['rooms' => function ($query) {
                $query->where('status', Room::STATUS_OPEN);
            }])
            ->with([
                'user',

            ])
            ->orderBy('created_at', 'desc')
            ->where('province_id', $province_id)
            ->paginate($request->query('limit', 12));
    }

    public function getAllArrayIdCinema()
    {
        $cinema = $this->model->query()
            ->select('id')
            ->get()
            ->toArray();
        return $cinema;
    }
}
