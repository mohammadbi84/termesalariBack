<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'name_fa', 'name_en','name_ar', 'pretext_fa', 'pretext_en','pretext_ar', 'description_fa', 'description_en','description_ar', 'image'
    ];

    public function getNameAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->name_en;

            case 'ar':
                return $this->name_ar;

            default:
                return $this->name_fa;
        }
    }
    public function getPretextAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->pretext_en;

            case 'ar':
                return $this->pretext_ar;

            default:
                return $this->pretext_fa;
        }
    }
    public function getDescriptionAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->description_en;

            case 'ar':
                return $this->description_ar;

            default:
                return $this->description_fa;
        }
    }
}
