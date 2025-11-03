<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	// protected $fillable = [];
	protected $with = ['user' , 'favoriteable'];

	public function favoriteable()
    {
        return $this->morphTo();
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
