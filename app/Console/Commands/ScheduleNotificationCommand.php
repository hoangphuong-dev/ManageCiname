<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class ScheduleNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delivered Notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::alert("zooooooooooooooooo");
        $notifications = Notification::where('status', false)->get();

        $notifications->each(function ($notification) {
            $notification->status = $this->notificationService->isDeliveryNotification($notification->schedule);
            $notification->save();
        });
        return Command::SUCCESS;
    }
}
