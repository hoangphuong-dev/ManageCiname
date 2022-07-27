<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffInfo;
use App\Services\StaffInfoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StaffController extends Controller
{
    public $userService;
    protected $staffInfoService;

    public function __construct(UserService $userService,  StaffInfoService $staffInfoService)
    {
        $this->userService = $userService;
        $this->staffInfoService = $staffInfoService;
    }

    public function index(Request $request)
    {
        $staff = $this->userService->getStaffOfAdmin($request);
        return Inertia::render('Backs/Admin/Staff', [
            'blogs' => $staff,
            'filtersBE' => $request->all(),
        ]);
    }
    public function updateStatus($id, Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
        ]);

        try {
            $this->staffInfoService->updateStatus($id, $data);
            $message = ['success' => 'Cập nhật trạng thái thành công'];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }

    public function delete($id)
    {
        try {
            $this->staffInfoService->delete($id);
            $message = ['success' => 'Xóa thành công'];
        } catch (\Exception $e) {
            $message = ['error' => __('something went wrong')];
        } finally {
            return back()->with($message);
        }
    }
}
