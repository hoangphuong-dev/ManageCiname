<?php

namespace App\Models\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserInfoFilters implements Filters
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
        $this->filterByTypeOfWork($query);
        $this->filterByEmail($query);
        $this->filterByStatus($query);
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
            $q->select('staff_infos.*')
                ->where('users.name', 'LIKE', "%{$name}%")
                ->join('users', 'users.id', '=', 'staff_infos.user_id');
        });
    }

    /**
     * Apply filter by email
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByEmail(Builder $query): void
    {
        $query->when($this->request->query('email'), function (Builder $q, $email) {
            $q->select('staff_infos.*')
                ->where('users.email', $email)
                ->join('users', 'users.id', '=', 'staff_infos.user_id');
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
            $q->where('staff_infos.status', $status);
        });
    }

    /**
     * Apply filter by type of work
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByTypeOfWork(Builder $query): void
    {
        $query->when($this->request->query('type_of_work'), function (Builder $q, $type_of_work) {
            $q->where('type_of_work', $type_of_work);
        });
    }

    /**
     * Apply filter by type of work
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
