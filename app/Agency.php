<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'name_fa',
        'name_en',
        'name_ar',
        'image',
        'address_fa',
        'address_en',
        'address_ar',
        'latitude',
        'longitude',
        'city_id',
        'state_id',
        'phone',
        'mobile',
        'social_links',
        'sort',
    ];

    protected $casts = [
        'social_links' => 'array',
        'sort' => 'integer',
    ];

    public function state()
    {
        return $this->belongsTo(City::class , 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /* -------------------- روابط -------------------- */

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

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
    public function getAddressAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->address_en;

            case 'ar':
                return $this->address_ar;

            default:
                return $this->address_fa;
        }
    }
}
