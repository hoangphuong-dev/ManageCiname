<?php

namespace App\Http\Controllers\Caretaker;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobIdRequest;
use App\Models\Job;
use App\Models\Tag;
use App\Models\TagJob;
use App\Services\JobService;
use Inertia\Inertia;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public $tag_jobs;
    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }
    public function index()
    {
        $tags = $this->jobService->getTag();
        $hospital_types = $this->jobService->getHospitalType();

        return Inertia::render('Caretaker/Jobs/Index', [
            'tags' => $tags,
            'hospital_types' => $hospital_types,
        ]);
    }

    public function jobDetail($id)
    {
        $job = $this->jobService->show($id);
        $job_relateds = $this->jobService->getJobRelated($id);
        return Inertia::render('Caretaker/Jobs/JobDetail', [
            'job' => $job->resolve(),
            'job_relateds' => $job_relateds,
        ]);
    }

    public function stepJobDetail()
    {
        return Inertia::render('Caretaker/Jobs/StepJobDetail');
    }
    public function listStepJobDetail()
    {
        return Inertia::render('Caretaker/Jobs/ListStepJobDetail');
    }

    public function applyJob(JobIdRequest $request)
    {
        try {
            $jobId = $request->input('job_id');
            $this->jobService->applyJob($jobId);
            $message = ['success' => __('applied this job')];
        } catch (\Exception $e) {
            $message = ['error' => $e->getMessage()];
        } finally {
            return back()->with($message);
        }
    }

    public function showJobApply(Request $request)
    {
        $jobs = $this->jobService->getJobApply($request, 'apply');
        return inertia('Caretaker/Apply/Index', [
            'active' => 'first',
            'jobs' => $jobs,
            'filters' => $request->all(['page', 'search'])
        ]);
    }

    public function showJobApplied(Request $request){
        $jobs = $this->jobService->getJobApply($request, 'applied');
        return inertia('Caretaker/Apply/Index', [
            'active' => 'second',
            'jobs' => $jobs,
            'filters' => $request->all(['page', 'search'])
        ]);
    }

    public function showJobApplyDetail($jobId, $jobApplyId)
    {
        list($job, $jobApply) = $this->jobService->getJobDetailWithProcess($jobId, $jobApplyId);
        return Inertia::render('Caretaker/Apply/Detail', [
            'data' => $job,
            'jobApply' => $jobApply,
        ]);
    }
}
