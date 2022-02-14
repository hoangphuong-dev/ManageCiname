<?php

namespace App\Repositories;

use App\Models\Filters\NotificationFilter;
use App\Models\Notification;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class NotificationRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Notification::class;
    }

    public function make($fill)
    {
        return $this->create($fill);
    }

    public function getListNotificationAdmin($request)
    {
        return $this->model->newQuery()
        ->with('notificationManager', function($query) {
            $query->select(['type', 'notification_id', 'user_id'])
            ->with('user:name,id');
        })
        ->orderBy('created_at', 'desc')
        ->filters(new NotificationFilter($request))
        ->paginate($request->query('limit', 10));
    }
}
