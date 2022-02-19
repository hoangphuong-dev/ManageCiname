<?php

namespace App\Services;

use App\Http\Resources\ShowTimeResource;
use App\Repositories\ShowTimeRepository;

class ShowTimeService extends BaseService
{
    protected $showTimeRepository;

    public function __construct(ShowTimeRepository $showTimeRepository)
    {
        $this->showTimeRepository = $showTimeRepository;
    }

    public function list($request)
    {
        $showtimes = $this->showTimeRepository->list($request);
        dd($showtimes);
        return ShowTimeResource::collection($showtimes);
    }
}
