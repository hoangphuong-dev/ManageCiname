<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateAdmin extends Mailable
{
    use Queueable, SerializesModels;



    public $password;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $password, String $url)
    {
        $this->password = $password;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.create-admin')
            ->subject("[PHC] Thông báo tạo tài khoản")
            ->with([
                'password' => $this->password,
                'url' => $this->url
            ]);
    }
}
