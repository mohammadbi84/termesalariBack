<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Bedcover;
use Illuminate\Http\Request;
use App\Tablecloth;
use App\Shoe;
use App\Orderitem;
use App\Price;
use App\Slideshow;
use App\Category;
use App\CertificateSection;
use App\Generation;
use App\MissionSection;
use App\Pillow;
use App\Popup;
use App\Prayermat;
use App\ProductAuthenticitySection;
use Illuminate\Support\Facades\DB;

class HomestoreController extends Controller
{
    public function index()
    {
        $agencies = Agency::with('city', 'state')->orderBy('city_id', 'asc')->get();
        $popups = Popup::active()
            ->with(['images' => function ($query) {
                $query->orderBy('order');
            }])
            ->orderBy('sort', 'asc')->get();
        $topRequests = Orderitem::with('orderitemable')
            ->select(DB::raw('sum(count) as sum, orderitemable_id, orderitemable_type'))
            ->groupBy('orderitemable_id', 'orderitemable_type')
            ->orderby('sum', 'desc')
            ->take(20)
            ->get();

        $topRequests = $topRequests->filter(function ($item) {
            // dd($item);
            if ($item->orderitemable == null) {
                return false;
            } else if ($item->orderitemable->visibility == 0) {
                return false;
            } else
                return true;
        });

        $newestProducts = Orderitem::with('orderitemable')
            ->select(DB::raw('sum(count) as sum, orderitemable_id, orderitemable_type'))
            ->groupBy('orderitemable_id', 'orderitemable_type')
            ->latest()
            ->take(10)
            ->get();

        $newestProducts = $newestProducts->filter(function ($item) {
            // dd($item);
            if ($item->orderitemable == null) {
                return false;
            } else if ($item->orderitemable->visibility == 0) {
                return false;
            } else
                return true;
        });

        $allSermeh = Category::where('title', 'like', '%سرمه%')
            ->get();
        $sermehProducts = [];
        foreach ($allSermeh as $sermeh) {
            $products = $sermeh->model::where('category_id', $sermeh->id)
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
        foreach ($allCategories as $key => $category) {
            $count = 0;
            switch ($category->model) {
                case ('App\Tablecloth'):
                    $count += Tablecloth::where('visibility', 1)->count();
                    break;
                case ('App\Pillow'):
                    $count += Pillow::where('visibility', 1)->count();
                    break;
                case ('App\Prayermat'):
                    $count += Prayermat::where('visibility', 1)->count();
                    break;
                case ('App\Bedcover'):
                    $count += Bedcover::where('visibility', 1)->count();
                    break;
                case ('App\Shoe'):
                    $count += Shoe::where('visibility', 1)->count();
                    break;
            }
            $category['productsCount'] = $count;
        }

        $category = Category::where('title', 'رومیزی')
            ->where('parent_id', '0')
            ->where('active', 1)
            ->first();

        $tableclothsCategories = Category::where('parent_id', $category->id)
            ->where('active', 1)
            ->get();

        $specials = Price::with('priceable')
            ->select(DB::raw('*'))
            ->where('local', 'تومان')
            ->where('offPrice', '>', 0)
            ->get();
        // dd($specials);

        $specials = $specials->filter(function ($item) {
            // dd($item);
            if ($item->priceable == null) {
                return false;
            } else if ($item->priceable->visibility == 0) {
                return false;
            } else
                return true;
        });

        $slideshowImagesB = Slideshow::where('position', 'homeStore-B')
            ->orderby('order', 'asc')
            ->get();

        $slideshows = Slideshow::where('position', 'homeStore-A')
            ->where('visibility', 1)
            ->get();

        return view('shop.shop')
            ->with('topRequests', $topRequests)
            ->with('slideshowImagesB', $slideshowImagesB)
            ->with('tableclothsCategories', $tableclothsCategories)
            ->with('allCategories', $allCategories)
            ->with('sermehProducts', $sermehProducts)
            ->with('slideshows', $slideshows)
            ->with('newestProducts', $newestProducts)
            ->with('popups', $popups)
            ->with('agencies', $agencies)
            ->with('specials', $specials);
    }
    public function index3()
    {
        return 'hiii';
    }

    public function filter(Request $request)
    {
        // dd($request->all());
        $model = "App\\" . $request->model;
        $condition = $request->condition;
        $query = $model::where('visibility', 1)->get();
        return $query = $query->when($request->col, function ($query) use ($request) {
            $query->where($request->col, $request->value);
        });
    }

    public function about()
    {
        $agencies = Agency::with('city', 'state')->get();

        $grouped = $agencies->groupBy(function ($agency) {
            return optional($agency->state)->map_code;
        });

        $generations = Generation::all();

        $mission = MissionSection::first();

        $productAuthentication = ProductAuthenticitySection::first();

        $certificateSection = CertificateSection::first();
        return view('about', compact('agencies', 'grouped','generations','mission','productAuthentication','certificateSection'));
    }
}
