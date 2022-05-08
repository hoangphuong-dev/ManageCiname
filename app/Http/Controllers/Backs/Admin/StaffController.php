<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
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
}
