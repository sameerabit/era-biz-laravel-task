<?php

namespace App\Filters;

use App\Filters\QueryFilter;
use Illuminate\Http\Request;

class ProductFilter extends QueryFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function name($name)
    {
        return $this->builder->where('name', 'LIKE', "%$name%");
    }

    public function description($description)
    {
        return $this->builder->where('description', 'LIKE', "%$description%");
    }

    public function min($min)
    {
        return $this->builder->where('price', '>=', $min);
    }

    public function max($max)
    {
        return $this->builder->where('price', '<=', $max);
    }

    public function sort_by_price($order = null)
    {
        return $this->builder->orderBy('price', $order ? $order : 'asc');
    }

    public function sort_by_name($order = null)
    {
        return $this->builder->orderBy('name', $order ? $order : 'asc');
    }
}
