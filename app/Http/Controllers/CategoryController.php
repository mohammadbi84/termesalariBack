<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Intervention\Image\ImageManagerStatic as Thumbnail;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Category::class, 'category');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $data = ['topCat'=>[],'subCat'=>[[]]];
        foreach ($categories as $key => $category) {
            if($category->parent_id == 0)
                $data['topCat'][$key] = $category;
            elseif($category->parent_id != 0)
                $data['subCat'][$category->parent_id][$key] = $category;
        }
        // dd($data);
        return view('category.index')
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Category::where('parent_id',0)
            ->where('active', 1)
            ->get();
        return view('category.create')
            ->with('products',$products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // dd($request->all());
        $path = $request->image->store('public/images/categories/');
        Thumbnail::make($request->image->getRealPath())
            ->resize(400, null,  function ($constraint) {
                $constraint->aspectRatio();
                })
            ->save('storage/images/categories/thumbnails/'.basename($path));

        $parent = Category::find($request->parent_id);
        $category = new Category;
        $category->fill($request->all());
        $category->model = $parent->model;
        $category->link = "/store/tablecloths/filter?category[]=";
        $category->image = basename($path);
        $category->save();
        return redirect()->route('category.index')
                ->with('success', 'درج دسته بندی محصول با موفقیت انجام شد');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
         $productCategories = Category::where('parent_id',0)
            ->where('active', 1)
            ->get();
        return view('category.edit')
            ->with('productCategories',$productCategories)
            ->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // dd($category);
        $rules = [
            'title' => 'required|string' ,
            // 'image' => 'required|image|mimes:jpeg,png,jpg',
            'parent_id' => 'required|numeric',
            'active' => 'required|numeric',
        ];
        $request->validate($rules);

        
        if(isset($request->image))
        {
            $file1 = '/public/images/categories/'.$category->image;
            $file2 = '/public/images/categories/thumbnails/'.$category->image;
            Storage::delete($file1 , $file2);

            $path = $request->image->store('public/images/categories/');
            Thumbnail::make($request->image->getRealPath())
                ->resize(400, null,  function ($constraint) {
                    $constraint->aspectRatio();
                    })
                ->save('storage/images/categories/thumbnails/'.basename($path));
            $category->image = basename($path);
        }
        
        $parent = Category::find($request->parent_id);
        // $category->fill($request->all());
        $category->parent_id = $parent->id;
        $category->model = $parent->model;
        $category->link = "/store/tablecloths/filter?category[]=";
        $category->title = $request->title;
        $category->active = $request->active;
        $category->save();
        return redirect()->back()
                ->with('success', 'ویرایش دسته بندی محصول با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
       

        $count = $category->model::where('category_id',$category->id)
            ->count();
        if($count > 0)
        {
            $result["res"] = "error";
            $result["message"] = "در این دسته بندی محصولی ثبت شده است . امکان حذف آن وجود ندارد.";
            return $result;
        }
        else
        {
            $file1 = '/public/images/categories/'.$category->image;
            $file2 = '/public/images/categories/thumbnails/'.$category->image;
            Storage::delete($file1,$file2);
            $category->delete();

            $result["res"] = "success";
            $result["message"] = "دسته بندی انتخابی با موفقیت حذف شد..";
            return $result;
        }
    }

    public function changeActive(Request $request)
    {
        $this->authorize('changeActive',Category::class);
        $category = Category::find($request->id);
        $result["message"] = "";
        if($category->active == 0){
            $category->active = 1;
            $result["message"] = "دسته بندی انتخابی  فعال شد.";
        }
        else if($category->active == 1){
            $category->active = 0;
            $result["message"] = "دسته بندی انتخابی  غیرفعال شد.";
        }
        $category->save();
        
        $result["res"] = "success";
        return $result;
    }
}
