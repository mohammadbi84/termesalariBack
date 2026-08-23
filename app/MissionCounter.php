<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionCounter extends Model
{
    protected $fillable = [
        'mission_section_id',
        'title_fa',
        'title_en',
        'title_ar',
        'number',
        'order',
    ];

    public function missionSection()
    {
        return $this->belongsTo(MissionSection::class);
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
}
