<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ViewCinemaByProvince;
use App\Services\AdminInfoService;
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
       
    }

    public function create()
    {
        $provinces = $this->adminInfoService->getProvince();
        return Inertia::render("Backs/SuperAdmin/FormAdminInfo", [
            'provinces' => $provinces,
        ]);
    }
}
