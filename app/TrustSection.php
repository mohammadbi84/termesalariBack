<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrustSection extends Model
{
    protected $fillable = [
        'title_fa',
        'title_en',
        'description_fa',
        'description_en',
    ];

    public function counters()
    {
        return $this->hasMany(TrustCounter::class)->orderBy('order');
    }
}
