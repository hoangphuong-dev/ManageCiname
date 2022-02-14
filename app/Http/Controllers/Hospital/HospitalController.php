<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MasterDataService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HospitalController extends Controller
{
    protected $masterDataService;
    protected $profileService;

    public function __construct(MasterDataService $masterDataService, ProfileService $profileService)
    {
        $this->masterDataService = $masterDataService;
        $this->profileService = $profileService;
    }
    public function showProFile()
    {
        $hospital = $this->profileService->getProfileHospital()->resolve();
        $hospitalTypes = $this->masterDataService->listHospitalType();
        return Inertia::render(
            'Hospital/Profile',
            ['hospital' => $hospital, 'hospitalTypes' => $hospitalTypes],
        );
    }
}
