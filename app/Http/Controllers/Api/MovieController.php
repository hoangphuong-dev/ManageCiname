<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request)
    {
        $movies =  $this->movieService->list($request);
        return $movies;
    }

    public function changeStatus($id, Request $request)
    {
        return $this->movieService->updateStatus($id, $request);
    }


    public function store(MovieRequest $request)
    {
        $fill = $request->validated();
        try {
            $this->movieService->store($fill);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
