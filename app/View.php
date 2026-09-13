<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'ip',
        'user_agent',
    ];

    public function viewable()
    {
        return $this->morphTo();
    }
}
