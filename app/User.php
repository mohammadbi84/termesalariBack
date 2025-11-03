<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    Use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','family','nationalCode','isForeign','mobile','birthday','role','isActive','image','companyName','companyEconomyID','companyNationalID','companyRegistrationID','companyTel' , 'companySite', 'shaba_number', 'send_newsletter','mobile_forget_password_code'
    ];
    protected $with = ['city','subcity',];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function favorites(){
        return $this->hasMany('App\Favorite');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function recipients(){
        return $this->hasMany('App\Recipient');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function grades()
    {
        return $this->hasMany('App\Grade');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function subcity(){
        return $this->belongsTo('App\Subcity');
    }

    public function userMessages(){
        return $this->hasMany('App\UserMessage');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
