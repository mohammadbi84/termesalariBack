<?php

// AbstractFilter.php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    protected $request;

    protected $filters = [];

    public function __construct(Request $request)
    {
        // dd($request->all());
        $this->request = $request;
    }
    public function filter(Builder $builder)
    {   
        // dd($builder->getBindings());
        foreach($this->getFilters() as $filter => $value)
        {
            $this->resolveFilter($filter)->filter($builder, $value);
        }
        // dd($builder->getBindings());
        return $builder;
    }

    protected function getFilters()
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }

    protected function resolveFilter($filter)
    {
        // dd($this->filters[$filter]);
        return new $this->filters[$filter];
    }
}