<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CinemaRequest;
use App\Models\FormatMovie;
use App\Models\MovieFormatMovie;
use App\Models\ViewCinemaByProvince;
use App\Services\CinemaService;
use App\Services\MovieService;
use App\Services\RoomService;
use App\Services\SeatTypeService;
use App\Services\UserService;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CinemaController extends Controller
{
    protected $cinemaService;
    protected $seatTypeService;
    protected $movieService;
    protected $roomService;
    protected $userService;

    public function __construct(
        CinemaService $cinemaService,
        SeatTypeService $seatTypeService,
        MovieService $movieService,
        RoomService $roomService,
        UserService $userService,
    ) {
        $this->userService = $userService;
        $this->cinemaService = $cinemaService;
        $this->seatTypeService = $seatTypeService;
        $this->movieService = $movieService;
        $this->roomService = $roomService;
    }

    public function getMasterCinema(Request $request)
    {
        $master_cinemas = $this->cinemaService->getMasterCinema($request);
        return Inertia::render("Backs/SuperAdmin/MasterCinema", [
            'master_cinemas' => $master_cinemas,
            'filtersBE' => $request->all(),
        ]);
    }

    public function getListCinemaByProvince(Request $request)
    {
        $cinemas = $this->cinemaService->getListCinema($request, $request->province_id);
        return Inertia::render("Backs/SuperAdmin/CinemaByProvince", [
            'cinemas' => $cinemas,
            'filtersBE' => $request->all(),
            'province_id' => $request->province_id,
        ]);
    }

    public function store(CinemaRequest $request)
    {
        try {
            $fill = $request->validated();
            $this->cinemaService->store($fill);
            $message = ['success' => __('Tạo rạp thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi')];
        } finally {
            return back()->with($message);
        }
    }

    public function show($id)
    {
        $movie_formats = FormatMovie::all();
        $seat_types = $this->seatTypeService->getAllSeatType();
        $cinema = $this->cinemaService->getMovieByCinema($id);
        $rooms = $this->roomService->getRoomByCinema($id);
        return Inertia::render("Backs/Admin/CinemaDetail", [
            'cinema' => $cinema,
            'seat_types' => $seat_types,
            'rooms' => $rooms,
            'movie_formats' => $movie_formats,
        ]);
    }

    public function edit($id, Request $request)
    {
        $fillUser = $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        $fillCinema = $request->validate([
            'cinema_name' => 'required',
            'address' => 'required',
        ]);
        $user_id = $request->user_id;
        try {
            $this->cinemaService->updateCinema($id, $fillCinema);
            $this->userService->updateUserById($fillUser, $user_id);
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
