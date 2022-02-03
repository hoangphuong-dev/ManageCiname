<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\AdminInfoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminInfoController extends Controller
{
    protected $adminInfoService;

    public function __construct(AdminInfoService $adminInfoService)
    {
        $this->adminInfoService = $adminInfoService;
    }

    public function index()
    {
        return Inertia::render("Backs/SuperAdmin/AdminInfo");
    }

    public function create()
    {
        $provinces = $this->adminInfoService->getProvince();
        return Inertia::render("Backs/SuperAdmin/FormAdminInfo", [
            'provinces' => $provinces,
        ]);
    }
}
