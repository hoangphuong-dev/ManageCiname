<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Services\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable $e
     */
    public function index(Request $request)
    {
        try {
            return $this->jobService->list($request);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable $e
     */
    public function store(JobRequest $request)
    {
        try {
            $this->jobService->store($request);
            return $this->sendSuccessResponse(true, __('Create job success'));
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable $e
     */
    public function show($id)
    {
        try {
            return $this->jobService->show($id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable $e
     */
    public function update(UpdateJobRequest $request, $id)
    {
        try {
            $this->jobService->update($request, $id);
            return $this->sendSuccessResponse(true, __('Update job success'));
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Throwable $e
     */
    public function destroy($id)
    {
        try {
            return $this->jobService->delete($id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
