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

    public function store($request)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $image = ImageHelper::upload($data['image']);
            $data['image'] = $image;
        }
        return $this->seatTypeRepository->make($data);
    }
}
