<?php

namespace App\Services;

use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Repositories\BillRepository;
use App\Repositories\CinemaRepository;
use App\Repositories\ShowTimeRepository;

class BillService
{
    public $billRepository;
    public $showTimeRepository;
    public $cinemaRepository;

    public function __construct(
        BillRepository $billRepository,
        ShowTimeRepository $showTimeRepository,
        CinemaRepository $cinemaRepository,
    ) {
        $this->billRepository = $billRepository;
        $this->showTimeRepository = $showTimeRepository;
        $this->cinemaRepository = $cinemaRepository;
    }

    public function getDataByMonth($request)
    {
        return $data = $this->billRepository->getDataByMonth($request);
    }

    public function getDataTicketByMonth($request)
    {
        return $data = $this->showTimeRepository->getDataTicketByMonth($request);
    }

    public function getBillCustomer($user_id)
    {
        try {
            return $this->billRepository->getBillCustomer($user_id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function createBill($user_id, $data)
    {
        try {
            return $this->billRepository->createBill($user_id, $data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getBillByAdmin($adminId, $request)
    {
        $cinema = $this->cinemaRepository->getCinemaByIdAdmin($adminId);

        $bills = $this->billRepository->getBillByAdmin($cinema->id, $request);

        return BillResource::collection($bills);
    }

    public function getBillById($id)
    {
        return $this->billRepository->getById($id);
    }

    public function updateStatus($id)
    {
        $this->billRepository->updateById($id, ['status' => Bill::PAYMENTED]);
    }

    public function deleteById($id)
    {
        return $this->billRepository->deleteById($id);
    }
}
