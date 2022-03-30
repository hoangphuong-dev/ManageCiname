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
        return $this->ticketRepository->createTicket($data, $bill_id);
    }

    public function getTicketByBill($id)
    {
        return $this->ticketRepository->getTicketByBill($id);
    }

    public function getSeatOrdered($showtime_id)
    {
        return $this->ticketRepository->getSeatOrdered($showtime_id);
    }
}
