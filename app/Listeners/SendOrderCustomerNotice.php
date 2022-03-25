<?php

namespace App\Listeners;

use App\Mail\CustomerOrder;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;

class SendOrderCustomerNotice implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Send notification to email customer 
        Mail::to($event->user->email)
            ->send(new CustomerOrder($event->bill, $event->user));
    }
}
