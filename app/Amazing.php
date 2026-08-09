<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amazing extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
    ];

    public function productable() {
        return $this->morphTo('productable');
    }
}
