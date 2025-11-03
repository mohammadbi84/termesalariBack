<?php

// TypeFilter.php

namespace App\Filters;

class QuantityFilter
{
    public function filter($builder, $value)
    {
        if($value == true)
        {
            $builder->where('quantity', '>' , 0);
        	return $builder;
        }
    }
}