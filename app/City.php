<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	public function recipients(){
    	return $this->hasMany("App\Recipient");
    }

    public function users(){
    	return $this->hasMany("App\User");
    }

    public function subcities(){
    	return $this->hasMany("App\Subcity");
    }

    public function getNameAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_name;

            case 'ar':
                return $this->ar_name;

            default:
                return $this->attributes['name'];
        }
    }
}
