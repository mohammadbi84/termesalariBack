<?php

// TypeFilter.php

namespace App\Filters;

class CategoryFilter
{
    public function filter($builder, $value)
    {
    	if(is_array($value) and count($value) > 1) {
            $builder->where(function ($query)  use ($value): void {
                $query->where('category_id', $value[0]);
                for ($i = 1; $i < count($value); $i++) {
                    $query->orWhere('category_id', $value[$i]);
                }
            });

    		// $builder->where('category_id', $value[0]);
      //       for ($i=1; $i<count($value); $i++) {
      //            $builder->orWhere('category_id', $value[$i]);
      //       }
        } else {
        	$builder->where('category_id', $value);
    	}
    	return $builder;
    }
}