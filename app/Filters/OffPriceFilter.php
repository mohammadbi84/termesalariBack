<?php

// TypeFilter.php

namespace App\Filters;

class OffPriceFilter
{
    public function filter($builder, $value)
    {
        
        if($value == true)
        {
            $l = 'تومان';
            $builder->whereHas('prices', function($query) use($value, $l){
                $query->where('local', $l)->where('offPrice', '>' , 0);
            });
            return $builder;
        }
    }
}