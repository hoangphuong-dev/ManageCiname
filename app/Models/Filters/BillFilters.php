<?php

namespace App\Models\Filters;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BillFilters implements Filters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get query after apply filters
     *
     * @param  Builder $query
     * @return Builder
     */
    public function getQuery(Builder $query): Builder
    {
        $this->filterByName($query);
        $this->filterByStatus($query);
        $this->filterByVoucher($query);
        $this->filterByRange($query);

        return $query;
    }

    /**
     * Apply filter by name
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByName(Builder $query): void
    {

        $query->when($this->request->query('name'), function (Builder $q, $name) {
            $q->select('bills.*')
                ->where('users.name', 'LIKE', "%{$name}%")
                ->join('users', 'users.id', '=', 'bills.user_id');
        });
    }

    /**
     * Apply filter by status
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByStatus(Builder $query): void
    {
        $query->when($this->request->query('status'), function (Builder $q, $status) {
            $q->where('bills.status', $status);
        });
    }

    /**
     * Apply filter by name
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByVoucher(Builder $query): void
    {
        $query->when($this->request->query('voucher'), function (Builder $q, $voucher) {
            if ($voucher == 1) {
                $q->whereIn('bills.id', $this->getBillHasVoucher());
            } else {
                $q->whereNotIn('bills.id', $this->getBillHasVoucher());
            }
        });
    }

    protected function getBillHasVoucher()
    {
        return Voucher::query()
            ->whereNotNull('bill_id')->get()
            ->pluck('bill_id')->toArray();
    }

    /**
     * Apply filter by name
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByRange(Builder $query): void
    {
        $query->when($this->request->query('range'), function (Builder $q, $range) {
            $q->whereBetween('created_at',  [Carbon::parse($range[0])->startOfDay(), Carbon::parse($range[1])->endOfDay()]);
        });
    }
}
