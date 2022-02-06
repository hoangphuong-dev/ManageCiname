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
        // dd($cinemas);
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
}
