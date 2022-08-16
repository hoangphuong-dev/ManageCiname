<?php

namespace App\Repositories;

use App\Models\Bill;
use Carbon\Carbon;

class AdminAnalysisRepository
{
    public function analysisByCinema($request, $labels, $cinemaId)
    {
        $arrRenua = $arrTicket = [];
        $monthFormat = Carbon::parse($request->selected_month)->format('Y-m');

        $revenuas = Bill::query()
            ->selectRaw('DATE_FORMAT(bills.created_at, "%d-%m-%Y") as day, count(tickets.id) as "number_ticker", sum(bills.total_money) as "revenua"')
            ->join('tickets', 'tickets.bill_id', '=', 'bills.id')
            ->where('bills.created_at', 'LIKE', "{$monthFormat}%")
            ->where('status', BiLL::PAYMENTED)
            ->where('cinema_id', $cinemaId)
            ->groupBy('day')
            ->get();

        foreach ($labels as $day) {
            $temp = $numberTicket = 0;
            foreach ($revenuas as $item) {
                if ($day == $item->day) {
                    $temp = $item->revenua;
                    $numberTicket = $item->number_ticker;
                }
            }
            array_push($arrRenua, $temp);
            array_push($arrTicket, $numberTicket);
        }

        return [
            'dataLabel' => $labels,
            'arrRenua' => $arrRenua,
            'arrTicket' => $arrTicket,
        ];
    }
}
