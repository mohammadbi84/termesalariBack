<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['model','title','image','link','parent_id','active'];

    public function childs(){
    	return $this->hasMany('App\Category','parent_id');
    }
    public function parent(){
    	return $this->belongsTo('App\Category','parent_id');
    }

    public function bags(){
    	return $this->hasMany('App\Bag');
    }

    public function shoes(){
    	return $this->hasMany('App\Shoe');
    }

    public function tablecloths(){
    	return $this->hasMany('App\Tablecloth');
    }

    public function bedcovers(){
    	return $this->hasMany('App\Bedcover');
    }

    public function fabrics(){
    	return $this->hasMany('App\Fabric');
    }

    public function prayermats(){
    	return $this->hasMany('App\Prayermat');
    }

    public function pillows(){
    	return $this->hasMany('App\Pillow');
    }

    public function frames(){
    	return $this->hasMany('App\Frame');
    }

    public function etcs(){
    	return $this->hasMany('App\Etc');
    }
}
