<?php

namespace App\Repositories;

use App\Models\SeatType;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class SeatTypeRepository.
 */
class SeatTypeRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return SeatType::class;
    }

    public function make($data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'image' => $data['image'],
        ]);
    }

    public function getAllSeatType()
    {
        return $this->model->select(['id', 'name'])->get()->toArray();
    }

    public function list($request)
    {
        return $this->model->query()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->orderBy('id', "DESC")
            ->paginate($request->query('limit', 10));
    }
}
