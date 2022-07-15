<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private $baseService;

    public function __construct(BaseService $baseService)
    {
        $this->baseService = $baseService;
    }

    public function getAllNotification(Request $request)
    {
        $guard = $this->baseService->getGuard();

        $notifications = auth()->guard($guard)->user()->notifications()->paginate(10);

        return $notifications;
    }

    public function markRead($id)
    {
        auth()->guard($this->guard)->user()->unreadNotifications->where('id', $id)->markAsRead();
        return response()->noContent();
    }
}
