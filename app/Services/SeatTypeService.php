<?php

namespace App\Services;

use App\Helper\ImageHelper;
use App\Http\Resources\SeatTypeResource;
use App\Repositories\SeatTypeRepository;

class SeatTypeService extends BaseService
{
    protected $seatTypeRepository;

    public function __construct(SeatTypeRepository $seatTypeRepository)
    {
        $this->seatTypeRepository = $seatTypeRepository;
    }

    public function getAllSeatType()
    {
        return $this->seatTypeRepository->getAllSeatType();
    }

    public function list($request)
    {
        $seatType = $this->seatTypeRepository->list($request);
        return SeatTypeResource::collection($seatType);
    }

    public function edit($request, $id)
    {
        // dd($request->all());
        // return $this->seatTypeRepository->edit($request, $id);
    }

    public function store($fill)
    {
        if (isset($fill['image'])) {
            $fill['image'] = ImageHelper::upload($fill['image']);
        }
        return $this->seatTypeRepository->create($fill);
    }

    public function delete($id)
    {
        return $this->seatTypeRepository->deleteById($id);
    }
}