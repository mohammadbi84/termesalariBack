<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amazing extends Model
{
    protected $fillable = [
        'active',
        'is_passed',
        'is_applied',
        'productable_type',
        'productable_id',
        'start_date',
        'end_date',
        'max_sale',
        'sold',
        'discount',
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_passed' => 'boolean',
        'is_applied' => 'boolean',
    ];

    public function productable()
    {
        return $this->morphTo('productable');
    }
}
