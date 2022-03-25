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

    public function createBill($user_id, $data)
    {
        // try catch o day nua nhe 
        return $this->billRepository->createBill($user_id, $data);
    }

    public function getBillByCinema($admin_id, $request)
    {
        $bills = $this->billRepository->getBillByCinema($admin_id, $request);
        return BillResource::collection($bills);
    }
}
