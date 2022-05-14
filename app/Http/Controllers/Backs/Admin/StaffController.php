<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffInfo;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StaffController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return Inertia::render('Backs/Admin/Staff');
    }

    public function getAll(Request $request)
    {
        $staff = $this->userService->getStaffOfAdmin($request);
        return $staff;
    }

    public function updateStatus($id, Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
        ]);

        $aaaa = new StaffInfo();
        return $aaaa->updateStatus($id, $data['status']);
    }
}
