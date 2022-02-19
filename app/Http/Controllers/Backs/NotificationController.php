<?php

namespace App\Http\Controllers\Backs;

use App\Http\Controllers\Controller;
use App\Http\Requests\MakeNotificationRequest;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationService->getListNotificationAdmin($request);
        return Inertia::render('Backs/Notification/Index', [
            'notifications' => $notifications,
            'filtersBE' => $request->all()
        ]);
    }

    public function store(MakeNotificationRequest $request)
    {
        try {
            $fill = $request->validated();
            $this->notificationService->make($fill);
            $message = ['success' => __('create notification successful')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }

    public function delete($id)
    {
        try {
            $this->notificationService->delete($id);
            $message = ['success' => __('delete notification successful')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }

    public function update($id, MakeNotificationRequest $request)
    {
        try {
            $fill = $request->validated();
            $this->notificationService->update($id, $fill);
            $message = ['success' => __('update notification successful')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }
}
