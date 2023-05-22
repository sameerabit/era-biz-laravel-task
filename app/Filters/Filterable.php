<?php

namespace App\Filters;

use App\Filters\QueryFilter;

trait Filterable
{
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
