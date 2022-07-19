<?php

namespace App\Repositories;

use App\Models\MemberCard;
use App\Models\Membership;
use App\Models\Ticket;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use PhpOffice\PhpSpreadsheet\Collection\Memory;

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

    public function createTicket($data, $bill_id, $user_id)
    {
        $arrTicket = [];
        $memmber = MemberCard::where('user_id', $user_id)->first();
        $point  = $memmber->accumulating_point;
        foreach ($data['seat_id'] as $item) {
            $ticket = $this->model->updateOrCreate([
                'bill_id' => $bill_id,
                'show_time_id' => $data['show_time_id'],
                'seat_id' => $item,
            ]);
            $point += 3000;
            array_push($arrTicket, $ticket->id);
        }
        $memmber->update([
            'accumulating_point' => $point
        ]);
        return $arrTicket;
    }

    public function getTicketByBill($id)
    {
        return $this->model->newQuery()
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

    public function getSeatOrdered($show_time_id)
    {
        return $this->model->newQuery()
            ->where('show_time_id', $show_time_id)
            ->pluck('seat_id')->toArray();
    }
}
