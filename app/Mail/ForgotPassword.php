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

    public function renderURL()
    {
        return URL::temporarySignedRoute('confirm-forgot-password', now()->addMinutes(1));
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
