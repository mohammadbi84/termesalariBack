<?php

// TypeFilter.php

namespace App\Filters;
use Illuminate\Support\Facades\DB;


class PriceSortFilter
{
    public function filter($builder, $value)
    {
        //dd($value);
        $l = 'تومان';
        $builder->whereHas('prices', function($query) use($value, $l){
            $query->where('local', $l);
        });
        
    	return $builder;
    }
}