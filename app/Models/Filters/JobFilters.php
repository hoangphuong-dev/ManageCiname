<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobFilters implements Filters
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
        $this->filterByEmail($query);
        $this->filterByStatus($query);
        $this->filterByTypeOfwork($query);
        $this->filterByAnnualIncome($query);
        $this->filterByTag($query);
        $this->filterByHospitalType($query);
        $this->filterByAddress($query);
        $this->filterByAnnualIncome($query);

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
            if ($name || $name === '0') {
                $q->where('name', 'LIKE', "%{$name}%");
            }
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
            $q->where('email', 'LIKE', "%{$email}%");
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
        $status = $this->request->query('status');
        $check = $status || $status === '0' ? true : false;

        $query->when($check, function (Builder $q, $status) {
            $q->where('status', $status);
        });
    }


    /**
     * Apply filter by type_of_work
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByTypeOfwork(Builder $query): void
    {
        $query->when($this->request->query('type_of_work'), function (Builder $q, $type_of_work) {
            $q->where('type_of_work', $type_of_work);
        });
    }


    /**
     * Apply filter by type_of_work
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByAnnualIncome(Builder $query): void
    {
        $query->when($this->request->query('annual_income_min'), function (Builder $q, $annual_income_min) {
            $q->where('annual_income_min', '>=', $annual_income_min);
        })
        ->when($this->request->query('annual_income_max'), function (Builder $q, $annual_income_max) {
            $q->where('annual_income_max', '<=', $annual_income_max);
        });
    }

    /**
     * Apply filter by type_of_work
     *
     * @param  Builder $query
     * @return void
     */
    protected function filterByTag(Builder $query): void
    {
        $query->when($this->request->query('tag'), function (Builder $q, $tag_id) {
            return $q->whereHas('tags', function ($query) use ($tag_id) {
                return $query->where('tag_id', $tag_id);
            });
        });
    }

    protected function filterByHospitalType(Builder $query): void
    {
        $query->when($this->request->query('hospital_type'), function (Builder $q, $hospital_type_id) {
            return $q->join('hospital_infos', 'jobs.user_id', '=', 'hospital_infos.user_id')
            ->where('hospital_type_id', $hospital_type_id);
        });
    }

    protected function filterByAddress(Builder $query): void
    {
        $query->when($this->request->query('address'), function (Builder $q, $address) {
            $q->where('address', 'like', '%'.$address.'%');
        });
    }
}
