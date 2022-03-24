<?php

namespace App\Services;

use App\Repositories\TicketRepository;

class TicketService
{
    public $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function createTicket($data, $bill_id)
    {
        // try catch o day nua nhe 
        return $this->ticketRepository->createTicket($data, $bill_id);
    }
}
