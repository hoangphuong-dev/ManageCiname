<?php

namespace App\Http\Controllers\Api\Caretaker;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentJobRequest;
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

    public function comment(CommentJobRequest $request, $jobId)
    {
        try {
            $this->jobService->caretakerCommentJob($request, $jobId);
            return $this->sendSuccessResponse(true, 'Comment success');
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
