<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color'];
    // protected $with = ['designs'];

    public function designs(){
        return $this->belongsToMany('App\Design')->withTimestamps();
    }
}
