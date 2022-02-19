<?php

namespace App\Http\Controllers\Backs;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobIdRequest;
use App\Services\HospitalService;
use App\Services\JobService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{
    private $hospitalService;
    private $jobService;

    public function __construct(HospitalService $hospitalService, JobService $jobService)
    {
        $this->hospitalService = $hospitalService;
        $this->jobService = $jobService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listHospital = $this->hospitalService->analytics($request);
        return Inertia::render('Backs/Job/Index', [
            'listHospital' => $listHospital,
            'filtersBE' => $request->all()
        ]);
    }

    public function hospitalListJob($hospitalId, Request $request)
    {
        $jobs = $this->hospitalService->listJobHospital($hospitalId, $request);
        return Inertia::render('Backs/Job/List', [
            'jobsData' => $jobs,
            'hospitalId' => $hospitalId,
            'filtersBE' => $request->all()
        ]);
    }

    public function hospitalDetailJob($hospitalId, $jobId)
    {
        list($isShowApprovalButton, $data) = $this->jobService->getAllRelated($jobId);
        return Inertia::render('Backs/Job/Detail', [
            'hospitalId' => $hospitalId,
            'isShowApprovalButton' => $isShowApprovalButton,
            'data' => $data,
        ]);
    }

    public function approvalJob(JobIdRequest $request)
    {
        try {
            $this->jobService->approvalJob($request->input('job_id'));
            $message = ['success' => __('approval job success')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }
}
