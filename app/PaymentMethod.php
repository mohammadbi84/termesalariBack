<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['title','description','selection','active'];

    // public function orders(){
    // 	return $this->hasMany('App\Order');
    // }

    public function payment(){
        return $this->hasOne('App\Payment');
    }
}
