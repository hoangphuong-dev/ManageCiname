<?php

namespace App\Services;

use App\Repositories\NotificationRepository;

/**
 * Class NotificationService
 * @package App\Services
 */
class NotificationService
{
    public function countNotificationUnread()
    {
        $unreadNotifications = auth()->guard('admin')->user()->unreadNotifications;

        return count($unreadNotifications);
    }
}
