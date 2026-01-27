<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PopupImage extends Model
{
    protected $fillable = [
        'popup_id',
        'image',
        'order',
        'duration',
    ];

    protected $casts = [
        'order' => 'integer',
        'duration' => 'integer',
    ];

    public function popup()
    {
        return $this->belongsTo(Popup::class);
    }

    /**
     * آدرس کامل تصویر
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
