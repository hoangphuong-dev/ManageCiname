<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\User;
use App\Notifications\RevenuaCinemaByMonth;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotiRevenuaAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:notification_revenua {adminId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert notification of cinema when end month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $superAdmin = User::where('role', User::ROLE_SUPERADMIN)->first();
        $cinemas = $this->getCinemas();

        if (!is_null($superAdmin)) {
            foreach ($cinemas as $cinema) {
                $revenua = $this->getRevenuaCinema($cinema->id);
                Notification::send($superAdmin, new RevenuaCinemaByMonth($cinema, $revenua));
                echo "=== [Saving cinema revenua: {$cinema->name}] ===\n";
            }
        } else {
            dd('Have not account superadmin !');
        }
    }

    private function getCinemas()
    {
        $model = Cinema::query();

        if ($this->argument('adminId')) {
            $model = $model->where('user_id', $this->argument('adminId'));
        }
        return $model->get();
    }

    private function getRevenuaCinema($cinemaId)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $bills = Bill::query()
            ->where('cinema_id', $cinemaId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return $bills->sum('total_money');
    }
}
