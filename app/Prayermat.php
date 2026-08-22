<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prayermat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'dimensions',
        'weight',
        'kind',
        'contains',
        'sewingType',
        'haveEster',
        'kindOfEster',
        'washable',
        'quantity',
        'description',

        'e_dimensions',
        'e_weight',
        'e_kind',
        'e_contains',
        'e_sewingType',
        'e_haveEster',
        'e_kindOfEster',
        'e_description',
        'e_washable',

        'ar_dimensions',
        'ar_weight',
        'ar_kind',
        'ar_contains',
        'ar_sewingType',
        'ar_haveEster',
        'ar_kindOfEster',
        'ar_description',
        'ar_washable',
    ];

    public function getDimensionsAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_dimensions;

            case 'ar':
                return $this->ar_dimensions;

            default:
                return $this->attributes['dimensions'];
        }
    }
    public function getWeightAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_weight;

            case 'ar':
                return $this->ar_weight;

            default:
                return $this->attributes['weight'];
        }
    }
    public function getKindAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_kind;

            case 'ar':
                return $this->ar_kind;

            default:
                return $this->attributes['kind'];
        }
    }
    public function getContainsAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_contains;

            case 'ar':
                return $this->ar_contains;

            default:
                return $this->attributes['contains'];
        }
    }
    public function getSewingTypeAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_sewingType;

            case 'ar':
                return $this->ar_sewingType;

            default:
                return $this->attributes['sewingType'];
        }
    }
    public function getHaveEsterAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_haveEster;

            case 'ar':
                return $this->ar_haveEster;

            default:
                return $this->attributes['haveEster'];
        }
    }
    public function getKindOfEsterAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_kindOfEster;

            case 'ar':
                return $this->ar_kindOfEster;

            default:
                return $this->attributes['kindOfEster'];
        }
    }
    public function getWashableAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_washable;

            case 'ar':
                return $this->ar_washable;

            default:
                return $this->attributes['washable'];
        }
    }
    public function getDescriptionAttribute()
    {
        switch (app()->getLocale()) {
            case 'en':
                return $this->e_description;

            case 'ar':
                return $this->ar_description;

            default:
                return $this->attributes['description'];
        }
    }

    protected $with = ['color_design', 'images', 'grades', 'tags', 'prices', 'category'];

    protected $dates = ['deleted_at'];

    public function color_design()
    {
        return $this->belongsTo('App\ColorDesign');
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

    public function scopeFilter(Builder $builder, $request)
    {
        return (new ProductFilter($request))->filter($builder);
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function amazings()
    {
        return $this->morphMany('App\Amazing', 'productable');
    }

    // public function scopeVisibility($query)
    // {
    //     return $query->where('visibility', 1);
    // }
}
