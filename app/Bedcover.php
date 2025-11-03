<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bedcover extends Model
{
    Use SoftDeletes;

    protected $fillable = [
        'code','dimensions','weight','kind','contains','sewingType','haveEster','kindOfEster','washable','quantity','description'
    ];
    protected $with = ['color_design','images','grades', 'tags', 'prices','category'];

    protected $dates = ['deleted_at'];
    
    public function color_design(){
        return $this->belongsTo('App\ColorDesign');
    }

    // public function design(){
    //     return $this->belongsTo('App\Design');
    // }

    // public function designColor(){
    //     return $this->belongsTo('App\DesignColor');
    // }

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

    public function scopeFilter(Builder $builder, $request)
    {
        return (new ProductFilter($request))->filter($builder);
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    // public function scopeVisibility($query)
    // {
    //     return $query->where('visibility', 1);
    // }
    
}
