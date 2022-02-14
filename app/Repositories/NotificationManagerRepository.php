<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Models\NotificationManage;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class NotificationManagerRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return NotificationManage::class;
    }

    public function deleteByNotificationId($id)
    {
        return $this->model->newQuery()
        ->where('notification_id', $id)->delete();
    }

    public function getListForUser($userId, $type, $request)
    {
        return $this->model->newQuery()
        ->join('notifications', 'notifications.id', 'notification_manages.notification_id')
        ->selectRaw('
        notifications.id, title, notifications.created_at, content,
        (SELECT COUNT(*) FROM notification_reads WHERE user_id = ? AND notifications.id = notification_id) as isRead
        ', [$userId])
        ->where('notifications.status', Notification::DELIVERED_STATUS)
        ->where(function($query) use ($userId, $type){
            $query->where('user_id', $userId)
            ->orWhereIn('type', [$type, NotificationManage::TYPE_ALL]);
        })
        ->orderBy('notifications.created_at', 'desc')
        ->paginate($request->query('limit', 10));
    }
}
