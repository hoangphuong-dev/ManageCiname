<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public $adminAnalysisService;

    public function __construct(AdminAnalysisService $adminAnalysisService)
    {
        $this->adminAnalysisService = $adminAnalysisService;
    }

    public function index(Request $request)
    {
        $revenuaCinema = $this->adminAnalysisService->getDataAnalysis($request);

        $movieAnalysis = $this->adminAnalysisService->getMovieAnalysis($request);

        return Inertia::render('Backs/Admin/Index', [
            'revenuaCinema' => $revenuaCinema,
            'filtersBE' => $request->all(),
            'movieAnalysis' => $movieAnalysis,
        ]);
    }

    public function profile()
    {
        return Inertia::render('Backs/Profile', [
            'user' => Auth::guard('admin')->user(),
        ]);
    }
}
