<?php

namespace App\Providers;

use App\Events\CreateAdmin;
use App\Events\CustomerOrder;
use App\Listeners\SendCreateAdminNotice;
use App\Listeners\SendOrderCustomerNotice;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreateAdmin::class => [
            SendCreateAdminNotice::class,
        ],
        CustomerOrder::class => [
            SendOrderCustomerNotice::class,
        ],

    ];
}
