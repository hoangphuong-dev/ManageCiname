<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieGenreRequest;
use App\Services\MovieGenreService;
use Illuminate\Http\Request;

class MovieGenreController extends Controller
{
    protected $movieGenreService;

    public function __construct(MovieGenreService $movieGenreService)
    {
        $this->movieGenreService = $movieGenreService;
    }
    public function index(Request $request)
    {
        return $this->movieGenreService->list($request);
    }

    public function store(MovieGenreRequest $request)
    {
        $fill = $request->validated();
        try {
            $this->movieGenreService->store($fill);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        //
    }
}
