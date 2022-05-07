<?php

namespace App\Listeners;

use App\Notifications\RegisterStaff;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendCreateStaffNotice implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Notification::send($event->admin, new RegisterStaff($event->user));
    }
}
