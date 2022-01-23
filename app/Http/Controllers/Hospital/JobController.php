<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaretakerProcessRequest;
use App\Http\Resources\JobResource;
use App\Services\JobService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{
    protected $jobRepository;
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Hospital/Index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('Hospital/CreateJob');
    }

    public function create()
    {
        return Inertia::render('Hospital/CreateJob');
    }

    public function edit($id)
    {
        $job = $this->jobService->show($id);

        return Inertia::render(
            'Hospital/EditJob',
            ['job' => JobResource::make($job)->resolve()]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        return Inertia::render('Hospital/ManageJob');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function caretakerDetail($jobId, $userId, $viewType)
    {
        try {
            list($job, $user) = $this->jobService->reviewingUserJob($jobId, $userId, $viewType);
            return Inertia::render('Hospital/CareTakerApply', [
                'job' => $job,
                'caretaker' => $user
            ]);
        } catch (\Exception $e) {
            abort(400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function review()
    {
        return Inertia::render('Hospital/Review');
    }

    public function caretakerProcess(CaretakerProcessRequest $request)
    {
        try {
            $fill = $request->validated();
            $viewType = $this->jobService->caretakerJobProcess($fill);
            $route = route('hospital.jobs.caretaker-detail', [
                'job_id' => $fill['job_id'],
                'caretaker_id' => $fill['caretaker_id'],
                'type' => $viewType
            ]);
            $message = ['success' => $viewType === 'reject' ? __('rejected this step') : __('accepted this step')];
            return redirect($route)->with($message);
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
            return back()->with($message);
        }
    }
}
