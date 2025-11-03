<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    protected $fillable = ['position','title','description','image','link','order'];
}
