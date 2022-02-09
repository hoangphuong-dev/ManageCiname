<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CinemaRequest;
use App\Services\CinemaService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CinemaController extends Controller
{
    protected $cinemaService;

    public function __construct(CinemaService $cinemaService)
    {
        $this->cinemaService = $cinemaService;
    }

    public function index(Request $request)
    {
        $cinemas = $this->cinemaService->getListCinema($request);
        return Inertia::render("Backs/Admin/Cinema", [
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
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }

    public function show($id)
    {
        return Inertia::render("Backs/Admin/CinemaDetail", [
            'cinemas' => 1,
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
            $message = ['error' => __('something went wrong')];
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
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }
}
