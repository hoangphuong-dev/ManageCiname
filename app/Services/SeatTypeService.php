<?php

namespace App\Services;

use App\Helper\ImageHelper;
use App\Http\Resources\SeatTypeResource;
use App\Repositories\SeatTypeRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        return $this->seatTypeRepository->edit($request, $id);
    }

    public function store($request)
    {

        $data = $request->validated();
        if (isset($data['image'])) {

            // $file = $request->file('image');

            // $str = Str::random(10);
            // // // Save image to temporary directory
            // $data['image'] = $request->file('image')->storeAs('public/uploads', "{$str}.{$file->extension()}");

            // $path = Storage::url($data['image'], now()->addMinutes(15));

            // $image = ImageHelper::upload($data['image']);
            // $data['image'] = $path;






            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $data['image'] = $filename;
        }

        return $this->seatTypeRepository->make($data);
    }
}
