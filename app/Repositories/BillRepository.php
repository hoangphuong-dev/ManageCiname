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

    public function getBillByCinema($admin_id, $request)
    {
        return $this->model->newQuery()
        ->
    }

    public function createBill($user_id, $data)
    {
        return $this->newQuery()->create([
            'user_id' => $user_id,
            'total_money' => $data['total_money'],
            'cinema_id' => $data['cinema_id'],
        ]);
    }
}
