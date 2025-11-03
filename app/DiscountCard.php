<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountCard extends Model
{
    protected $fillable = ['code', 'type_scope','count_usable', 'type_amount', 'amount', 'start_date', 'expire_date','is_gifted' ];
    // protected $with = ['orders'];

    public function orders(){
    	return $this->hasMany('App\Order');
    }

}
