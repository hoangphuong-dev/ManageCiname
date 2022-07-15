<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RevenuaCinemaByMonth extends Notification implements ShouldQueue
{
    use Queueable;

    public $cinema;
    public $revenua;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($cinema, string $revenua)
    {
        $this->cinema = $cinema;
        $this->revenua = $revenua;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Thông báo doanh thu của rạp theo tháng',
            'cinema_id' => $this->cinema->id,
            'cinema_name' => $this->cinema->name,
            'revenua' => $this->revenua,
            'month' => Carbon::now()->format('m-Y'),
        ];
    }
}
