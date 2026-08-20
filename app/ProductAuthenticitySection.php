<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAuthenticitySection extends Model
{
    protected $fillable = [
        'title_fa',
        'title_en',
        'description_fa',
        'description_en',
        'image',
        'background_image',
    ];

    public function getTitleAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->title_en;

            case 'ar':
                return $this->title_ar;

            default:
                return $this->title_fa;
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
