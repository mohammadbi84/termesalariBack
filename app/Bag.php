<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    protected $fillable = [
        'title', 'designTitle', 'countOfColor','rangeOfColor','dimensions','weight','type','kind','gender','longStrap','shortStrap','internalPocket','externalPocket','internalZipper','externalZipper','haveEster','kindOfEster','washable','uses','grade','description'
    ];
    protected $with = ['design','images','designColor'];

    public function design(){
        return $this->belongsTo('App\Design');
    }

    public function designColor(){
        return $this->belongsTo('App\DesignColor');
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favoriteable');
    }

    public function orderitems()
    {
        return $this->morphMany('App\Orderitem', 'orderitemable');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function grades()
    {
        return $this->morphMany('App\Grade', 'gradeable');
    }

    public function prices()
    {
        return $this->morphMany('App\Price', 'priceable');
    }
}
