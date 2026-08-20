<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color','e_color'];
    // protected $with = ['designs'];

    public function designs(){
        return $this->belongsToMany('App\Design')->withTimestamps();
    }

    public function getColorAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_color;

            case 'ar':
                return $this->ar_color;

            default:
                return $this->attributes['color'];
        }
    }
}
