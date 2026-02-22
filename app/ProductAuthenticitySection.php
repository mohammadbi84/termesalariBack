<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAuthenticitySection extends Model
{
    protected $fillable = [
        'title_fa',
        'title_en',
        'description_fa',
        'description_en',
        'image',
        'background_image',
    ];
}
