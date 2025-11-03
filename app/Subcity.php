<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcity extends Model
{
	protected $with = ["city"];
	
    public function recipients(){
    	return $this->hasMany("App\Recipient");
    }

    public function users(){
    	return $this->hasMany("App\User");
    }

    public function city(){
    	return $this->belongsTo("App\City");
    }
}
