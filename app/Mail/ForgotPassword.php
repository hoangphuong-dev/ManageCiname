<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class ForgotPassword extends Mailable implements ShouldQueue
{
    use Queueable;


    protected $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->onQueue(MAIL_QUEUE);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.mail-forgot-password')->with([
            'token' => $this->token
        ]);
    }
}
