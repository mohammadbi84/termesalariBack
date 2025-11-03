<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function bags()
    {
        return $this->morphedByMany('App\Bag', 'taggable');
    }

    public function tablecloths()
    {
        return $this->morphedByMany('App\Tablecloth', 'taggable');
    }

    public function shoes()
    {
        return $this->morphedByMany('App\Shoe', 'taggable');
    }

    public function bedcovers()
    {
        return $this->morphedByMany('App\Bedcover', 'taggable');
    }

    public function fabrics()
    {
        return $this->morphedByMany('App\Fabric', 'taggable');
    }

    public function prayermats()
    {
        return $this->morphedByMany('App\Prayermat', 'taggable');
    }

    public function pillows()
    {
        return $this->morphedByMany('App\Pillow', 'taggable');
    }

    public function frames()
    {
        return $this->morphedByMany('App\Frame', 'taggable');
    }

    public function etcs()
    {
        return $this->morphedByMany('App\Etc', 'taggable');
    }

}
