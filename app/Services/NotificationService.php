<?php

namespace App\Services;

/**
 * Class NotificationService
 * @package App\Services
 */
class NotificationService extends BaseService
{

    public function getAllNoti($request)
    {
        $notifications = auth()->guard($this->getGuard())->user()->notifications()->paginate(10);
        return $notifications;
    }

    public function readNoti($id)
    {
        return  auth()->guard($this->getGuard())->user()->unreadNotifications->where('id', $id)->markAsRead();
    }


    public function countNotificationUnread()
    {
        $user = auth()->guard($this->getGuard())->user();

        if (is_null($user)) {
            return 0;
        }

        $unreadNotifications = $user->unreadNotifications;

        return count($unreadNotifications);
    }
}
