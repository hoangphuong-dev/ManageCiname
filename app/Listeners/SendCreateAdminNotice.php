<?php

namespace App\Listeners;

use App\Mail\CreateAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCreateAdminNotice implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Send notification to this email
        Mail::to($event->email)
            ->send(new CreateAdmin($event->password, $event->url));
    }
}
