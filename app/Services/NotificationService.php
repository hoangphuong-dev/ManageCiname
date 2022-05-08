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
        $user = auth()->guard('admin')->user();

        if (is_null($user)) {
            return 0;
        }

        $unreadNotifications = $user->unreadNotifications;

        return count($unreadNotifications);
    }
}
