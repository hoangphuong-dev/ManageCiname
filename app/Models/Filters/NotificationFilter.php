<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class NotificationFilter implements Filters
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
        $query->when($this->request->query('title'), function (Builder $q, $title) {
            $q->where('title', 'LIKE', "%{$title}%");
        });
    }

    protected function filterByStatus(Builder $query): void
    {
        $status = $this->request->query('status');
        if(!is_null($status)) {
            $query->where('status', $status);
        }
    }
}
