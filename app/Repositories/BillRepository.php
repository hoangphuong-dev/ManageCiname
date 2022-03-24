<?php

namespace App\Repositories;

use App\Models\Bill;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class BillRepository.
 */
class BillRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Bill::class;
    }

    public function createBill($user_id, $tottal_money)
    {
        return $this->newQuery()->create([
            'user_id' => $user_id,
            'total_money' => $tottal_money,
        ]);
    }
}
