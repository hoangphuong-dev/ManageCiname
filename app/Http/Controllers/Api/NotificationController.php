<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\User;
use App\Notifications\AdminNotification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $receivers = User::whereIn('id', [1, 2])->get();
        // $data_notice = [
        //     'title' => 'title',
        //     'content' =>  'contentcontentcontent',
        // ];

        // foreach ($receivers as $receiver) {
        //     Notification::send($receiver, new AdminNotification($data_notice));
        // }
        $user = User::find(1);

        foreach ($user->notifications as $notification) {
            $notification->markAsRead();
            dd($notification->data);
        }

        dd($user->notifications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        dd($request->all());
        $this->notificationService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listReceiver(Request $request)
    {
        return $this->notificationService->listReceiver($request);
    }

    public function getListForUser(Request $request)
    {
        return $this->notificationService->getListForUser($request);
    }

    public function markRead($id)
    {
        return $this->notificationService->markRead($id);
    }
}
