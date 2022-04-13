<?php

namespace App\Services;

use App\Http\Resources\BillResource;
use App\Repositories\BillRepository;

class BillService
{
    public $billRepository;

    public function __construct(BillRepository $billRepository)
    {
        $this->billRepository = $billRepository;
    }

    public function getDataByMonth($request)
    {
        return $data = $this->billRepository->getDataByMonth($request);
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

    public function getBillByCinema($admin_id, $request)
    {
        $bills = $this->billRepository->getBillByCinema($admin_id, $request);
        return BillResource::collection($bills);
    }
}
