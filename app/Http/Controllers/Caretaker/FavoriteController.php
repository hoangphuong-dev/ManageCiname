<?php

namespace App\Http\Controllers\Caretaker;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnFavoriteRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\JobService;

class FavoriteController extends Controller
{

    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index(Request $request)
    {
        $jobs = $this->jobService->getListJobFavorite($request);

        return inertia('Caretaker/Favorite/Index', [
            'jobs' => $jobs,
            'filters' => $request->all(['page', 'search'])
        ]);
    }

    public function toggleFavorite(UnFavoriteRequest $request)
    {
        try {
            $fill = $request->validated();
            $this->jobService->toggleFavorite($fill);
            return back();
        } catch (\Exception $e) {
            return back()->with(['error' => __('something went wrong')]);
        }
    }
}
