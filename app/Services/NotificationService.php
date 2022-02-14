<?php

namespace App\Services;

use App\Http\Resources\NotificationAdminResource;
use App\Models\Notification;
use App\Models\NotificationManage;
use App\Repositories\NotificationManagerRepository;
use App\Repositories\NotificationReadRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationService extends BaseService
{
    protected $userRepository;
    protected $notificationRepository;
    protected $notificationManagerRepository;
    protected $notificationReadRepository;

    public function __construct(
        NotificationRepository $notificationRepository,
        UserRepository $userRepository,
        NotificationManagerRepository $notificationManagerRepository,
        NotificationReadRepository $notificationReadRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->userRepository = $userRepository;
        $this->notificationManagerRepository = $notificationManagerRepository;
        $this->notificationReadRepository = $notificationReadRepository;
    }

    private function makeNotificationManager(Notification $notification, $isAllHospital, $isAllCaretaker, $receiver_ids)
    {
        $type = null;

        if ($isAllHospital) {
            $type = NotificationManage::TYPE_HOSPITAL;
        }

        if ($isAllCaretaker) {
            if ($type === NotificationManage::TYPE_HOSPITAL) {
                $type = NotificationManage::TYPE_ALL;
            } else {
                $type = NotificationManage::TYPE_CARETAKER;
            }
        }

        if (!is_null($type)) {
            clone ($notification)->notificationManager()->create([
                'type' => $type
            ]);
        }

        if ($type !== NotificationManage::TYPE_ALL) {
            $listUserId = array_map(function ($item) {
                return [
                    'user_id' => $item
                ];
            }, $receiver_ids);

            $notification->notificationManager()->createMany($listUserId);
        }
    }

    public function isDeliveryNotification($schedule)
    {
        if (is_null($schedule)) {
            return true;
        }
        $schedule = Carbon::parse($schedule);
        $now = Carbon::now();

        return $schedule->lessThanOrEqualTo($now);
    }

    public function make($fill)
    {
        try {
            DB::beginTransaction();

            $isAllHospital = $fill['isAllHospital'];
            $isAllCaretaker = $fill['isAllCaretaker'];
            $receiver_ids = $fill['receiver_ids'];

            $notification = $this->notificationRepository->make([
                'title' => $fill['title'],
                'content' => $fill['content'],
                'schedule' => $fill['schedule'],
                'status' => $this->isDeliveryNotification($fill['schedule'])
            ]);

            $this->makeNotificationManager($notification, $isAllHospital, $isAllCaretaker, $receiver_ids);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function getListNotificationAdmin($request)
    {
        $notifications = $this->notificationRepository->getListNotificationAdmin($request);
        return NotificationAdminResource::collection($notifications);
    }

    public function delete($id)
    {
        return $this->notificationRepository->deleteById($id);
    }

    public function update($id, $fill)
    {
        try {
            DB::beginTransaction();
            $this->notificationManagerRepository->deleteByNotificationId($id);

            $notification = $this->notificationRepository->updateById($id, [
                'title' => $fill['title'],
                'content' => $fill['content'],
                'schedule' => $fill['schedule'],
                'status' => $this->isDeliveryNotification($fill['schedule'])
            ]);

            $isAllHospital = $fill['isAllHospital'];
            $isAllCaretaker = $fill['isAllCaretaker'];
            $receiver_ids = $fill['receiver_ids'];

            $this->makeNotificationManager($notification, $isAllHospital, $isAllCaretaker, $receiver_ids);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function getListForUser($request)
    {
        $userId = $this->getUserId('caretaker');
        $type = NotificationManage::TYPE_CARETAKER;

        if (is_null($userId)) {
            $userId = $this->getUserId('hospital');
            $type = NotificationManage::TYPE_HOSPITAL;
        }


        return $this->notificationManagerRepository->getListForUser($userId, $type, $request);
    }

    public function markRead($id)
    {
        $userId = $this->getUserId('caretaker') ?? $this->getUserId('hospital');
        return $this->notificationReadRepository->create([
            'notification_id' => $id,
            'user_id' => $userId
        ]);
    }
}
