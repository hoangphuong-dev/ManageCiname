<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendAdminEndWeekNotification extends Notification
{
    use Queueable;

    public $movie;
    public $start;
    public $end;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $movie, string $start, string $end)
    {
        $this->movie = $movie;
        $this->start = Carbon::parse($start)->format("d-m");
        $this->end = Carbon::parse($end)->format("d-m");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Thông báo phim nổi bật trong tuần")
            ->markdown('mail.movie-hot-end-week', [
                'movie' => $this->movie,
                'start' => $this->start,
                'end' => $this->end,
            ]);
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
            'title' => 'Thông báo phim nổi bật trong tuần',
            'name' => $this->movie,
            'content' => 'Phim '
                . $this->movie . ' có tỉ lệ vé bán ra cao <br> nhất trong tuần  ('
                . $this->start . ' - '
                . $this->end . ')',
        ];
    }
}
