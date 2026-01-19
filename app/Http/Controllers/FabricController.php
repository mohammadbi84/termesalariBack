<?php

namespace App\Http\Controllers;

use App\Fabric;
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
use App\Http\Requests\FabricRequest;
use App\Http\Requests\FabricEditRequest;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Thumbnail;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class FabricController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show','storeIndex','storeFilter','ajaxStore');
        // $this->authorizeResource(Fabric::class, 'fabric');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Fabric::class);
        $fabrics = Fabric::all();
            // dd($fabrics);
        return view('fabric.index')
             ->with('fabrics',$fabrics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Fabric::class);
        $designs = Design::where('active',1)
            ->get();
        $categories = Category::where('parent_id',22)
            ->where('model','App\Fabric')
            ->where('active', 1)
            ->get();
        return view('fabric.create')
            ->with('categories',$categories)
            ->with('designs',$designs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FabricRequest $request)
    {
        // dd($request->all());
        $exist = Fabric::where("code",$request->code)->count();
        if($exist == 0){
            $design = Design::find($request->design_id);
            $color_design = ColorDesign::where('design_id',$request->design_id)
                ->where('color_id',$request->color_id)
                ->first();
            $fabric = Fabric::create($request->all());
            $fabric->category_id = $request->category_id;
            $fabric->color_design_id = $color_design->id;
            $fabric->save();
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

                        $price->priceable()->associate($fabric);
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
                    $img->imageable()->associate($fabric);
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

            return redirect()->route('fabric.index')
                ->with('success', 'درج محصول با موفقیت انجام شد');
        }//if
        else {
            return redirect()->route('fabric.index')
                ->with('danger', 'کد محصول تکراری می باشد');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function show(Fabric $fabric)
    {
        // $this->authorize('view');
        if($fabric->visibility == 1)
        {
            $comments = $fabric->comments()
                ->where("status",1)
                ->get();

            $grade = Grade::where("gradeable_id",$fabric->id)
                ->where("gradeable_type","App\\Fabric")
                ->avg('grade');
            $color_design = ColorDesign::find($fabric->color_design_id);
            $likeFabrics = Fabric::where('color_design_id',$fabric->color_design_id)
                // ->whereIn('design_color_id',$fabric->designColor->where('active' ,1)->pluck('id'))
                ->where('id','<>',$fabric->id)
                ->where('visibility',1)
                ->get();
                // dd($fabric,$likeFabrics);
            $title = $fabric->category->title;

            return view('fabric.show')
                ->with('fabric',$fabric)
                ->with('likeFabrics',$likeFabrics)
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
     * @param  \App\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function edit(Fabric $fabric)
    {
        $this->authorize('update', $fabric);
        $designs = Design::where('active',1)
            ->get();//تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($fabric->color_design_id);
        $colors = Color::whereIn('id',ColorDesign::where('design_id',$color_design->design_id)->pluck('color_id'))
            ->get();//رنگ بندی طرح انتخاابی کاربر

        $categories = Category::where('parent_id',22)
            ->where('model','App\Fabric')
            ->where('active', 1)
            ->get();

        return view('fabric.edit')
            ->with('fabric',$fabric)
            ->with('designs',$designs)
            ->with('categories',$categories)
            ->with('colors',$colors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function update(FabricEditRequest $request, Fabric $fabric)
    {
        // dd($request->all());
        // $request->validated();
        $design = Design::find($request->design_id);
        $color_design = ColorDesign::where('design_id',$request->design_id)
            ->where('color_id',$request->color_id)
            ->first();


        // $design = Design::find($request->design);

        $fabric->fill($request->all());
        // $fabric->design_id = $request->design_id;
        $fabric->color_design_id  = $color_design->id;
        $fabric->prices()->delete($request->price);
        $fabric->category_id = $request->category_id;

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

                    $price->priceable()->associate($fabric);
                    $price->save();

                }
            }
        }

        if(isset($request->images)){
            $lastOrdering = Image::where('imageable_id',$fabric->id)
                ->where('imageable_type','App\Fabric')
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
                $img->imageable()->associate($fabric);
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

        $fabric->save();



        return redirect()->route('fabric.index')
            ->with('success', '::ویرایش با موفقیت انجام شد ::');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Fabric::class);

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
        $this->authorize('changeVisibility',Fabric::class);

        $fabric = Fabric::find($request->id);
        if($fabric->visibility == 0){
            $fabric->visibility = 1;
        }
        else if($fabric->visibility == 1){
            $fabric->visibility = 0;
        }
        $fabric->save();

        $result["res"] = "success";
        $result["message"] = "مورد انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function changeVisibilityGroup(Request $request)
    {
        $this->authorize('changeVisibilityGroup',Fabric::class);
        $result = [];
        if(isset($request->items)){
            foreach($request->items as $id){
                $fabric = Fabric::find($id);
                if($fabric->visibility == 0)
                    $fabric->visibility = 1;
                else if ($fabric->visibility == 1)
                    $fabric->visibility = 0;
                $fabric->save();
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

        $fabrics = Fabric::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $fabrics->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }


        // *** فیلتر رنگ ***
        if ($request->colors) {
            $fabrics->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }


        // *** فیلتر دسته ***
        if ($request->categories) {
            $fabrics->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->quantity == 1) {
            $fabrics->where('quantity', '>', 0);
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $fabrics = $fabrics->get(); // ابتدا collection بگیر
                $fabrics = $fabrics->sortByDesc(function ($fabric) {
                    return $fabric->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $fabrics = $fabrics->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $fabrics = $fabrics->get()->sortBy(function ($fabric) {
                    $price = $fabric->prices->where("local", "تومان")->first();
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
                $fabrics = $fabrics->get()->sortByDesc(function ($fabric) {
                    $price = $fabric->prices->where("local", "تومان")->first();
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
                $fabrics = $fabrics->get()->sortByDesc(function ($fabric) {
                    $price = $fabric->prices->where("local", "تومان")->first();
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
                $fabrics = $fabrics->get()->sortByDesc(function ($fabric) {
                    return $fabric->grades->sum('grade');
                });
                break;

            default:
                $fabrics = $fabrics->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $fabrics = $fabrics->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $fabrics->forPage($page, $perPage);

        $fabrics = new LengthAwarePaginator(
            $items,
            $fabrics->count(),
            $perPage,
            $page,
            [
                'path' => route('fabric.storeIndex'),
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
            ->where('model', 'App\Fabric')
            ->where('active', 1)
            ->get();

        $slideshows = Slideshow::where('position', 'homeStore-A')
            ->where('visibility', 1)
            ->get();

        return view('fabric.store-index2')
            ->with('fabrics', $fabrics)
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

        $fabrics = Fabric::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $fabrics->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }

        // *** فیلتر رنگ ***
        if ($request->colors) {
            $fabrics->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }

        // *** فیلتر باکس جستجو ***
        if ($request->filled('search')) {
            $search = trim($request->search);
            $fabrics->where(function ($q) use ($search) {
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
            $fabrics->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->stock == 1) {
            $fabrics->where('quantity', '>', 0);
        }

        // *** فیلتر فقط تخفیف دار ها ***
        if ($request->onlyOffer == 1) {
            $fabrics->whereHas('prices', function ($q) {
                $q->where('local', 'تومان')
                    ->where('offPrice', '>', 0);
            });
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $fabrics = $fabrics->get(); // ابتدا collection بگیر
                $fabrics = $fabrics->sortByDesc(function ($fabric) {
                    return $fabric->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $fabrics = $fabrics->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $fabrics = $fabrics->get()->sortBy(function ($fabric) {
                    $price = $fabric->prices->where("local", "تومان")->first();
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
                $fabrics = $fabrics->get()->sortByDesc(function ($fabric) {
                    $price = $fabric->prices->where("local", "تومان")->first();
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
                $fabrics = $fabrics->get()->sortByDesc(function ($fabric) {
                    $price = $fabric->prices->where("local", "تومان")->first();
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
                $fabrics = $fabrics->get()->sortByDesc(function ($fabric) {
                    return $fabric->grades->sum('grade');
                });
                break;

            default:
                $fabrics = $fabrics->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $fabrics = $fabrics->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $fabrics->forPage($page, $perPage);

        $fabrics = new LengthAwarePaginator(
            $items,
            $fabrics->count(),
            $perPage,
            $page,
            [
                'path' => route('fabric.storeIndex'),
                'query' => request()->query() // این جایگزین withQueryString میشه
            ]
        );

        return response()->json([
            'html' => view('fabric.partials.products', compact('fabrics'))->render(),
            'pagination' => (string) $fabrics->links()
        ]);
    }

    public function storeFilter(Request $request)
    {
        $designs_id = Design::where('active',1)
            ->pluck('id');

        $color_designs_id = ColorDesign::whereIn('design_id',$designs_id)
            ->pluck('id');

        $fabrics = Fabric::filter($request)
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

        // dd( Fabric::filter($request)->toSql());
        switch ($request->sort) {
            case 'topSales':
                $fabrics = $fabrics->sortByDesc(function ($fabric, $key) {
                        $count = 0;
                        foreach ($fabric->orderitems as $orderitem) {
                            $count = $count + $orderitem->count;
                        }
                        return $count;
                    });
                    // dd(1);
                break;

            case 'lastDate':
                    $fabrics = $fabrics->sortByDesc('created_at');
                    // dd(2);
                break;

            case 'priceAsc':
                    $fabrics = $fabrics->sortByDesc(function ($fabric, $key) {
                        $prices = $fabric->prices->where("local","تومان")->first();
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
                    $fabrics = $fabrics->sortBy(function ($fabric, $key) {
                        $prices = $fabric->prices->where("local","تومان")->first();
                        if($prices->offPrice > 0){
                            if($prices->offType == 'مبلغ')
                                return $prices->price - $prices->offPrice;
                            elseif($prices->offType == 'درصد')
                                return $prices->price - ($prices->price * ($prices->offPrice/100));
                        }
                        else
                            return $prices->price;
                    });
                    // dd($fabrics);
                break;

            case 'topOffer':
                    $fabrics = $fabrics->sortByDesc(function ($fabric, $key) {
                            $p = $fabric->prices->where("local","تومان")->first();
                            $off = 0;
                            if($p->offPrice > 0)
                            {
                              if($p->offType == 'مبلغ')
                                $off = $p->offPrice;

                              elseif($p->offType == 'درصد')
                                $off = $p->price * ($p->offPrice/100);
                            }
                            return $off;
                        })->sortBy(function ($fabric, $key) {
                            return $fabric->prices->where("local","تومان")->first()->price;
                        });
                    // dd(5);
                break;

            case 'topRate':
                    $fabrics = $fabrics->sortByDesc(function ($fabric, $key) {
                            $sum = 0;
                            foreach ($fabric->grades as $grade) {
                                $sum = $sum + $grade->grade;
                            }
                            return $sum;
                            });
                    // dd(6);
                break;

            default:
                    $fabrics = $fabrics->sortByDesc('created_at');
                break;
        }

        // dd($fabrics);

        if($request->expectsJson())
            return view('fabric.store-filter')
                ->with('fabrics',$fabrics);

        $designs = Design::where('active','1')->get();
        $colors = Color::all();
        $minPrices = Price::where("local","تومان")->min('price');
        $maxPrices = Price::where("local","تومان")->max('price');
        // $types = Fabric::select('type')->DISTINCT()->get();
        $categories = Category::where('parent_id',22)
            ->where('model','App\Fabric')
            ->where('active', 1)
            ->get();

        return view('fabric.store-index')
            ->with('fabrics',$fabrics)
            ->with('designs',$designs)
            ->with('colors',$colors)
            ->with('minPrices',$minPrices)
            ->with('maxPrices',$maxPrices)
            ->with('categories',$categories);
    }

    public function duplicate(Fabric $fabric)
    {
        $this->authorize('duplicate', $fabric);

        $designs = Design::where('active',1)
            ->get();//تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($fabric->color_design_id);
        $colors = Color::whereIn('id',ColorDesign::where('design_id',$color_design->design_id)->pluck('color_id'))
            ->get();//رنگ بندی طرح انتخاابی کاربر
        $categories = Category::where('parent_id',22)
            ->where('model','App\Fabric')
            ->where('active', 1)
            ->get();
        return view('fabric.duplicate')
            ->with('fabric',$fabric)
            ->with('designs',$designs)
            ->with('categories',$categories)
            ->with('colors',$colors);
    }


}//END
