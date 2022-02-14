<?php

namespace App\Http\Controllers\Api\Back;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;    
    }


    public function getListReceiver(Request $request)
    {
        $receivers = $this->userService->getNotificationReceiver($request);
        return response()->json([
            'data' => $receivers,
            'status' => 200
        ]);
    }
}
