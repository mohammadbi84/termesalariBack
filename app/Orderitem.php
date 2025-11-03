<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderitem extends Model
{

    Use SoftDeletes;
	protected $fillable = ['offPrice', 'price', 'count'];
	protected $with = ['orderitemable'];
    protected $dates = ['deleted_at'];

    public function orderitemable()
    {
        return $this->morphTo();
    }

    public function order(){
    	return $this->belongsTo('App\Order');
    }
}
