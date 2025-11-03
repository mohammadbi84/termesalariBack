<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMessage extends Model
{
    Use SoftDeletes;

    protected $fillable = ['subject','message','isRead','parentID'];

    protected $with = ['user'];
    
    protected $dates = ['deleted_at'];


    public function user(){
        return $this->belongsTo('App\User');
    }

   public function parent()
   {
   		return $this->belongsTo('App\UserMessage', 'parentID');
   }
}
