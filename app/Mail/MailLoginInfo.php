<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class MailLoginInfo extends Mailable implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    protected $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->onQueue(MAIL_QUEUE);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.mail-login-info')->with([
            'user' => $this->user,
            'passwordRaw' => $this->password
        ]);
    }
}
