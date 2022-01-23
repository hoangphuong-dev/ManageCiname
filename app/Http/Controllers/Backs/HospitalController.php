<?php

namespace App\Http\Controllers\Backs;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendLoginInfoRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\UserService;

class HospitalController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Backs/Hospital/Index');
    }

    public function sendLoginInfo(SendLoginInfoRequest $request) {
        $message = [];
        try {
            $userHospitalId = $request->input('id');
            $this->userService->sendLoginInfo($userHospitalId);

            $message = ['success' => __('Đã gửi thông tin đăng nhập đến bệnh viện thành công')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình gửi thông tin đăng nhập đến bệnh viện')];
        } finally {
            return back()->with($message);
        }
    }
}
