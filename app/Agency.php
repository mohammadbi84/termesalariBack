<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'name_fa',
        'name_en',
        'image',
        'address_fa',
        'address_en',
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
}
