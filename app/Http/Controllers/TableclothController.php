<?php

namespace App\Http\Controllers;

use App\Tablecloth;
use App\Design;
use App\Color;
use App\ColorDesign;
// use App\Tag;
use App\Image;
use App\Comment;
use App\Grade;
use App\Favorite;
use App\Price;
use App\Category;
use App\Orderitem;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Requests\TableclothRequest;
use App\Http\Requests\TableclothEditRequest;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Thumbnail;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;


class TableclothController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'storeIndex', 'storeFilter', 'ajaxStore');
        // $this->authorizeResource(Tablecloth::class, 'tablecloth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Tablecloth::class);
        $tablecloths = Tablecloth::all();
        // dd($tablecloths);
        return view('tablecloth.index')
            ->with('tablecloths', $tablecloths);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Tablecloth::class);
        $designs = Design::where('active', 1)
            ->get();
        $categories = Category::where('parent_id', 1)
            ->where('model', 'App\Tablecloth')
            ->where('active', 1)
            ->get();
        return view('tablecloth.create')
            ->with('categories', $categories)
            ->with('designs', $designs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TableclothRequest $request)
    {
        // dd($request->all());
        $exist = Tablecloth::where("code", $request->code)->count();
        if ($exist == 0) {
            $design = Design::find($request->design_id);
            $color_design = ColorDesign::where('design_id', $request->design_id)
                ->where('color_id', $request->color_id)
                ->first();
            $tablecloth = Tablecloth::create($request->all());
            $tablecloth->category_id = $request->category_id;
            $tablecloth->color_design_id = $color_design->id;
            $tablecloth->save();
            // dd($request->all());
            if (isset($request->price)) {

                foreach ($request->price as $key => $p) {
                    if (isset($p)) {
                        $price = new Price;
                        $price->price = $p;

                        if (isset($request->local[$key]))
                            $price->local = $request->local[$key];

                        if (isset($request->offType[$key]))
                            $price->offType = $request->offType[$key];

                        if (isset($request->offPrice[$key]))
                            $price->offPrice = $request->offPrice[$key];

                        $price->priceable()->associate($tablecloth);
                        $price->save();
                    }
                }
            }

            if (isset($request->images)) {
                $path = '';
                foreach ($request->images as $order => $image) {
                    $path = $image->store('public/images/');
                    // dd(basename($path));
                    $img = new Image;
                    $img->name = basename($path);
                    $img->imageable()->associate($tablecloth);
                    $img->ordering = $order++;
                    $img->save();
                    Thumbnail::make($image->getRealPath())
                        ->resize(260, 260, null,  function ($constraint) {
                            $constraint->aspectRatio();
                            // $constraint->upsize();
                        })
                        ->save('storage/images/thumbnails/' . basename($path));
                }
            }

            // if(isset($request->tags)){
            //     foreach($request->tags as $value){
            //         $exist = Tag::where('name',$value)->count();
            //         if ($exist == 0){
            //             $tag = new Tag;
            //             $tag->name = $value;
            //             $tag->save();
            //         }
            //         $tablecloth->tags->attach($tag);
            //     }
            // }

            return redirect()->route('tablecloth.index')
                ->with('success', 'درج محصول با موفقیت انجام شد');
        } //if
        else {
            return redirect()->route('tablecloth.index')
                ->with('danger', 'کد محصول تکراری می باشد');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tablecloth  $tablecloth
     * @return \Illuminate\Http\Response
     */
    public function show(Tablecloth $tablecloth)
    {
        // $this->authorize('view');
        if ($tablecloth->visibility == 1) {
            $comments = $tablecloth->comments()
                ->where("status", 1)
                ->get();

            $grade = Grade::where("gradeable_id", $tablecloth->id)
                ->where("gradeable_type", "App\\Tablecloth")
                ->avg('grade');
            $color_design = ColorDesign::find($tablecloth->color_design_id);
            $likeTablecloths = Tablecloth::where('color_design_id', $tablecloth->color_design_id)
                // ->whereIn('design_color_id',$tablecloth->designColor->where('active' ,1)->pluck('id'))
                ->where('id', '<>', $tablecloth->id)
                ->where('visibility', 1)
                ->get();
            // dd($tablecloth,$likeTablecloths);
            $title = $tablecloth->category->title;

            return view('tablecloth.new.show')
                ->with('tablecloth', $tablecloth)
                ->with('likeTablecloths', $likeTablecloths)
                ->with('comments', $comments)
                ->with('title', $title)
                ->with('grade', $grade);
        } //if
        else
            return response(view('errors.404'), 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tablecloth  $tablecloth
     * @return \Illuminate\Http\Response
     */
    public function edit(Tablecloth $tablecloth)
    {
        $this->authorize('update', $tablecloth);
        $designs = Design::where('active', 1)
            ->get(); //تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($tablecloth->color_design_id);
        $colors = Color::whereIn('id', ColorDesign::where('design_id', $color_design->design_id)->pluck('color_id'))
            ->get(); //رنگ بندی طرح انتخاابی کاربر

        $categories = Category::where('parent_id', 1)
            ->where('model', 'App\Tablecloth')
            ->where('active', 1)
            ->get();

        return view('tablecloth.edit')
            ->with('tablecloth', $tablecloth)
            ->with('designs', $designs)
            ->with('categories', $categories)
            ->with('colors', $colors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tablecloth  $tablecloth
     * @return \Illuminate\Http\Response
     */
    public function update(TableclothEditRequest $request, Tablecloth $tablecloth)
    {
        $design = Design::find($request->design_id);
        $color_design = ColorDesign::where('design_id', $request->design_id)
            ->where('color_id', $request->color_id)
            ->first();

        $tablecloth->fill($request->all());
        $tablecloth->color_design_id  = $color_design->id;
        $tablecloth->prices()->delete($request->price);
        $tablecloth->category_id = $request->category_id;

        if (isset($request->price)) {

            foreach ($request->price as $key => $p) {
                if (isset($p)) {
                    $price = new Price;
                    $price->price = $p;

                    if (isset($request->local[$key]))
                        $price->local = $request->local[$key];

                    if (isset($request->offType[$key]))
                        $price->offType = $request->offType[$key];

                    if (isset($request->offPrice[$key]))
                        $price->offPrice = $request->offPrice[$key];

                    $price->priceable()->associate($tablecloth);
                    $price->save();
                }
            }
        }

        // if(isset($request->tags)){
        //     $tags = Tag::find($request->tags);

        //     foreach($request->tags as $t){
        //         $find = $tags->search(function($i, $v) use ($t){
        //             return $i->id == $t;
        //         });
        //         // dd($find);
        //        if( false === $find ){
        //         // dd($t);
        //         $newTag = Tag::create(['name' => $t]);
        //         $tags->push($newTag);
        //        }
        //     }

        //     $diff = $tablecloth->tags()->pluck('tags.id')->diff($tags->pluck('id'));
        //     $tablecloth->tags()->detach($diff);
        //     $diff = $tags->pluck('id')->diff($tablecloth->tags()->pluck('tags.id'));
        //     $tablecloth->tags()->attach($diff);
        // }

        $path = '';
        // $tablecloth->images()->detach();
        // $images = Image::where('imageable_id',$request->id)
        //                 ->where('imageable_type','App\Tablecloth')
        //                 ->get();
        // $tablecloth->images()->delete($images);
        if (isset($request->images)) {
            $lastOrdering = Image::where('imageable_id', $tablecloth->id)
                ->where('imageable_type', 'App\Tablecloth')
                ->orderby('ordering', 'desc')
                ->first();

            if (!isset($lastOrdering))
                $lastOrdering = 0;
            else
                $lastOrdering = $lastOrdering->ordering;
            foreach ($request->images as $image) {
                // $ordering = $lastOrdering++;
                $lastOrdering++;
                $path = $image->store('public/images/');
                $img = new Image();
                $img->name = basename($path);
                $img->imageable()->associate($tablecloth);
                $img->ordering = $lastOrdering;
                $img->save();
                // Thumbnail::make($image->getRealPath())->resize(260, null)->save('storage/images/thumbnails/'.basename($path));
                Thumbnail::make($image->getRealPath())
                    ->resize(260, 260, null,  function ($constraint) {
                        $constraint->aspectRatio();
                        // $constraint->upsize();
                    })
                    ->save('storage/images/thumbnails/' . basename($path));
            }
        }

        $tablecloth->save();



        return redirect()->route('tablecloth.index')
            ->with('success', '::ویرایش با موفقیت انجام شد ::');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tablecloth  $tablecloth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Tablecloth::class);

        $class = "App\\" . $request->model;
        $product = $class::find($request->id);

        $orderitems = $product->orderitems()->get();

        $favorites = $product->favorites()->get();

        $comments = $product->comments()->get();
        $msg = "درخواست شما برای حذف پذیرفته نشد.این محصول در بخش ";
        $delFlag = 0;
        if ($comments->count() > 0) {
            $msg .= " ::نظرات::  ";
            $delFlag = 1;
        }
        if ($favorites->count() > 0) {
            $msg .= " ::علاقه مندی ها:: ";
            $delFlag = 1;
        }
        if ($orderitems->count() > 0) {
            $msg .= " ::سفارش ها:: ";
            $delFlag = 1;
        }
        $msg .= "وجود دارد.";

        if ($delFlag == 1) {
            $result["res"] = "error";
            $result["message"] = $msg;
            return $result;
        } else if ($delFlag == 0) {
            // Detach Tags
            // $tags = $product->tags()->where('taggable_id',$request->id)
            //             ->where('taggable_type',$class)
            //             ->get();
            // $product->tags()->detach($tags);

            // Detach Images
            // $images = Image::where('imageable_id',$request->id)
            //                 ->where('imageable_type',$class)
            //                 ->get();
            $product->images()->delete();

            // Detach Grades
            // $grades = Grade::where('gradeable_id',$request->id)
            //             ->where('gradeable_type',$class)
            //             ->get();
            $product->grades()->delete();

            // Detach Prices
            // $prices = Price::where('priceable_id',$request->id)
            //             ->where('priceable_type',$class)
            //             ->get();
            $product->prices()->delete();

            $product->delete();

            $result["res"] = "success";
            $result["message"] = "محصول انتخابی با موفقیت حذف شد.";
            return $result;
        }



        // // Detach Favorites
        // $favorites = Favorite::where('favoriteable_id',$request->id)
        //             ->where('favoriteable_type',$class)
        //             ->get();
        // $product->favorites()->delete($favorites);

        // // Detach Comments
        // $comments = Comment::where('commentable_id',$request->id)
        //             ->where('commentable_type',$class)
        //             ->get();
        // $product->comments()->delete($comments);



        // $product->delete();

        // $result["res"] = "success";
        // $result["message"] = "محصول انتخابی به همراه سوابق مربوط به آن حذف شد.";
        // return $result;
    }

    public function changeVisibility(Request $request)
    {
        $this->authorize('changeVisibility', Tablecloth::class);

        $tablecloth = Tablecloth::find($request->id);
        if ($tablecloth->visibility == 0) {
            $tablecloth->visibility = 1;
        } else if ($tablecloth->visibility == 1) {
            $tablecloth->visibility = 0;
        }
        $tablecloth->save();

        $result["res"] = "success";
        $result["message"] = "مورد انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function changeVisibilityGroup(Request $request)
    {
        $this->authorize('changeVisibilityGroup', Tablecloth::class);
        $result = [];
        if (isset($request->items)) {
            foreach ($request->items as $id) {
                $tablecloth = Tablecloth::find($id);
                if ($tablecloth->visibility == 0)
                    $tablecloth->visibility = 1;
                else if ($tablecloth->visibility == 1)
                    $tablecloth->visibility = 0;
                $tablecloth->save();
            }
            $result["res"] = "success";
            $result["message"] = "موارد انتخابی با موفقیت تغییر وضعیت یافت .";
        } else {
            $result["res"] = "error";
            $result["message"] = "لطفا ابتداسطرهای مورد نظر را انتخاب کنید.";
        }
        return $result;
    }

    public function storeIndex(Request $request)
    {
        $designs_id = Design::where('active', 1)->pluck('id');
        $color_designs_id = ColorDesign::whereIn('design_id', $designs_id)->pluck('id');

        $tablecloths = Tablecloth::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $tablecloths->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }


        // *** فیلتر رنگ ***
        if ($request->colors) {
            $tablecloths->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }


        // *** فیلتر دسته ***
        if ($request->categories) {
            $tablecloths->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->quantity == 1) {
            $tablecloths->where('quantity', '>', 0);
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $tablecloths = $tablecloths->get(); // ابتدا collection بگیر
                $tablecloths = $tablecloths->sortByDesc(function ($tablecloth) {
                    return $tablecloth->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $tablecloths = $tablecloths->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $tablecloths = $tablecloths->get()->sortBy(function ($tablecloth) {
                    $price = $tablecloth->prices->where("local", "تومان")->first();
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
                $tablecloths = $tablecloths->get()->sortByDesc(function ($tablecloth) {
                    $price = $tablecloth->prices->where("local", "تومان")->first();
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
                $tablecloths = $tablecloths->get()->sortByDesc(function ($tablecloth) {
                    $price = $tablecloth->prices->where("local", "تومان")->first();
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
                $tablecloths = $tablecloths->get()->sortByDesc(function ($tablecloth) {
                    return $tablecloth->grades->sum('grade');
                });
                break;

            default:
                $tablecloths = $tablecloths->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $tablecloths = $tablecloths->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $tablecloths->forPage($page, $perPage);

        $tablecloths = new LengthAwarePaginator(
            $items,
            $tablecloths->count(),
            $perPage,
            $page,
            [
                'path' => route('tablecloth.storeIndex'),
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
            ->where('model', 'App\Tablecloth')
            ->where('active', 1)
            ->get();

        $slideshows = Slideshow::where('position', 'homeStore-A')
            ->where('visibility', 1)
            ->get();

        return view('tablecloth.store-index2')
            ->with('tablecloths', $tablecloths)
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

        $tablecloths = Tablecloth::whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->with([
                'color_design.design',
                'color_design.color'
            ]);


        // *** فیلتر طرح ***
        if ($request->designs) {
            $tablecloths->whereHas('color_design.design', function ($q) use ($request) {
                $q->whereIn('id', $request->designs);
            });
        }

        // *** فیلتر رنگ ***
        if ($request->colors) {
            $tablecloths->whereHas('color_design.color', function ($q) use ($request) {
                $q->whereIn('id', $request->colors);
            });
        }

        // *** فیلتر باکس جستجو ***
        if ($request->filled('search')) {
            $search = trim($request->search);
            $tablecloths->where(function ($q) use ($search) {
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
            $tablecloths->whereIn('category_id', $request->categories);
        }

        // *** فیلتر موجود بودن ***
        if ($request->stock == 1) {
            $tablecloths->where('quantity', '>', 0);
        }

        // *** فیلتر فقط تخفیف دار ها ***
        if ($request->onlyOffer == 1) {
            $tablecloths->whereHas('prices', function ($q) {
                $q->where('local', 'تومان')
                    ->where('offPrice', '>', 0);
            });
        }

        // *** مرتب‌سازی ***
        switch ($request->sort) {
            case 'topSales':
                $tablecloths = $tablecloths->get(); // ابتدا collection بگیر
                $tablecloths = $tablecloths->sortByDesc(function ($tablecloth) {
                    return $tablecloth->orderitems->sum('count'); // جمع فروش
                });
                break;

            case 'lastDate':
                $tablecloths = $tablecloths->orderByDesc('created_at')->get();
                break;

            case 'cheapest':
                $tablecloths = $tablecloths->get()->sortBy(function ($tablecloth) {
                    $price = $tablecloth->prices->where("local", "تومان")->first();
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
                $tablecloths = $tablecloths->get()->sortByDesc(function ($tablecloth) {
                    $price = $tablecloth->prices->where("local", "تومان")->first();
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
                $tablecloths = $tablecloths->get()->sortByDesc(function ($tablecloth) {
                    $price = $tablecloth->prices->where("local", "تومان")->first();
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
                $tablecloths = $tablecloths->get()->sortByDesc(function ($tablecloth) {
                    return $tablecloth->grades->sum('grade');
                });
                break;

            default:
                $tablecloths = $tablecloths->orderByDesc('created_at')->get();
                break;
        }
        if ($request->minPrice || $request->maxPrice) {
            $min = $request->minPrice ?? 0;
            $max = $request->maxPrice ?? PHP_INT_MAX;

            $tablecloths = $tablecloths->filter(function ($item) use ($min, $max) {
                $price = $this->finalPrice($item);
                return $price >= $min && $price <= $max;
            });
        }
        // بعد paginate collection (Laravel 7)
        $page = request()->get('page', 1);
        $perPage = 12;

        $items = $tablecloths->forPage($page, $perPage);

        $tablecloths = new LengthAwarePaginator(
            $items,
            $tablecloths->count(),
            $perPage,
            $page,
            [
                'path' => route('tablecloth.storeIndex'),
                'query' => request()->query() // این جایگزین withQueryString میشه
            ]
        );

        return response()->json([
            'html' => view('tablecloth.partials.products', compact('tablecloths'))->render(),
            'pagination' => (string) $tablecloths->links()
        ]);
    }


    private function finalPrice($tablecloth)
    {
        $price = $tablecloth->prices->where("local", "تومان")->first();

        if (!$price) return 0;

        if ($price->offPrice > 0) {
            if ($price->offType == 'مبلغ')
                return $price->price - $price->offPrice;

            elseif ($price->offType == 'درصد')
                return $price->price - ($price->price * ($price->offPrice / 100));
        }

        return $price->price;
    }

    public function storeFilter(Request $request)
    {
        $designs_id = Design::where('active', 1)
            ->pluck('id');

        $color_designs_id = ColorDesign::whereIn('design_id', $designs_id)
            ->pluck('id');

        $tablecloths = Tablecloth::filter($request)
            ->whereIn('color_design_id', $color_designs_id)
            ->where('visibility', 1)
            ->paginate(15);
        // dd($tablecloths);

        $designs = collect();
        $colors = collect();

        $list_color_designs = ColorDesign::with('color', 'design')
            ->whereIn('design_id', $designs_id)
            ->get();
        // dd($list_color_designs);
        foreach ($list_color_designs as $item) {
            // dd($item);
            $designs->push($item->design);
            $colors->push($item->color);
        }
        // dd($tablecloths);
        // $tablecloths = Tablecloth::filter($request)
        //     ->where('visibility',1)
        //     ->paginate(15);

        // $designs = collect();
        // $colors = collect();

        // $tablecloths = $tablecloths->filter(function($item) use ($designs,$colors){
        //     if ($item->visibility == 0) {
        //         return false;
        //     }
        //     if ($item->color_design->design->active == 1) {
        //         $designs->push($item->color_design->design);
        //         $colors->push($item->color_design->color);
        //         return true;
        //     }
        //     elseif ($item->color_design->design->active == 0) {
        //         return false;
        //     }
        // });
        $designs = $designs->unique('id');
        $colors = $colors->unique('id');


        // dd( Tablecloth::filter($request)->toSql());
        switch ($request->sort) {
            case 'topSales':
                $tablecloths = $tablecloths->sortByDesc(function ($tablecloth, $key) {
                    $count = 0;
                    foreach ($tablecloth->orderitems as $orderitem) {
                        $count = $count + $orderitem->count;
                    }
                    return $count;
                });
                // dd(1);
                break;

            case 'lastDate':
                $tablecloths = $tablecloths->sortByDesc('created_at');
                // dd(2);
                break;

            case 'priceAsc':
                $tablecloths = $tablecloths->sortByDesc(function ($tablecloth, $key) {
                    $prices = $tablecloth->prices->where("local", "تومان")->first();
                    if ($prices->offPrice > 0) {
                        if ($prices->offType == 'مبلغ')
                            return $prices->price - $prices->offPrice;
                        elseif ($prices->offType == 'درصد')
                            return $prices->price - ($prices->price * ($prices->offPrice / 100));
                    } else
                        return $prices->price;
                });
                // dd(3);
                break;

            case 'priceDesc':
                $tablecloths = $tablecloths->sortBy(function ($tablecloth, $key) {
                    // return $tablecloth->prices->where("local","تومان")->first()->price;
                    $prices = $tablecloth->prices->where("local", "تومان")->first();
                    if ($prices->offPrice > 0) {
                        if ($prices->offType == 'مبلغ')
                            return $prices->price - $prices->offPrice;
                        elseif ($prices->offType == 'درصد')
                            return $prices->price - ($prices->price * ($prices->offPrice / 100));
                    } else
                        return $prices->price;
                });
                // dd($tablecloths);
                break;

            case 'topOffer':
                $tablecloths = $tablecloths->sortByDesc(function ($tablecloth, $key) {
                    $p = $tablecloth->prices->where("local", "تومان")->first();
                    $off = 0;
                    if ($p->offPrice > 0) {
                        if ($p->offType == 'مبلغ')
                            $off = $p->offPrice;

                        elseif ($p->offType == 'درصد')
                            $off = $p->price * ($p->offPrice / 100);
                    }
                    return $off;
                })->sortBy(function ($tablecloth, $key) {
                    return $tablecloth->prices->where("local", "تومان")->first()->price;
                });
                // dd(5);
                break;

            case 'topRate':
                $tablecloths = $tablecloths->sortByDesc(function ($tablecloth, $key) {
                    $sum = 0;
                    foreach ($tablecloth->grades as $grade) {
                        $sum = $sum + $grade->grade;
                    }
                    return $sum;
                });
                // dd(6);
                break;

            default:
                $tablecloths = $tablecloths->sortByDesc('created_at');
                break;
        }

        // dd($tablecloths);

        if ($request->expectsJson())
            return view('tablecloth.store-filter')
                ->with('tablecloths', $tablecloths);

        $minPrices = Price::where("local", "تومان")->min('price');
        $maxPrices = Price::where("local", "تومان")->max('price');
        // $types = Tablecloth::select('type')->DISTINCT()->get();
        $categories = Category::where('parent_id', 1)
            ->where('model', 'App\Tablecloth')
            ->where('active', 1)
            ->get();

        return view('tablecloth.store-index')
            ->with('tablecloths', $tablecloths)
            ->with('designs', $designs)
            ->with('colors', $colors)
            ->with('minPrices', $minPrices)
            ->with('maxPrices', $maxPrices)
            ->with('categories', $categories);
    }

    public function duplicate(Tablecloth $tablecloth)
    {
        $this->authorize('duplicate', $tablecloth);

        $designs = Design::where('active', 1)
            ->get(); //تمامی طرح ها برای نمیش در منو
        $color_design = ColorDesign::find($tablecloth->color_design_id);
        $colors = Color::whereIn('id', ColorDesign::where('design_id', $color_design->design_id)->pluck('color_id'))
            ->get(); //رنگ بندی طرح انتخاابی کاربر
        $categories = Category::where('parent_id', 1)
            ->where('model', 'App\Tablecloth')
            ->where('active', 1)
            ->get();
        return view('tablecloth.duplicate')
            ->with('tablecloth', $tablecloth)
            ->with('designs', $designs)
            ->with('categories', $categories)
            ->with('colors', $colors);
    }
}
