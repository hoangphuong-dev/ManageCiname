<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{

    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        return Inertia::render("Backs/SuperAdmin/Movie");
    }

    public function create()
    {
        $adminInfo = $this->movieService->getProvinceShowMovie();
        return Inertia::render("Backs/SuperAdmin/FormMovie", [
            'adminInfo' => $adminInfo,
        ]);
    }
}
