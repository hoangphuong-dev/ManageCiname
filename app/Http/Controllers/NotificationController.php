<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getAllNotification(Request $request)
    {
        $notification = auth()->guard('admin')->user()->notifications()->paginate(10);

        return $notification;
    }

    public function markRead($id)
    {
        auth()->guard('admin')->user()->unreadNotifications->where('id', $id)->markAsRead();

        return response()->noContent();
    }
}
