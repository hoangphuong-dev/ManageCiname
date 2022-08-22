<?php

namespace App\Console\Commands;

use App\Helper\FormatDate;
use App\Models\Cinema;
use App\Notifications\SendAdminEndWeekNotification;
use App\Repositories\AdminAnalysisRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendNotiAdminEndWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:send_noti_end_week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for admin on end week';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = 0;
        $cinemas = Cinema::query()->with(['user'])->get();

        $startOfWeek = Carbon::now()->startOfWeek()->format("Y-m-d");
        $endOfWeek = Carbon::now()->endOfWeek()->format("Y-m-d");
        $labels =  FormatDate::getPeriodDate($startOfWeek, $endOfWeek);

        foreach ($cinemas as $cinema) {
            $movies = AdminAnalysisRepository::getMovieAnalysis($startOfWeek, $endOfWeek, $cinema->id, $labels);

            if (count($movies) > 0 && $movies[0]['percent'] > 0) {
                Notification::send($cinema->user, new SendAdminEndWeekNotification($movies[0]['name'], $startOfWeek, $endOfWeek));
                echo "=== [Sending notification cinema: {$cinema->name}] ===\n";
                $count++;
            }
        }

        echo "=== [Sent: {$count} notifications for {$count} cinema] ===\n";
    }
}
