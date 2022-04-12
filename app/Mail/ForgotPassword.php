<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ForgotPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $id;


    public function __construct(string $user_id)
    {
        $this->id = $user_id;
    }

    public function renderURL()
    {
        return URL::temporarySignedRoute('confirm_forgot_password', now()->addMinutes(5), ['id' => $this->id]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("[PHC] Chăm sóc khách hàng")
            ->with(['url' => $this->renderURL()])
            ->markdown('mail.forgot-password');
    }
}
