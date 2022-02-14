<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobBeLongToHospitalFilters implements Filters
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
        $this->filterByDateRange($query);

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

    private function filterByStatus(Builder $query): void
    {
        $status = $this->request->query('status');
        if (!is_null($status)) {
            $query->where('status', $status);
        }
    }

    private function filterByDateRange(Builder $query): void
    {
        $daterange = $this->request->query('daterange');
        if (!is_null($daterange) && is_array($daterange)) {
            $query->whereBetween('created_at', $daterange);
        }
    }
}
