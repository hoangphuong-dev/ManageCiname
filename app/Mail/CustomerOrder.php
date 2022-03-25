<?php

namespace App\Mail;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerOrder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $bill;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Bill $bill, User $user)
    {
        $this->bill = $bill;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.customer-order')
            ->subject("[PHC] Đặt vé thành công")
            ->with([
                'bill' => $this->bill,
                'user' => $this->user,
                'check_password' => $this->checkPassword(),
            ]);
    }

    protected function checkPassword()
    {
        $flag = null;
        $password = $this->user->password;

        if ($password == null) {
            $password_new = Str::random(12);
            // cap nhat lai pass trong DB
            $this->user->password = Hash::make($password_new);
            $this->user->save();

            $flag = $password_new;
        }

        return $flag;
    }
}
