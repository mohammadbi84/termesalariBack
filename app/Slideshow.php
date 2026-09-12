<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    protected $fillable = [
        'position',
        'title',
        'description',
        'image',
        'link',
        'order',
        'video',
        'duration',
        'e_title',
        'ar_title',
        'e_description',
        'ar_description',
    ];

    public function getTitleAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_title;

            case 'ar':
                return $this->ar_title;

            default:
                return $this->attributes['title'];
        }
    }
    public function getDescriptionAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_description;

            case 'ar':
                return $this->ar_description;

            default:
                return $this->attributes['description'];
        }
    }
}
