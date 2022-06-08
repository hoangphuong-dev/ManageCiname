<?php

namespace App\Services;

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

    public function store($request)
    {

        $data = $request->validated();
        if (isset($data['image'])) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['image'] = $filename;
        }

        return $this->seatTypeRepository->make($data);
    }

    public function delete($id)
    {
        return $this->seatTypeRepository->deleteById($id);
    }
}