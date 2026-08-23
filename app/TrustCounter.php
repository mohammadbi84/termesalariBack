<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrustCounter extends Model
{
    protected $fillable = [
        'trust_section_id',
        'title_fa',
        'title_en',
        'title_ar',
        'number',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(TrustSection::class);
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
