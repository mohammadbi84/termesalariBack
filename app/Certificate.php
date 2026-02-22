<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'certificate_section_id',
        'image',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(CertificateSection::class);
    }
}
