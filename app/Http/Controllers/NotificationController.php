<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getAllNotification(Request $request)
    {
        return $this->notificationService->getAllNoti($request);
    }

    public function markRead($id)
    {
        $this->notificationService->readNoti($id);
        return response()->noContent();
    }
}
