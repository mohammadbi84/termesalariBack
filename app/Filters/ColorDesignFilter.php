<?php

namespace App\Filters;

class ColorDesignFilter
{
    public function filter($builder, $value)
    {
        $designs = [];
        $colors = [];
        if(isset($value['design']))
            $designs = $value['design'];
        if(isset($value['color']))
            $colors = $value['color'];

        if(count($colors) > 0) {
            $builder->whereHas('color_design', function($query) use($colors){
                $query->where('color_id', $colors[0]);
                if(count($colors) > 1) {
                    foreach ($colors as $key => $color) {
                        if ($key != 0)
                            $query->orWhere('color_id', $color);
                    }
                }
            });
        }
        //----------------------------------------------
        if(count($designs) > 0) {
            $builder->whereHas('color_design', function($query) use($designs){
                $query->where('design_id', $designs[0]);
                if(count($designs) > 1) {
                    foreach ($designs as $key => $design) {
                        if ($key != 0)
                            $query->orWhere('design_id', $design);
                    }
                }
            });
        } 
        // dd($builder->getBindings());
    	return $builder;
    }
}