<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\Province;
use Carbon\Carbon;

/**
 * Class SuperAdminAnalysisRepository.
 */
class SuperAdminAnalysisRepository extends ProvinceRepository
{

    public function analysisByProvince($request)
    {
        $arrRevenuaProvince = $arrTicketOrdered = [];
        $provinces = $this->getProvinceHasCinema();

        foreach ($provinces as $province) {
            $data = Province::query()
                ->with('cinemas')
                ->where('id', $province->id)->first();

            $arrCinemaId = $data->cinemas->pluck('id')->toArray();

            $result = $this->getDataByProvince($arrCinemaId, $request->selected_month);

            array_push($arrRevenuaProvince, $result['revenua']);
            array_push($arrTicketOrdered, $result['ticket']);
        }

        return [
            'ticketOrdered' => $arrTicketOrdered,
            'revenua' => $arrRevenuaProvince,
            'provinces' => $provinces->pluck('name')->toArray(),
        ];
    }

    public function getDataByProvince($arrCinemaId, $month)
    {
        $revenua = 0;
        $ticket = 0;

        $monthFormat = Carbon::parse($month)->format('Y-m');

        foreach ($arrCinemaId as $item) {
            $bills = Bill::query()
                ->where('created_at', 'LIKE', "{$monthFormat}%")
                ->where('cinema_id', $item)->get();

            $ticket += $this->getCountTicker($bills);
            $revenua += $bills->sum('total_money');
        }

        return [
            'revenua' => $revenua,
            'ticket' => $ticket,
        ];
    }

    public function getCountTicker($arrBill)
    {
        $result = 0;

        foreach ($arrBill as $item) {
            $bill = Bill::query()->with('tickets')->where('id', $item->id)->first();
            $result += $bill->tickets->count();
        }

        return $result;
    }

    public function getListProvince()
    {
        return $this->getProvinceHasCinema();
    }

    public function analysisByProvinceDetail()
    {
    }
}
