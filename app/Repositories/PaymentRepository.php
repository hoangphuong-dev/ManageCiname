<?php

namespace App\Repositories;

use App\Models\Payment;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class PaymentRepository.
 */
class PaymentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Payment::class;
    }

    public function make($fill)
    {
        return $this->model->create([
            'bill_id' => $fill['vnp_TxnRef'],
            'vnp_Amount' => $fill['vnp_Amount'],
            'vnp_BankCode' => $fill['vnp_BankCode'],
            'vnp_PayDate' => $fill['vnp_PayDate'],
            'vnp_CardType' => $fill['vnp_CardType']
        ]);
    }
}