<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionCounter extends Model
{
    protected $fillable = [
        'mission_section_id',
        'title_fa',
        'title_en',
        'number',
        'order',
    ];

    public function missionSection()
    {
        return $this->belongsTo(MissionSection::class);
    }
}
