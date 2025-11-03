<?php

// TypeFilter.php

namespace App\Filters;
use Illuminate\Support\Facades\DB;


class PriceRangeFilter
{
    public function filter($builder, $value)
    {
        $l = 'تومان';
        $builder->whereHas('prices', function($query) use($value, $l){
            $query->where('local', $l)->whereBetween('price', explode(';', $value));
        });
        
    	return $builder;
    }
}