<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ColorDesign extends Pivot
{
	public $incrementing = true;

    protected $with = ['color','design'];

	public function color(){
        return $this->belongsTo('App\Color');
    }

    public function design(){
        return $this->belongsTo('App\Design');
    }

    public function tablecloths(){
        return $this->hasMany('App\Tablecloth','color_design_id');
    }

    public function bedcovers(){
        return $this->hasMany('App\Bedcover','color_design_id');
    }

    public function fabrics(){
        return $this->hasMany('App\Fabric','color_design_id');
    }

    public function prayermats(){
        return $this->hasMany('App\Prayermat','color_design_id');
    }

    public function pillows(){
        return $this->hasMany('App\Pillow','color_design_id');
    }

    public function frames(){
        return $this->hasMany('App\Frame','color_design_id');
    }

    public function etcs(){
        return $this->hasMany('App\Etc','color_design_id');
    }
}
