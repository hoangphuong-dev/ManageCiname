<?php

namespace App\Http\Controllers\Api\Hospital;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobIdRequest;
use App\Services\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{

    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function getListJob(Request $request)
    {
        try {
            return $this->jobService->getListFromHospital($request);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
    public function getCaretakerApplyJob(JobIdRequest $request)
    {
        $jobId = $request->input('job_id');
        $job = $this->jobService->getListCaretakerApplyJob($jobId);
        return response()->json($job);
    }

    public function checkDeleteProcess($jobId, $jobPrrocessId)
    {
        $job = $this->jobService->checkDeleteProcess($jobId, $jobPrrocessId);
        return response()->json($job);
    }

    public function getListComment(Request $request, $jobId)
    {
        try {
            return $this->jobService->getListComment($request, $jobId);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateStatusComment(Request $request, $commentId)
    {
        try {
            $this->jobService->updateStatusComment($request, $commentId);
            return $this->sendSuccessResponse(true, 'Update status success');
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
