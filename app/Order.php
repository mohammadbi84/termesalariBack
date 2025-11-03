<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    Use SoftDeletes;
	protected $fillable = ['code','postPrice','local','status'];
	protected $with = ['user','post','orderitems','recipient','payments','discountCard'];
    protected $dates = ['deleted_at'];

	public function orderitems(){
		return $this->hasMany('App\Orderitem');
	}

	public function user(){
    	return $this->belongsTo('App\User');
    }

    public function post(){
    	return $this->belongsTo('App\Post');
    }

    public function payments(){
        return $this->hasMany('App\Payment');
    }

    public function recipient(){
    	return $this->belongsTo('App\Recipient');
    }

    public function discountCard()
    {
        return $this->belongsTo('App\DiscountCard');
    }

}
