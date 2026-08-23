<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $fillable = [
        'title_fa',
        'description_fa',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'link',
        'is_active',
        'start_at',
        'end_at',
        'sort',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * پاپ‌آپ فعال و در بازه زمانی معتبر
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_at')->orWhere('start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_at')->orWhere('end_at', '>=', now());
            });
    }

    public function images()
    {
        return $this->hasMany(PopupImage::class)->orderBy('order');
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'link');
    }

    /**
     * بررسی آیا پاپ‌آپ در حال حاضر فعال است
     */
    public function getIsCurrentlyActiveAttribute()
    {
        return $this->is_active &&
            ($this->start_at === null || $this->start_at <= now()) &&
            ($this->end_at === null || $this->end_at >= now());
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

    public function getDescriptionAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->description_en;

            case 'ar':
                return $this->description_ar;

            default:
                return $this->description_fa;
        }
    }

    /**
     * فرمت تاریخ برای نمایش
     */
    // public function getFormattedStartAtAttribute()
    // {
    //     return $this->start_at ? verta($this->start_at)->format('Y/m/d H:i') : '-';
    // }

    // public function getFormattedEndAtAttribute()
    // {
    //     return $this->end_at ? verta($this->end_at)->format('Y/m/d H:i') : '-';
    // }
}
