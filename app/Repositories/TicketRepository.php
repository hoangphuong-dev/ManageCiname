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
        $memmber = MemberCard::where('user_id', $user_id)->first();
        $point  = $memmber->accumulating_point;
        foreach ($data['seat_id'] as $item) {
            $this->newQuery()->create([
                'bill_id' => $bill_id,
                'showtime_id' => $data['showtime_id'],
                'seat_id' => $item,
            ]);
            $point += 3000;
        }
        $memmber->update([
            'accumulating_point' => $point
        ]);
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

    public function getSeatOrdered($showtime_id)
    {
        return $this->model->newQuery()
            ->where('showtime_id', $showtime_id)
            ->pluck('seat_id')->toArray();
    }
}
