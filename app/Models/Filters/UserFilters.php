<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilters implements Filters
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

        $query->when($check, function (Builder $q) use ($status) {
            $q->where('status', $status);
        });
    }
}
