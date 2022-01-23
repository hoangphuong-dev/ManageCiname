<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
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
        try {
            return $this->userService->listCareTaker($request);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateStatus($id, Request $request)
    {
        try {
            return $this->userService->updateStatusCaretaker($id, $request);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateProfile(UserInfoRequest $request)
    {
        try {
            return $this->profileService->updateProfileCaretaker($request);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
