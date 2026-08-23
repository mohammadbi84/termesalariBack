<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionSection extends Model
{
    protected $fillable = [
        'title_fa',
        'description_fa',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'video_path',
        'video_cover',
    ];

    public function counters()
    {
        return $this->hasMany(MissionCounter::class);
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
