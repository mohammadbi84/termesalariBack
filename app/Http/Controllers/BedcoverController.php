<?php

namespace App\Http\Controllers;

use App\Bedcover;
use App\Design;
use App\Color;
use App\ColorDesign;
use App\Image;
use App\Comment;
use App\Grade;
use App\Favorite;
use App\Price;
use App\Category;
use App\Orderitem;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Requests\BedcoverRequest;
use App\Http\Requests\BedcoverEditRequest;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Thumbnail;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class BedcoverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show','storeIndex','storeFilter','ajaxStore');
        // $this->authorizeResource(Bedcover::class, 'bedcover');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Bedcover::class);
        $bedcovers = Bedcover::all();
            // dd($bedcovers);
        return view('bedcover.index')
             ->with('bedcovers',$bedcovers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Bedcover::class);
        $designs = Design::where('active',1)
            ->get();
        $categories = Category::where('parent_id',13)
            ->where('model','App\Bedcover')
            ->where('active', 1)
            ->get();
        return view('bedcover.create')
            ->with('categories',$categories)
            ->with('designs',$designs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BedcoverRequest $request)
    {
        // dd($request->all());
        $exist = Bedcover::where("code",$request->code)->count();
        if($exist == 0){
            $design = Design::find($request->design_id);
            $color_design = ColorDesign::where('design_id',$request->design_id)
                ->where('color_id',$request->color_id)
                ->first();
            $bedcover = Bedcover::create($request->all());
            $bedcover->category_id = $request->category_id;
            $bedcover->color_design_id = $color_design->id;
            $bedcover->save();
            // dd($request->all());
            if(isset($request->price)){

                foreach($request->price as $key=>$p)
                {
                    if(isset($p))
                    {
                    	$price = new Price;
                        $price->price = $p;

                        if(isset($request->local[$key]))
                        	$price->local = $request->local[$key];

                    	if(isset($request->offType[$key]))
                        	$price->offType = $request->offType[$key];

                        if(isset($request->offPrice[$key]))
                        	$price->offPrice = $request->offPrice[$key];

                        $price->priceable()->associate($bedcover);
                        $price->save();

                    }
                }
            }

            if(isset($request->images)){
                $path='';
                foreach($request->images as $order=>$image){
                    $path = $image->store('public/images/');
                    // dd(basename($path));
                    $img = new Image;
                    $img->name = basename($path);
                    $img->imageable()->associate($bedcover);
                    $img->ordering = $order++;
                    $img->save();
                    Thumbnail::make($image->getRealPath())
                        ->resize(260,260, null,  function ($constraint) {
                            $constraint->aspectRatio();
                            // $constraint->upsize();
                            })
                        ->save('storage/images/thumbnails/'.basename($path));
                }
            }

            return redirect()->route('bedcover.index')
                ->with('success', 'درج محصول با موفقیت انجام شد');
        }//if
        else {
            return redirect()->route('bedcover.index')
                ->with('danger', 'کد محصول تکراری می باشد');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bedcover  $bedcover
     * @return \Illuminate\Http\Response
     */
    public function show(Bedcover $bedcover)
    {
        // $this->authorize('view');
        if($bedcover->visibility == 1)
        {
            $comments = $bedcover->comments()
                ->where("status",1)
                ->get();

            $grade = Grade::where("gradeable_id",$bedcover->id)
                ->where("gradeable_type","App\\Bedcover")
                ->avg('grade');
            $color_design = ColorDesign::find($bedcover->color_design_id);
            $likeBedcovers = Bedcover::where('color_design_id',$bedcover->color_design_id)
                // ->whereIn('design_color_id',$bedcover->designColor->where('active' ,1)->pluck('id'))
                ->where('id','<>',$bedcover->id)
                ->where('visibility',1)
                ->get();
                // dd($bedcover,$likeBedcovers);
            $title = $bedcover->category->title;

            return view('bedcover.new.show')
                ->with('bedcover',$bedcover)
                ->with('likeBedcovers',$likeBedcovers)
                ->with('comments',$comments)
                ->with('title',$title)
                ->with('grade',$grade);
        }//if
        else
            return response(view('errors.404'), 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bedcover  $bedcover
     * @return \Illuminate\Http\Response
     */
    public function edit(Bedcover $bedcover)
    {
        $this->authorize('update', $bedcover);
        $designs = Design::where('active',1)
            ->get();//تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($bedcover->color_design_id);
        $colors = Color::whereIn('id',ColorDesign::where('design_id',$color_design->design_id)->pluck('color_id'))
            ->get();//رنگ بندی طرح انتخاابی کاربر

        $categories = Category::where('parent_id',13)
            ->where('model','App\Bedcover')
            ->where('active', 1)
            ->get();

        return view('bedcover.edit')
            ->with('bedcover',$bedcover)
            ->with('designs',$designs)
            ->with('categories',$categories)
            ->with('colors',$colors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bedcover  $bedcover
     * @return \Illuminate\Http\Response
     */
    public function update(BedcoverEditRequest $request, Bedcover $bedcover)
    {
        // dd($request->all());
        // $request->validated();
        $design = Design::find($request->design_id);
        $color_design = ColorDesign::where('design_id',$request->design_id)
            ->where('color_id',$request->color_id)
            ->first();


        // $design = Design::find($request->design);

        $bedcover->fill($request->all());
        // $bedcover->design_id = $request->design_id;
        $bedcover->color_design_id  = $color_design->id;
        $bedcover->prices()->delete($request->price);
        $bedcover->category_id = $request->category_id;

        if(isset($request->price)){

            foreach($request->price as $key=>$p)
            {
                if(isset($p))
                {
                    $price = new Price;
                    $price->price = $p;

                    if(isset($request->local[$key]))
                        $price->local = $request->local[$key];

                    if(isset($request->offType[$key]))
                        $price->offType = $request->offType[$key];

                    if(isset($request->offPrice[$key]))
                        $price->offPrice = $request->offPrice[$key];

                    $price->priceable()->associate($bedcover);
                    $price->save();

                }
            }
        }

        if(isset($request->images)){
            $lastOrdering = Image::where('imageable_id',$bedcover->id)
                ->where('imageable_type','App\Bedcover')
                ->orderby('ordering','desc')
                ->first();
            if(!isset($lastOrdering))
                $lastOrdering = 0;
            else
                $lastOrdering = $lastOrdering->ordering;
            foreach($request->images as $image){
                $lastOrdering++;
                $path = $image->store('public/images/');
                $img = new Image();
                $img->name = basename($path);
                $img->imageable()->associate($bedcover);
                $img->ordering = $lastOrdering;
                $img->save();

                Thumbnail::make($image->getRealPath())
                    ->resize(260,260, null,  function ($constraint) {
                        $constraint->aspectRatio();
                        // $constraint->upsize();
                        })
                    ->save('storage/images/thumbnails/'.basename($path));
            }
        }

        $bedcover->save();



        return redirect()->route('bedcover.index')
            ->with('success', '::ویرایش با موفقیت انجام شد ::');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bedcover  $bedcover
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Bedcover::class);

        $class = "App\\".$request->model;
        $product = $class::find($request->id);

        $orderitems = $product->orderitems()->get();

        $favorites = $product->favorites()->get();

        $comments = $product->comments()->get();
        $msg = "درخواست شما برای حذف پذیرفته نشد.این محصول در بخش ";
        $delFlag = 0;
        if($comments->count() > 0)
        {
            $msg .= " ::نظرات::  ";
            $delFlag = 1;
        }
        if($favorites->count() > 0)
        {
            $msg .= " ::علاقه مندی ها:: ";
            $delFlag = 1;
        }
        if($orderitems->count() > 0)
        {
            $msg .= " ::سفارش ها:: ";
            $delFlag = 1;
        }
        $msg .= "وجود دارد.";

        if($delFlag == 1)
        {
            $result["res"] = "error";
            $result["message"] = $msg;
            return $result;
        }
        else if($delFlag == 0)
        {

            $product->images()->delete();

            $product->grades()->delete();

            $product->prices()->delete();

            $product->delete();

            $result["res"] = "success";
            $result["message"] = "محصول انتخابی با موفقیت حذف شد.";
            return $result;
        }

    }

    public function changeVisibility(Request $request)
    {
        $this->authorize('changeVisibility',Bedcover::class);

        $bedcover = Bedcover::find($request->id);
        if($bedcover->visibility == 0){
            $bedcover->visibility = 1;
        }
        else if($bedcover->visibility == 1){
            $bedcover->visibility = 0;
        }
        $bedcover->save();

        $result["res"] = "success";
        $result["message"] = "مورد انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function changeVisibilityGroup(Request $request)
    {
        $this->authorize('changeVisibilityGroup',Bedcover::class);
        $result = [];
        if(isset($request->items)){
            foreach($request->items as $id){
                $bedcover = Bedcover::find($id);
                if($bedcover->visibility == 0)
                    $bedcover->visibility = 1;
                else if ($bedcover->visibility == 1)
                    $bedcover->visibility = 0;
                $bedcover->save();
            }
            $result["res"] = "success";
            $result["message"] = "موارد انتخابی با موفقیت تغییر وضعیت یافت .";
        }
        else
        {
            $result["res"] = "error";
            $result["message"] = "لطفا ابتداسطرهای مورد نظر را انتخاب کنید.";
        }
        return $result;
    }

    public function storeIndex(Request $request)
    {
        $designs_id = Design::where('active', 1)->pluck('id');
        $color_designs_id = ColorDesign::whereIn('design_id', $designs_id)->pluck('id');

        $bedcovers = Bedcover::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $bedcovers->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }


        // *** فیلتر رنگ ***
        if ($request->colors) {
            $bedcovers->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }


        // *** فیلتر دسته ***
        if ($request->categories) {
            $bedcovers->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->quantity == 1) {
            $bedcovers->where('quantity', '>', 0);
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $bedcovers = $bedcovers->get(); // ابتدا collection بگیر
                $bedcovers = $bedcovers->sortByDesc(function ($bedcover) {
                    return $bedcover->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $bedcovers = $bedcovers->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $bedcovers = $bedcovers->get()->sortBy(function ($bedcover) {
                    $price = $bedcover->prices->where("local", "تومان")->first();
                    if (!$price) return 0;

                    if ($price->offPrice > 0) {
                        if ($price->offType == 'مبلغ')
                            return $price->price - $price->offPrice;
                        elseif ($price->offType == 'درصد')
                            return $price->price - ($price->price * ($price->offPrice / 100));
                    }
                    return $price->price;
                });
                break;

            case 'expensive':
                $bedcovers = $bedcovers->get()->sortByDesc(function ($bedcover) {
                    $price = $bedcover->prices->where("local", "تومان")->first();
                    if (!$price) return 0;

                    if ($price->offPrice > 0) {
                        if ($price->offType == 'مبلغ')
                            return $price->price - $price->offPrice;
                        elseif ($price->offType == 'درصد')
                            return $price->price - ($price->price * ($price->offPrice / 100));
                    }
                    return $price->price;
                });
                break;

            case 'topOffer':
                $bedcovers = $bedcovers->get()->sortByDesc(function ($bedcover) {
                    $price = $bedcover->prices->where("local", "تومان")->first();
                    if (!$price) return 0;

                    $off = 0;
                    if ($price->offPrice > 0) {
                        if ($price->offType == 'مبلغ') $off = $price->offPrice;
                        elseif ($price->offType == 'درصد') $off = $price->price * ($price->offPrice / 100);
                    }
                    return $off;
                });
                break;

            case 'popular':
                $bedcovers = $bedcovers->get()->sortByDesc(function ($bedcover) {
                    return $bedcover->grades->sum('grade');
                });
                break;

            default:
                $bedcovers = $bedcovers->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $bedcovers = $bedcovers->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $bedcovers->forPage($page, $perPage);

        $bedcovers = new LengthAwarePaginator(
            $items,
            $bedcovers->count(),
            $perPage,
            $page,
            [
                'path' => route('bedcover.storeIndex'),
                'query' => request()->query() // این جایگزین withQueryString میشه
            ]
        );

        $designs = collect();
        $colors = collect();
        $list_color_designs = ColorDesign::with('color', 'design')
            ->whereIn('design_id', $designs_id)
            ->get();
        foreach ($list_color_designs as $item) {
            $designs->push($item->design);
            $colors->push($item->color);
        }


        $designs = $designs->unique('id');
        $colors = $colors->unique('id');

        $minPrices = $request->minPrice ?? Price::where("local", "تومان")->min('price');
        $maxPrices = $request->maxPrice ?? Price::where("local", "تومان")->max('price');
        $categories = Category::where('parent_id', 1)
            ->where('model', 'App\Bedcover')
            ->where('active', 1)
            ->get();

        $slideshows = Slideshow::where('position', 'homeStore-A')
            ->where('visibility', 1)
            ->get();

        return view('bedcover.store-index2')
            ->with('bedcovers', $bedcovers)
            ->with('designs', $designs)
            ->with('colors', $colors)
            ->with('slideshows', $slideshows)
            ->with('minPrices', $minPrices)
            ->with('maxPrices', $maxPrices)
            ->with('categories', $categories);
    }
    public function ajaxStore(Request $request)
    {
        $designs_id = Design::where('active', 1)->pluck('id');
        $color_designs_id = ColorDesign::whereIn('design_id', $designs_id)->pluck('id');

        $bedcovers = Bedcover::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $bedcovers->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }

        // *** فیلتر رنگ ***
        if ($request->colors) {
            $bedcovers->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }

        // *** فیلتر باکس جستجو ***
        if ($request->filled('search')) {
            $search = trim($request->search);
            $bedcovers->where(function ($q) use ($search) {
                // دسته‌بندی
                $q->whereHas('category', function ($q2) use ($search) {
                    $q2->where('title', 'LIKE', "%{$search}%");
                })
                    // طرح
                    ->orWhereHas('color_design.design', function ($q2) use ($search) {
                        $q2->where('title', 'LIKE', "%{$search}%");
                    })
                    // رنگ
                    ->orWhereHas('color_design.color', function ($q2) use ($search) {
                        $q2->where('color', 'LIKE', "%{$search}%");
                    });
            });
        }

        // *** فیلتر دسته ***
        if ($request->categories) {
            $bedcovers->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->stock == 1) {
            $bedcovers->where('quantity', '>', 0);
        }

        // *** فیلتر فقط تخفیف دار ها ***
        if ($request->onlyOffer == 1) {
            $bedcovers->whereHas('prices', function ($q) {
                $q->where('local', 'تومان')
                    ->where('offPrice', '>', 0);
            });
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $bedcovers = $bedcovers->get(); // ابتدا collection بگیر
                $bedcovers = $bedcovers->sortByDesc(function ($bedcover) {
                    return $bedcover->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $bedcovers = $bedcovers->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $bedcovers = $bedcovers->get()->sortBy(function ($bedcover) {
                    $price = $bedcover->prices->where("local", "تومان")->first();
                    if (!$price) return 0;

                    if ($price->offPrice > 0) {
                        if ($price->offType == 'مبلغ')
                            return $price->price - $price->offPrice;
                        elseif ($price->offType == 'درصد')
                            return $price->price - ($price->price * ($price->offPrice / 100));
                    }
                    return $price->price;
                });
                break;

            case 'expensive':
                $bedcovers = $bedcovers->get()->sortByDesc(function ($bedcover) {
                    $price = $bedcover->prices->where("local", "تومان")->first();
                    if (!$price) return 0;

                    if ($price->offPrice > 0) {
                        if ($price->offType == 'مبلغ')
                            return $price->price - $price->offPrice;
                        elseif ($price->offType == 'درصد')
                            return $price->price - ($price->price * ($price->offPrice / 100));
                    }
                    return $price->price;
                });
                break;

            case 'topOffer':
                $bedcovers = $bedcovers->get()->sortByDesc(function ($bedcover) {
                    $price = $bedcover->prices->where("local", "تومان")->first();
                    if (!$price) return 0;

                    $off = 0;
                    if ($price->offPrice > 0) {
                        if ($price->offType == 'مبلغ') $off = $price->offPrice;
                        elseif ($price->offType == 'درصد') $off = $price->price * ($price->offPrice / 100);
                    }
                    return $off;
                });
                break;

            case 'popular':
                $bedcovers = $bedcovers->get()->sortByDesc(function ($bedcover) {
                    return $bedcover->grades->sum('grade');
                });
                break;

            default:
                $bedcovers = $bedcovers->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $bedcovers = $bedcovers->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $bedcovers->forPage($page, $perPage);

        $bedcovers = new LengthAwarePaginator(
            $items,
            $bedcovers->count(),
            $perPage,
            $page,
            [
                'path' => route('bedcover.storeIndex'),
                'query' => request()->query() // این جایگزین withQueryString میشه
            ]
        );

        return response()->json([
            'html' => view('bedcover.partials.products', compact('bedcovers'))->render(),
            'pagination' => (string) $bedcovers->links()
        ]);
    }

    public function storeFilter(Request $request)
    {
        $designs_id = Design::where('active',1)
            ->pluck('id');

        $color_designs_id = ColorDesign::whereIn('design_id',$designs_id)
            ->pluck('id');

        $bedcovers = Bedcover::filter($request)
            ->whereIn('color_design_id',$color_designs_id)
            ->where('visibility',1)
            ->paginate(15);

        $designs = collect();
        $colors = collect();

        $list_color_designs = ColorDesign::with('color','design')
            ->whereIn('design_id',$designs_id)
            ->get();

        foreach ($list_color_designs as $item) {
            $designs->push($item->design);
            $colors->push($item->color);
        }

        $designs = $designs->unique('id');
        $colors = $colors->unique('id');


        // dd( Bedcover::filter($request)->toSql());
        switch ($request->sort) {
            case 'topSales':
                $bedcovers = $bedcovers->sortByDesc(function ($bedcover, $key) {
                        $count = 0;
                        foreach ($bedcover->orderitems as $orderitem) {
                            $count = $count + $orderitem->count;
                        }
                        return $count;
                    });
                    // dd(1);
                break;

            case 'lastDate':
                    $bedcovers = $bedcovers->sortByDesc('created_at');
                    // dd(2);
                break;

            case 'priceAsc':
                    $bedcovers = $bedcovers->sortByDesc(function ($bedcover, $key) {
                        $prices = $bedcover->prices->where("local","تومان")->first();
                        if($prices->offPrice > 0){
                            if($prices->offType == 'مبلغ')
                                return $prices->price - $prices->offPrice;
                            elseif($prices->offType == 'درصد')
                                return $prices->price - ($prices->price * ($prices->offPrice/100));
                        }
                        else
                            return $prices->price;
                    });
                    // dd(3);
                break;

            case 'priceDesc':
                    $bedcovers = $bedcovers->sortBy(function ($bedcover, $key) {
                        $prices = $bedcover->prices->where("local","تومان")->first();
                        if($prices->offPrice > 0){
                            if($prices->offType == 'مبلغ')
                                return $prices->price - $prices->offPrice;
                            elseif($prices->offType == 'درصد')
                                return $prices->price - ($prices->price * ($prices->offPrice/100));
                        }
                        else
                            return $prices->price;
                    });
                    // dd($bedcovers);
                break;

            case 'topOffer':
                    $bedcovers = $bedcovers->sortByDesc(function ($bedcover, $key) {
                            $p = $bedcover->prices->where("local","تومان")->first();
                            $off = 0;
                            if($p->offPrice > 0)
                            {
                              if($p->offType == 'مبلغ')
                                $off = $p->offPrice;

                              elseif($p->offType == 'درصد')
                                $off = $p->price * ($p->offPrice/100);
                            }
                            return $off;
                        })->sortBy(function ($bedcover, $key) {
                            return $bedcover->prices->where("local","تومان")->first()->price;
                        });
                    // dd(5);
                break;

            case 'topRate':
                    $bedcovers = $bedcovers->sortByDesc(function ($bedcover, $key) {
                            $sum = 0;
                            foreach ($bedcover->grades as $grade) {
                                $sum = $sum + $grade->grade;
                            }
                            return $sum;
                            });
                    // dd(6);
                break;

            default:
                    $bedcovers = $bedcovers->sortByDesc('created_at');
                break;
        }

        // dd($bedcovers);

        if($request->expectsJson())
            return view('bedcover.store-filter')
                ->with('bedcovers',$bedcovers);

        $designs = Design::where('active','1')->get();
        $colors = Color::all();
        $minPrices = Price::where("local","تومان")->min('price');
        $maxPrices = Price::where("local","تومان")->max('price');
        // $types = Bedcover::select('type')->DISTINCT()->get();
        $categories = Category::where('parent_id',13)
            ->where('model','App\Bedcover')
            ->where('active', 1)
            ->get();

        return view('bedcover.store-index')
            ->with('bedcovers',$bedcovers)
            ->with('designs',$designs)
            ->with('colors',$colors)
            ->with('minPrices',$minPrices)
            ->with('maxPrices',$maxPrices)
            ->with('categories',$categories);
    }

    public function duplicate(Bedcover $bedcover)
    {
        $this->authorize('duplicate', $bedcover);

        $designs = Design::where('active',1)
            ->get();//تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($bedcover->color_design_id);
        $colors = Color::whereIn('id',ColorDesign::where('design_id',$color_design->design_id)->pluck('color_id'))
            ->get();//رنگ بندی طرح انتخاابی کاربر
        $categories = Category::where('parent_id',13)
            ->where('model','App\Bedcover')
            ->where('active', 1)
            ->get();
        return view('bedcover.duplicate')
            ->with('bedcover',$bedcover)
            ->with('designs',$designs)
            ->with('categories',$categories)
            ->with('colors',$colors);
    }


}//END
