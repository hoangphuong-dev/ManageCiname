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

    public function createTicket($data, $bill_id, $user_id)
    {
        return $this->ticketRepository->createTicket($data, $bill_id, $user_id);
    }

    public function getTicketByBill($id)
    {
        return $this->ticketRepository->getTicketByBill($id);
    }

    public function getSeatOrdered($show_time_id)
    {
        return $this->ticketRepository->getSeatOrdered($show_time_id);
    }

    public function deleteMultipleById($arr)
    {
        $this->ticketRepository->deleteMultipleById($arr);
    }
}
