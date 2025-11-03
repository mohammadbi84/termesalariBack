<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
	Use SoftDeletes;
	
    protected $fillable = ['name', 'family', 'mobile','tel','city','subcity','address','houseId','zipcode','lat','lan'];

    protected $dates = ['deleted_at'];

    protected $with = ["subcity","city"];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function city(){
    	return $this->belongsTo('App\City');
    }

    public function subcity(){
        return $this->belongsTo('App\Subcity');
    }

    public function orders(){
        return $this->belongsTo('App\Order');
    }    
}
