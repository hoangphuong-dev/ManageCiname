<?php

namespace App\Notifications;

use App\Models\StaffInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeStatusStaff extends Notification implements ShouldQueue
{
    use Queueable;

    public $staffInfo;
    public $password;

    public function __construct(StaffInfo $staffInfo, string $password = null)
    {
        $this->staffInfo = $staffInfo;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $title = '';
        $this->staffInfo->status == StaffInfo::STATUS_WORKING ? $title = 'đăng ký nhân viên thành công' : $title = 'nghỉ việc';

        return (new MailMessage)
            ->subject("Thông báo " . $title)
            ->markdown('mail.change-status-staff', [
                'password' => $this->password,
                'user' => $notifiable,
                'cinema' => $this->staffInfo->cinema,
            ]);
    }
}
