<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\SuperAdminAnalysisService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $revenuaProvinceDetail = $this->superAdminAnalysisService->getDataAnalysisDetail($request);
        $listProvince = $this->superAdminAnalysisService->getListProvince();

        return Inertia::render('Backs/SuperAdmin/Index', [
            'filtersBE' => $request->all(),
            'revenuaProvince' => $revenuaProvince,
            'listProvince' => $listProvince,
        ]);
    }
}
