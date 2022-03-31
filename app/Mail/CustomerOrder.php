<?php

namespace App\Mail;

use PDF;
use App\Models\Bill;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
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
        // $tickets = Ticket::with([
        //     'seat' => function ($query) {
        //         $query->with('seat_type');
        //     },
        //     'bill' => function ($query) {
        //         $query->with('user');
        //     },
        //     'showtime' => function ($query) {
        //         $query->with(['room', 'movie']);
        //     },
        // ])
        //     ->where('bill_id', $this->bill->id)
        //     ->get();

        // $pdf = PDF::loadView('user.view_ticket_pdf', [
        //     'tickets' => $tickets,
        // ]);

        // return $this->subject("[PHC] Đặt vé thành công")
        //     ->text('mail.customer-order', [])->attachData($pdf->output(), "ticket.pdf");

        return $this
            ->subject("[PHC] Đặt vé thành công")
            ->text('mail.customer-order', [
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
