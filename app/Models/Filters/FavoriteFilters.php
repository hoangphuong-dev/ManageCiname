<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FavoriteFilters implements Filters
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
        $query->when($this->request->query('search'), function (Builder $q, $name) {
            if ($name || $name === '0') {
                $q->where('name', 'LIKE', "%{$name}%");
            }
        });
    }
}
