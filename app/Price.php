<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['local','price','offType','offPrice'];

    public function priceable()
    {
    	return $this->morphTo();
    }
}
