<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateSection extends Model
{
    protected $fillable = [
        'title_fa',
        'title_en',
        'title_ar',
        'description_fa',
        'description_en',
        'description_ar',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class)->orderBy('order');
    }

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
