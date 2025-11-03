<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $fillable = ['tracing_code','date','transaction_id','price','res_code','ref_id','description'];

	protected $with = ['payment_method'];

    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function payment_method(){
        return $this->belongsTo('App\PaymentMethod');
    }
}
