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

    public function update($id, $fill)
    {
        $seatType = $this->seatTypeRepository->getById($id);
        $oldImage = null;

        if (isset($fill['image']) && gettype($fill['image']) == 'object') {
            $fill['image'] = ImageHelper::upload($fill['image']);
            $oldImage = $seatType->image;
        } else {
            $fill['image'] = $seatType->image;
        }

        if ($oldImage) {
            ImageHelper::deleteImage($oldImage);
        }

        $this->seatTypeRepository->updateById($id, $fill);
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
        $seatType = $this->seatTypeRepository->getById($id);
        ImageHelper::deleteImage($seatType->image);
        return $this->seatTypeRepository->deleteById($id);
    }
}