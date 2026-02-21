<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'name_fa', 'name_en', 'pretext_fa', 'pretext_en', 'description_fa', 'description_en', 'image'
    ];
}
