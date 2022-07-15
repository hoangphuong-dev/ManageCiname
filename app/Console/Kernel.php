<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Thống kê doanh thu của từng rạp gửi về cho superadmin 1 tháng 1 lần
        $schedule->command('admin:notification_revenua')
            ->monthlyOn(1, '00:00')
            ->timezone('Asia/Ho_Chi_Minh')
            ->withoutOverlapping()
            ->runInBackground();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
