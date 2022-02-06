<?php

namespace App\Repositories;

use App\Models\Cinema;
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

    public function createCinema($fill, $admin_info_id)
    {
        return $this->create([
            'admin_info_id' => $admin_info_id,
            'name' => $fill['name'],
            'hotline' => $fill['hotline'],
            'address' => $fill['address'],
        ]);
    }
    public function getListCinema($request, $admin_info_id)
    {
        return $this->model->newQuery()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->orderBy('created_at', 'desc')
            ->where('admin_info_id', $admin_info_id)
            ->paginate($request->query('limit', 10));
    }
}
