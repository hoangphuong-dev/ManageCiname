<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowTimeRequest;
use App\Services\ShowTimeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowTimeController extends Controller
{
    protected $showTimeService;

    public function __construct(ShowTimeService $showTimeService)
    {
        $this->showTimeService = $showTimeService;
    }

    public function index()
    {
        return Inertia::render('Backs/Admin/ShowTime');
    }

    public function store(ShowTimeRequest $request)
    {
        try {
            $this->showTimeService->store($request);
            $message = ['success' => __('Tạo lịch chiếu thành công !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }
}
