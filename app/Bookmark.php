<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = [
        'title_fa',
        'body_fa',
        'title_en',
        'title_ar',
        'body_en',
        'body_ar',
        'sort',
        'active',
        'start_at',
        'end_at',
        'duration',
        'height',
    ];
    public function scopeActive($query)
    {
        return $query->where('active', true)
            ->where(function ($q) {
                $q->whereNull('start_at')->orWhere('start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_at')->orWhere('end_at', '>=', now());
            });
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
    public function getBodyAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->body_en;

            case 'ar':
                return $this->body_ar;

            default:
                return $this->body_fa;
        }
    }
}
