<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text','status'];
    protected $with = ['user','commentable'];

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
