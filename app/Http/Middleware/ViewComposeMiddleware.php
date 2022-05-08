<?php

namespace App\Http\Middleware;

use App\Services\NotificationService;
use Closure;
use Illuminate\Http\Request;

class ViewComposeMiddleware
{
    private $notificationService;

    public function __construct()
    {
        $this->notificationService = app()->make(NotificationService::class);
    }

    public static function share()
    {
        return (new self)->compose();
    }

    public function compose()
    {
        $countNotificationUnread = $this->notificationService->countNotificationUnread();

        return [
            'unreadNotifications' => $countNotificationUnread,
        ];
    }
}
