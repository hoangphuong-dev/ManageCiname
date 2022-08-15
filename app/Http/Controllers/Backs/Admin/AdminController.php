<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAnalysisService;
use Illuminate\Http\Request;
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

        // $request['date_from'] = substr($request->date_from, 0, -14);
        // $request['date_to'] = substr($request->date_to, 0, -14);
        // $request['date_from_ticket'] = substr($request->date_from_ticket, 0, -14);
        // $request['date_to_ticket'] = substr($request->date_to_ticket, 0, -14);

        // $data_avenua = $this->billService->getDataByMonth($request);
        // $data_ticket = $this->billService->getDataTicketByMonth($request);

        return Inertia::render('Backs/Admin/Index', [
            // 'data_avenua' => $data_avenua,
            // 'data_ticket' => $data_ticket,
        ]);
    }
}
