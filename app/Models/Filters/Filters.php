<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;

interface Filters
{
    /**
     * Get query after apply filters
     *
     * @param  Builder $query
     * @return Builder
     */
    public function getQuery(Builder $query): Builder;
}
