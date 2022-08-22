<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\ShowTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminAnalysisRepository
{
    public static function getMovieAnalysis($startDate, $endDate, $cinemaId, $labelWeek)
    {
        $cinema = Cinema::query()->whereId($cinemaId)->with(['rooms'])->first();
        $arrRoomId = $cinema->rooms->pluck('id')->toArray();

        $movies = ShowTime::query()
            ->whereIn('room_id', $arrRoomId)
            ->withCount(['tickets' => function ($q) use ($startDate, $endDate) {
                return $q->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->with(['tickets' => function ($q) use ($startDate, $endDate) {
                return $q->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['tickets' => function ($q) use ($startDate, $endDate) {
                return $q->whereBetween('created_at', [$startDate, $endDate]);
            }], 'price')
            ->with(['room' => function ($q) {
                return $q->select('id')->withCount('seats');
            }])
            ->get()->groupBy('movie_id');

        $result = [];

        foreach ($movies as $key => $movie) {
            $movieInfo = Movie::select('trailer', 'name')->whereId($key)->first();

            $ticketCount =  $sumPrice = $seatCount = 0;
            foreach ($movie as $item) {
                $dataChart = (new self)->mapDataWeek($item->tickets, $labelWeek);
                $ticketCount += $item->tickets_count;
                $sumPrice += $item->tickets_sum_price;
                $seatCount += $item->room->seats_count;
            }

            array_push(
                $result,
                [
                    'name' => $movieInfo->name,
                    'trailer' => $movieInfo->trailer,
                    'ticketCount' => $ticketCount,
                    'sumPrice' => $sumPrice,
                    'seatCount' => $seatCount,
                    'dataChart' => $dataChart,
                    'labelWeek' => $labelWeek,
                    'percent' => $seatCount > 0 ? ($ticketCount / $seatCount * 100) : 0,
                ]
            );
        }

        usort($result, function ($a, $b) {
            return $b['percent'] <=> $a['percent'];
        });
        return $result;
    }

    private function mapDataWeek($data, $label)
    {
        if (is_null($data)) {
            return [];
        }

        $arr = [];
        $revenua = 0;
        foreach ($label as $day) {
            foreach ($data as $item) {
                if (Carbon::parse($item->created_at)->format('d-m-Y') == $day) {
                    $revenua += $item->price;
                }
            }

            array_push($arr, $revenua);
        }
        return $arr;
    }

    public function analysisByCinema($request, $labels, $cinemaId)
    {
        $arrRenua = $arrTicket = [];
        $monthFormat = Carbon::parse($request->selected_month)->format('Y-m');

        $revenuas = Bill::query()->select('total_money')
            ->selectRaw('DATE_FORMAT(bills.created_at, "%d-%m-%Y") as day')
            ->where('bills.created_at', 'LIKE', "{$monthFormat}%")
            ->where('status', BiLL::PAYMENTED)
            ->where('cinema_id', $cinemaId)
            ->withCount('tickets')
            ->get();

        foreach ($labels as $day) {
            $temp = $numberTicket = 0;
            foreach ($revenuas as $item) {
                if ($day == $item->day) {
                    $temp += $item->total_money;
                    $numberTicket += $item->tickets_count;
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
