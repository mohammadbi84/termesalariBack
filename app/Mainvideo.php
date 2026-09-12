<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mainvideo extends Model
{
    protected $fillable = [
        'title',
        'video',
        'cover',
        'status',
        'e_video',
        'ar_video',
        'e_title',
        'ar_title',
        'e_cover',
        'ar_cover',
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
    public function getVideoAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_video;

            case 'ar':
                return $this->ar_video;

            default:
                return $this->attributes['video'];
        }
    }
    public function getCoverAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_cover;

            case 'ar':
                return $this->ar_cover;

            default:
                return $this->attributes['cover'];
        }
    }
}
