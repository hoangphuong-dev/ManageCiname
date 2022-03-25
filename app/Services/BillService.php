<?php

namespace App\Services;

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
}
