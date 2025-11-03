<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
   	protected $fillable = ['grade'];

   	public function gradeable()
    {
        return $this->morphTo();
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
