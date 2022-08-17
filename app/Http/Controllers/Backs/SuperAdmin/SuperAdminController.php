<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\SuperAdminAnalysisService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SuperAdminController extends Controller
{
    protected $superAdminAnalysisService;

    public function __construct(SuperAdminAnalysisService $superAdminAnalysisService)
    {
        $this->superAdminAnalysisService = $superAdminAnalysisService;
    }


    public function index(Request $request)
    {
        $revenuaProvince = $this->superAdminAnalysisService->getDataAnalysis($request);
        $listProvince = $this->superAdminAnalysisService->getListProvince();
        $revenuaProvinceDetail = $this->superAdminAnalysisService->getDataAnalysisDetail($request);

        return Inertia::render('Backs/SuperAdmin/Index', [
            'filtersBE' => $request->all(),
            'listProvince' => $listProvince,
            'revenuaProvince' => $revenuaProvince,
            'revenuaProvinceDetail' => $revenuaProvinceDetail,
        ]);
    }

    public function profile()
    {
        return Inertia::render('Backs/Profile', [
            'user' => Auth::guard('superadmin')->user(),
        ]);
    }
}
