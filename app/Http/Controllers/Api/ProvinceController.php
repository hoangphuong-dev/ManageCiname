<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    private $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function getProvinceHasCinema()
    {
        $provinces = $this->provinceRepository->getProvinceHasCinema();

        return response()->json($provinces);
    }
}
