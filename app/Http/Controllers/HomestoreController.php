<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tablecloth;
use App\Shoe;
use App\Orderitem;
use App\Price;
use App\Slideshow;
use App\Category;
use Illuminate\Support\Facades\DB;

class HomestoreController extends Controller
{
    public function index()
    {

        $topRequests = Orderitem::with('orderitemable')
            ->select(DB::raw('sum(count) as sum, orderitemable_id, orderitemable_type'))
            ->groupBy('orderitemable_id', 'orderitemable_type')
            ->orderby('sum','desc')
            ->take(20)
            ->get();

        $topRequests = $topRequests->filter(function($item){
            // dd($item);
            if ($item->orderitemable == null) {
                return false;
            }
            else if ($item->orderitemable->visibility == 0) {
                return false;
            }
            else
                return true;
        });

        $allSermeh = Category::where('title','like','%سرمه%')
            ->get();
        $sermehProducts = [];
        foreach ($allSermeh as $sermeh) { 
            $products = $sermeh->model::where('category_id',$sermeh->id)
                ->get();
            foreach ($products as $product) {
                if ($product->visibility == 1) {
                    array_push($sermehProducts, $product);
                }
            }
        }
        // dd($sermehProducts);

        $allCategories = Category::where('parent_id', 0)
            ->get();

        $category = Category::where('title','رومیزی')
            ->where('parent_id','0')
            ->where('active', 1)
            ->first();

        $tableclothsCategories = Category::where('parent_id',$category->id)
            ->where('active', 1)
            ->get();

        $specials = Price::with('priceable')
            ->select(DB::raw('*'))
            ->where('local','تومان')
            ->where('offPrice','>',0)
            ->get();
        // dd($specials);

        $specials = $specials->filter(function($item){
            // dd($item);
            if ($item->priceable == null) {
                return false;
            }
            else if ($item->priceable->visibility == 0) {
                return false;
            }
            else
                return true;
        });

        $slideshowImagesB = Slideshow::where('position','homeStore-B')
            ->orderby('order','asc')
            ->get();

        $slideshows = Slideshow::where('position','homeStore-A')
            ->where('visibility',1)
            ->get();

    	return view('homeStore')
            ->with('topRequests',$topRequests)
            ->with('slideshowImagesB',$slideshowImagesB)
            ->with('tableclothsCategories',$tableclothsCategories)
            ->with('allCategories',$allCategories)
            ->with('sermehProducts',$sermehProducts)
            ->with('slideshows',$slideshows)
    		->with('specials',$specials);
    }


    public function filter(Request $request)
    {
        // dd($request->all());
        $model = "App\\".$request->model;
        $condition = $request->condition;
        $query = $model::where('visibility',1)->get();
        return $query = $query->when($request->col, function ($query) use($request) {
            $query->where($request->col, $request->value);
        });
        
    }

}
