<?php

namespace App\Http\Controllers\Caretaker;

use App\Http\Controllers\Controller;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CVController extends Controller
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caretaker = $this->profileRepository->profileCareTaker();

        return Inertia::render(
            'Caretaker/Profile/Index',
            ['caretaker' => $caretaker->resolve()]
        );
    }
}
