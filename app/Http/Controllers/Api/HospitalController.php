<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalInfoRequest;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    protected $userService;
    protected $profileService;

    public function __construct(UserService $userService, ProfileService $profileService)
    {
        $this->userService = $userService;
        $this->profileService = $profileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->userService->hospitalList($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id, Request $request)
    {
        try {
            $this->userService->updateStatusHospital($id, $request);
            return $this->sendSuccessResponse(true, __('Update success'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse(__('Update error'), $e->getMessage());
        }
    }

    public function updateProfile(HospitalInfoRequest $request)
    {
        try {
            $this->profileService->updateProfileHospital($request);
            return $this->sendSuccessResponse(true, __('Update success'));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
