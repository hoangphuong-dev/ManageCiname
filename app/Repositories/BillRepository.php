<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Filters\BillFilters;
use Illuminate\Database\Eloquent\Builder;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

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

    // thống kê 
    public function getDataByMonth($request)
    {
        return $this->model->newQuery()
            ->selectRaw('DATE_FORMAT(created_at, "%m-%Y") as month')
            ->selectRaw('sum(total_money) as revenua')
            ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                return $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            })
            ->groupBy('month')
            ->get()->toArray();
    }
    // end thống kê 

    public function getBillCustomer($user_id)
    {
        return $this->model->newQuery()
            ->with(['user', 'voucher'])
            ->where('user_id', $user_id)
            ->orderBy('id', "DESC")
            ->paginate(12);
    }

    public function createBill($user_id, $data)
    {
        return $this->model->updateOrCreate([
            'user_id' => $user_id,
            'total_money' => $data['total_money'],
            'cinema_id' => $data['cinema_id'],
        ]);
    }

    public function getBillByAdmin($cinemaId, $request)
    {
        return $this->model->query()
            ->filters(new BillFilters($request))
            ->with(['user', 'voucher'])
            ->where('cinema_id', $cinemaId)
            ->orderBy('id', "DESC")
            ->paginate(12);
    }
}
