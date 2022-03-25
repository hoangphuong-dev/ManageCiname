<?php

namespace App\Repositories;

use App\Models\Ticket;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class TicketRepository.
 */
class TicketRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Ticket::class;
    }

    public function createTicket($data, $bill_id)
    {
        foreach ($data['seat_id'] as $item) {
            $this->newQuery()->create([
                'bill_id' => $bill_id,
                'showtime_id' => $data['showtime_id'],
                'seat_id' => $item,
            ]);
        }
    }

    public function getTicketByBill($id)
    {
        return $this->newQuery()
            ->with([
                'seat' => function ($query) {
                    $query->with('seat_type');
                },
                'bill' => function ($query) {
                    $query->with('user');
                },
                'showtime' => function ($query) {
                    $query->with(['room', 'movie']);
                },
            ])
            ->where('bill_id', $id)
            ->get();
    }

    public function getTicketByCinema()
    {
        return $this->newQuery()
            ->get();
    }
}
