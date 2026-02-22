<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrustCounter extends Model
{
    protected $fillable = [
        'trust_section_id',
        'title_fa',
        'title_en',
        'number',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(TrustSection::class);
    }
}
