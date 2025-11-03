<?php

// ProductFilter.php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    protected $filters = [
        'category' => CategoryFilter::class ,
        // 'design' => ColorDesignFilter::class ,
        // 'designColor' => ColorDesignFilter::class ,
        'colorDesign' => ColorDesignFilter::class ,
        'priceRange' => PriceRangeFilter::class ,
        'offPrice' => OffPriceFilter::class ,
        'quantity' => QuantityFilter::class ,
        // 'priceSort' => PriceSortFilter::class,
    ];
}