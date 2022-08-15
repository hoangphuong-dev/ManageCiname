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

    private function getCinemaByProvince($provinceId)
    {
        $province = Province::query()
            ->with('cinemas')->where('id', $provinceId)->first();

        return is_null($province) ? null : $province->cinemas;
    }

    public function analysisByProvince($request)
    {
        $arrRevenuaProvince = $arrTicketOrdered = [];
        $provinces = $this->getProvinceHasCinema();

        foreach ($provinces as $province) {
            $arrCinemaId = $this->getCinemaByProvince($province->id)->pluck('id')->toArray();

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

    public function analysisByProvinceDetail($request)
    {
        $cinemas = $this->getCinemaByProvince($request->province);

        $monthFormat = Carbon::parse($request->selected_month)->format('Y-m');
        $arrRevenuaCinema =  $arrTicketOrdered = [];

        foreach ($cinemas as $cinema) {
            $bills = Bill::query()
                ->where('created_at', 'LIKE', "{$monthFormat}%")
                ->where('cinema_id', $cinema->id)->get();

            array_push($arrRevenuaCinema, $bills->sum('total_money'));
            array_push($arrTicketOrdered, $this->getCountTicker($bills));
        }

        return [
            'ticketOrdered' => $arrTicketOrdered,
            'revenua' => $arrRevenuaCinema,
            'cinemas' => $cinemas->pluck('name')->toArray(),
        ];
    }
}
