<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionSection extends Model
{
    protected $fillable = [
        'title_fa',
        'description_fa',
        'title_en',
        'description_en',
        'video_path',
        'video_cover',
    ];

    public function counters()
    {
        return $this->hasMany(MissionCounter::class);
    }
}
