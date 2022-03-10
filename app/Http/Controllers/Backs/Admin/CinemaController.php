<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CinemaRequest;
use App\Services\CinemaService;
use App\Services\MovieService;
use App\Services\RoomService;
use App\Services\SeatTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CinemaController extends Controller
{
    protected $cinemaService;
    protected $seatTypeService;
    protected $movieService;
    protected $roomService;

    public function __construct(
        CinemaService $cinemaService,
        SeatTypeService $seatTypeService,
        MovieService $movieService,
        RoomService $roomService
    ) {
        $this->cinemaService = $cinemaService;
        $this->seatTypeService = $seatTypeService;
        $this->movieService = $movieService;
        $this->roomService = $roomService;
    }

    public function index(Request $request, $province_id)
    {
        $cinemas = $this->cinemaService->getListCinema($request, $province_id);
        return Inertia::render("Backs/SuperAdmin/Cinema", [
            'cinemas' => $cinemas,
            'filtersBE' => $request->all(),
        ]);
    }

    public function store(CinemaRequest $request)
    {
        try {
            $fill = $request->validated();
            $this->cinemaService->store($fill);
            $message = ['success' => __('Tạo rạp thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }

    public function show($id)
    {
        $seat_types = $this->seatTypeService->getAllSeatType();
        $cinema = $this->cinemaService->getMovieByCinema($id);
        $rooms = $this->roomService->getRoomByCinema($id);
        return Inertia::render("Backs/Admin/CinemaDetail", [
            'cinema' => $cinema,
            'seat_types' => $seat_types,
            'rooms' => $rooms,
        ]);
    }

    public function edit($id, CinemaRequest $request)
    {
        // Không được sửa rạp của Admin khác
        try {
            $fill = $request->validated();
            $this->cinemaService->update($id, $fill);
            $message = ['success' => __('Cập nhật thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }

    public function delete($id)
    {
        try {
            $this->cinemaService->delete($id);
            $message = ['success' => __('Xóa thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }
}
