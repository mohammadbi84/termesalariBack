<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateSection extends Model
{
    protected $fillable = [
        'title_fa',
        'title_en',
        'description_fa',
        'description_en',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class)->orderBy('order');
    }
}
