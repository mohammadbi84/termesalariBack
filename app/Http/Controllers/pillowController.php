<?php

namespace App\Http\Controllers;

use App\Pillow;
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
use App\Http\Requests\PillowRequest;
use App\Http\Requests\PillowEditRequest;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Thumbnail;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PillowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show','storeIndex','storeFilter','ajaxStore');
        // $this->authorizeResource(Pillow::class, 'pillow');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(1111);
        $this->authorize('viewAny', Pillow::class);
        $pillows = Pillow::all();
            //dd($pillows);
        return view('pillow.index')
             ->with('pillows',$pillows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Pillow::class);
        $designs = Design::where('active',1)
            ->get();
        $categories = Category::where('parent_id',18)
            ->where('model','App\Pillow')
            ->where('active', 1)
            ->get();
        return view('pillow.create')
            ->with('categories',$categories)
            ->with('designs',$designs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PillowRequest $request)
    {
        // dd($request->all());
        $exist = Pillow::where("code",$request->code)->count();
        if($exist == 0){
            $design = Design::find($request->design_id);
            $color_design = ColorDesign::where('design_id',$request->design_id)
                ->where('color_id',$request->color_id)
                ->first();
            $pillow = Pillow::create($request->all());
            $pillow->category_id = $request->category_id;
            $pillow->color_design_id = $color_design->id;
            $pillow->save();
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

                        $price->priceable()->associate($pillow);
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
                    $img->imageable()->associate($pillow);
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

            return redirect()->route('pillow.index')
                ->with('success', 'درج محصول با موفقیت انجام شد');
        }//if
        else {
            return redirect()->route('pillow.index')
                ->with('danger', 'کد محصول تکراری می باشد');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pillow  $pillow
     * @return \Illuminate\Http\Response
     */
    public function show(Pillow $pillow)
    {
        // $this->authorize('view');
        if($pillow->visibility == 1)
        {
            $comments = $pillow->comments()
                ->where("status",1)
                ->get();

            $grade = Grade::where("gradeable_id",$pillow->id)
                ->where("gradeable_type","App\\Pillow")
                ->avg('grade');
            $color_design = ColorDesign::find($pillow->color_design_id);
            $likePillows = Pillow::where('color_design_id',$pillow->color_design_id)
                // ->whereIn('design_color_id',$pillow->designColor->where('active' ,1)->pluck('id'))
                ->where('id','<>',$pillow->id)
                ->where('visibility',1)
                ->get();
                // dd($pillow,$likePillows);
            $title = $pillow->category->title;

            return view('pillow.new.show')
                ->with('pillow',$pillow)
                ->with('likePillows',$likePillows)
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
     * @param  \App\Pillow  $pillow
     * @return \Illuminate\Http\Response
     */
    public function edit(Pillow $pillow)
    {
        $this->authorize('update', $pillow);
        $designs = Design::where('active',1)
            ->get();//تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($pillow->color_design_id);
        $colors = Color::whereIn('id',ColorDesign::where('design_id',$color_design->design_id)->pluck('color_id'))
            ->get();//رنگ بندی طرح انتخاابی کاربر

        $categories = Category::where('parent_id',18)
            ->where('model','App\Pillow')
            ->where('active', 1)
            ->get();

        return view('pillow.edit')
            ->with('pillow',$pillow)
            ->with('designs',$designs)
            ->with('categories',$categories)
            ->with('colors',$colors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pillow  $pillow
     * @return \Illuminate\Http\Response
     */
    public function update(PillowEditRequest $request, Pillow $pillow)
    {
        // dd($request->all());
        // $request->validated();
        $design = Design::find($request->design_id);
        $color_design = ColorDesign::where('design_id',$request->design_id)
            ->where('color_id',$request->color_id)
            ->first();


        // $design = Design::find($request->design);

        $pillow->fill($request->all());
        // $pillow->design_id = $request->design_id;
        $pillow->color_design_id  = $color_design->id;
        $pillow->prices()->delete($request->price);
        $pillow->category_id = $request->category_id;

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

                    $price->priceable()->associate($pillow);
                    $price->save();

                }
            }
        }

        if(isset($request->images)){
            $lastOrdering = Image::where('imageable_id',$pillow->id)
                ->where('imageable_type','App\Pillow')
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
                $img->imageable()->associate($pillow);
                $img->ordering = $lastOrdering;
                $img->save();

                Thumbnail::make($image->getRealPath())
                    ->resize(260,260, null,  function ($constraint) {
                        $constraint->aspectRatio();
                        })
                    ->save('storage/images/thumbnails/'.basename($path));
            }
        }

        $pillow->save();

        return redirect()->route('pillow.index')
            ->with('success', '::ویرایش با موفقیت انجام شد ::');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pillow  $pillow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Pillow::class);

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
        $this->authorize('changeVisibility',Pillow::class);

        $pillow = Pillow::find($request->id);
        if($pillow->visibility == 0){
            $pillow->visibility = 1;
        }
        else if($pillow->visibility == 1){
            $pillow->visibility = 0;
        }
        $pillow->save();

        $result["res"] = "success";
        $result["message"] = "مورد انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function changeVisibilityGroup(Request $request)
    {
        $this->authorize('changeVisibilityGroup',Pillow::class);
        $result = [];
        if(isset($request->items)){
            foreach($request->items as $id){
                $pillow = Pillow::find($id);
                if($pillow->visibility == 0)
                    $pillow->visibility = 1;
                else if ($pillow->visibility == 1)
                    $pillow->visibility = 0;
                $pillow->save();
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

        $pillows = Pillow::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $pillows->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }


        // *** فیلتر رنگ ***
        if ($request->colors) {
            $pillows->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }


        // *** فیلتر دسته ***
        if ($request->categories) {
            $pillows->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->quantity == 1) {
            $pillows->where('quantity', '>', 0);
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $pillows = $pillows->get(); // ابتدا collection بگیر
                $pillows = $pillows->sortByDesc(function ($pillow) {
                    return $pillow->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $pillows = $pillows->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $pillows = $pillows->get()->sortBy(function ($pillow) {
                    $price = $pillow->prices->where("local", "تومان")->first();
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
                $pillows = $pillows->get()->sortByDesc(function ($pillow) {
                    $price = $pillow->prices->where("local", "تومان")->first();
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
                $pillows = $pillows->get()->sortByDesc(function ($pillow) {
                    $price = $pillow->prices->where("local", "تومان")->first();
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
                $pillows = $pillows->get()->sortByDesc(function ($pillow) {
                    return $pillow->grades->sum('grade');
                });
                break;

            default:
                $pillows = $pillows->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $pillows = $pillows->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $pillows->forPage($page, $perPage);

        $pillows = new LengthAwarePaginator(
            $items,
            $pillows->count(),
            $perPage,
            $page,
            [
                'path' => route('pillow.storeIndex'),
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
            ->where('model', 'App\Pillow')
            ->where('active', 1)
            ->get();

        $slideshows = Slideshow::where('position', 'homeStore-A')
            ->where('visibility', 1)
            ->get();

        return view('pillow.store-index2')
            ->with('pillows', $pillows)
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

        $pillows = Pillow::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $pillows->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }

        // *** فیلتر رنگ ***
        if ($request->colors) {
            $pillows->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }

        // *** فیلتر باکس جستجو ***
        if ($request->filled('search')) {
            $search = trim($request->search);
            $pillows->where(function ($q) use ($search) {
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
            $pillows->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->stock == 1) {
            $pillows->where('quantity', '>', 0);
        }

        // *** فیلتر فقط تخفیف دار ها ***
        if ($request->onlyOffer == 1) {
            $pillows->whereHas('prices', function ($q) {
                $q->where('local', 'تومان')
                    ->where('offPrice', '>', 0);
            });
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $pillows = $pillows->get(); // ابتدا collection بگیر
                $pillows = $pillows->sortByDesc(function ($pillow) {
                    return $pillow->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $pillows = $pillows->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $pillows = $pillows->get()->sortBy(function ($pillow) {
                    $price = $pillow->prices->where("local", "تومان")->first();
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
                $pillows = $pillows->get()->sortByDesc(function ($pillow) {
                    $price = $pillow->prices->where("local", "تومان")->first();
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
                $pillows = $pillows->get()->sortByDesc(function ($pillow) {
                    $price = $pillow->prices->where("local", "تومان")->first();
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
                $pillows = $pillows->get()->sortByDesc(function ($pillow) {
                    return $pillow->grades->sum('grade');
                });
                break;

            default:
                $pillows = $pillows->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $pillows = $pillows->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $pillows->forPage($page, $perPage);

        $pillows = new LengthAwarePaginator(
            $items,
            $pillows->count(),
            $perPage,
            $page,
            [
                'path' => route('pillow.storeIndex'),
                'query' => request()->query() // این جایگزین withQueryString میشه
            ]
        );

        return response()->json([
            'html' => view('pillow.partials.products', compact('pillows'))->render(),
            'pagination' => (string) $pillows->links()
        ]);
    }

    public function storeFilter(Request $request)
    {
        $designs_id = Design::where('active',1)
            ->pluck('id');

        $color_designs_id = ColorDesign::whereIn('design_id',$designs_id)
            ->pluck('id');

        $pillows = Pillow::filter($request)
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

        // dd( Pillow::filter($request)->toSql());
        switch ($request->sort) {
            case 'topSales':
                $pillows = $pillows->sortByDesc(function ($pillow, $key) {
                        $count = 0;
                        foreach ($pillow->orderitems as $orderitem) {
                            $count = $count + $orderitem->count;
                        }
                        return $count;
                    });
                    // dd(1);
                break;

            case 'lastDate':
                    $pillows = $pillows->sortByDesc('created_at');
                    // dd(2);
                break;

            case 'priceAsc':
                    $pillows = $pillows->sortByDesc(function ($pillow, $key) {
                        $prices = $pillow->prices->where("local","تومان")->first();
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
                    $pillows = $pillows->sortBy(function ($pillow, $key) {
                        $prices = $pillow->prices->where("local","تومان")->first();
                        if($prices->offPrice > 0){
                            if($prices->offType == 'مبلغ')
                                return $prices->price - $prices->offPrice;
                            elseif($prices->offType == 'درصد')
                                return $prices->price - ($prices->price * ($prices->offPrice/100));
                        }
                        else
                            return $prices->price;
                    });
                    // dd($pillows);
                break;

            case 'topOffer':
                    $pillows = $pillows->sortByDesc(function ($pillow, $key) {
                            $p = $pillow->prices->where("local","تومان")->first();
                            $off = 0;
                            if($p->offPrice > 0)
                            {
                              if($p->offType == 'مبلغ')
                                $off = $p->offPrice;

                              elseif($p->offType == 'درصد')
                                $off = $p->price * ($p->offPrice/100);
                            }
                            return $off;
                        })->sortBy(function ($pillow, $key) {
                            return $pillow->prices->where("local","تومان")->first()->price;
                        });
                    // dd(5);
                break;

            case 'topRate':
                    $pillows = $pillows->sortByDesc(function ($pillow, $key) {
                            $sum = 0;
                            foreach ($pillow->grades as $grade) {
                                $sum = $sum + $grade->grade;
                            }
                            return $sum;
                            });
                    // dd(6);
                break;

            default:
                    $pillows = $pillows->sortByDesc('created_at');
                break;
        }

        // dd($pillows);

        if($request->expectsJson())
            return view('pillow.store-filter')
                ->with('pillows',$pillows);

        $designs = Design::where('active','1')->get();
        $colors = Color::all();
        $minPrices = Price::where("local","تومان")->min('price');
        $maxPrices = Price::where("local","تومان")->max('price');
        // $types = Pillow::select('type')->DISTINCT()->get();
        $categories = Category::where('parent_id',18)
            ->where('model','App\Pillow')
            ->where('active', 1)
            ->get();

        return view('pillow.store-index')
            ->with('pillows',$pillows)
            ->with('designs',$designs)
            ->with('colors',$colors)
            ->with('minPrices',$minPrices)
            ->with('maxPrices',$maxPrices)
            ->with('categories',$categories);
    }

    public function duplicate(Pillow $pillow)
    {
        $this->authorize('duplicate', $pillow);

        $designs = Design::where('active',1)
            ->get();//تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($pillow->color_design_id);
        $colors = Color::whereIn('id',ColorDesign::where('design_id',$color_design->design_id)->pluck('color_id'))
            ->get();//رنگ بندی طرح انتخاابی کاربر
        $categories = Category::where('parent_id',18)
            ->where('model','App\Pillow')
            ->where('active', 1)
            ->get();
        return view('pillow.duplicate')
            ->with('pillow',$pillow)
            ->with('designs',$designs)
            ->with('categories',$categories)
            ->with('colors',$colors);
    }


}//END
