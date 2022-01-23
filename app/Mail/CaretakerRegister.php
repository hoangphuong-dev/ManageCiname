<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class CaretakerRegister extends Mailable implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $token_life_time;

    public function __construct($token_life_time)
    {
        $this->token_life_time = $token_life_time;
        $this->onQueue(MAIL_QUEUE);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.mail-caretaker-register')->with([
            'token_life_time' => $this->token_life_time
        ]);
    }
}
