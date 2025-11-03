<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = ['title', 'countOfColor','active'];
    // protected $with = ['designColors','colors'];

    // public function designColors(){
    //     return $this->hasMany('App\DesignColor');
    // }

    public function colors(){
        return $this->belongsToMany('App\Color')->withTimestamps();
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
