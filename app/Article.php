<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'image',
        'title',
        'e_title',
        'ar_title',
        'body',
        'e_body',
        'ar_body',
        'is_active',
        'views',
    ];
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getTitleAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_title;

            case 'ar':
                return $this->ar_title;

            default:
                return $this->attributes['title'];
        }
    }
    public function getBodyAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_body;

            case 'ar':
                return $this->ar_body;

            default:
                return $this->attributes['body'];
        }
    }
}
