<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'price','active'];

    public function orders(){
    	return $this->hasMany('App\Order');
    }
}
