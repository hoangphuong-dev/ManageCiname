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

    public function getBillCustomer($user_id)
    {
        return $this->model->newQuery()
            ->with(['user', 'voucher'])
            ->where('user_id', $user_id)
            ->orderBy('id', "DESC")
            ->paginate(12);
    }

    public function getBillByCinema($admin_id, $request)
    {
        return $this->model->newQuery()
            // ->when($request->action, function ($query) use ($request) {
            //     return $query->where("movies.status", "=", $request->action);
            // })
            ->with(['cinema' => function ($q) use ($admin_id) {
                $q->where('user_id', $admin_id);
            }])
            ->orderBy('id', "DESC")
            ->paginate($request->query('limit', 12));
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
