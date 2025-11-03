<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{

    protected $fillable = [
        'title', 'designTitle', 'countOfColor','rangeOfColor','dimensions','sizesOf','weight','type','kind','gender','kindOfOver','kindOfUnder','washable','uses','grade','description'
    ];
    protected $with = ['design','images','designColor','grades', 'tags', 'prices'];

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
