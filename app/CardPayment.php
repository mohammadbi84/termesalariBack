<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardPayment extends Model
{
	protected $fillable = ['tracing_code','date','price'];
	// protected $with = ['order'];

    public function order()
    {
        return $this->morphOne('App\Order', 'orderable');
	}
}

