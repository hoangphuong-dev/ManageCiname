<?php

namespace App\Services;

use App\Http\Resources\MovieGenreResource;
use App\Http\Resources\MovieResource;
use App\Repositories\AdminInfoRepository;
use App\Repositories\MovieGenreRepository;
use App\Repositories\MovieRepository;
use Illuminate\Support\Facades\DB;

class MovieService extends BaseService
{
    protected $movieRepository;
    protected $adminInfoRepository;

    public function __construct(MovieRepository $movieRepository, AdminInfoRepository $adminInfoRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->adminInfoRepository = $adminInfoRepository;
    }

    public function getProvinceShowMovie()
    {
        return $this->adminInfoRepository->getProvinceShowMovie();
    }


    public function list($request)
    {
        $movie = $this->movieRepository->list($request);
        return MovieResource::collection($movie);
    }

    public function store($request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $movie = $this->movieRepository->createMovie($data);

            // $


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
