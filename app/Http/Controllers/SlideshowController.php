<?php

namespace App\Http\Controllers;

use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Requests\SlideshowRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SlideshowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Slideshow::class, 'slideshow');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slideshowImages = Slideshow::orderby('position','asc')
            ->orderby('order','asc')
            ->get();
        return view('slideshow.index')
            ->with('slideshowImages',$slideshowImages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slideshow.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideshowRequest $request)
    {
        // dd($request->all());
        $path = $request->image->store('public/images/slideshow/');
        if ($request->video) {
            $pathVideo = $request->video->store('public/videos/slideshow/');
        }
        $slideshow = new Slideshow;
        $slideshow->fill($request->all());
        $slideshow->image = "/slideshow/" . basename($path);
        if ($request->video) {
            $slideshow->video = "/slideshow/" . basename($pathVideo);
        }
        $slideshow->save();
        return redirect()
            ->back()
            ->with("success","::عملیات با موفقیت انجام شد.::");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function show(Slideshow $slideshow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function edit(Slideshow $slideshow)
    {
        return view('slideshow.edit')
            ->with('slideshow',$slideshow);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slideshow $slideshow)
    {
        // dd($request->all());
        // dd($slideshow->id);
        $rules = [
            'position' => 'required|string' ,
            'title' => 'required|string' ,
            'description' => 'nullable|string' ,
            'image' => 'image|mimes:jpeg,png,jpg',
            'link' => 'required|string' ,
            // 'order' => 'required|numeric|'.
            //     Rule::unique('slideshows')->ignore($slideshow->id)->where(function ($query) {
            //         return $query->where('position', $slideshow->position);
            //         // ->where('hostname', $hostname);
            //     }),

        ];
        $request->validate($rules);
        // dd($request->all());

        $count = Slideshow::where('position', $request->position)
            ->where('id',"<>",$slideshow->id)
            ->where('order',$request->order)
            ->count();
        // dd($count);
        if ($count > 0 ) {
            return redirect()
                ->back()
                ->with("danger","::ترتیب تصویر در موقعیت انتخابی تکراری می باشد.::");
        }

        if ($slideshow->position != $request->position) {

            $count = Slideshow::where('position', $slideshow->position)
                ->count();
            // dd($count);
            if ($count == 1) {
                return redirect()
                    ->back()
                    ->with("danger","::در موقعیت مورد نظر، حداقل یک تصویر باید موجود باشد.::");
            }
        }

        $slideshow->fill($request->all());

        if (isset($request->image)) {
            // dd($request->image);
            $file = '/public/images/'.$slideshow->image;
            Storage::delete($file);
            $path = $request->image->store('public/images/slideshow/');
            $slideshow->image = "/slideshow/" . basename($path);

        }

        // dd($slideshow);
        // $slideshow->position = $request->position;
        // $slideshow->title = $request->title;
        // $slideshow->description = $request->description;
        // $slideshow->link = $request->link;
        // $slideshow->order = $request->order;
        $slideshow->save();
// dd($slideshow);
        // unlink($file);
        return redirect()
            ->back()
            ->with("success","::عملیات با موفقیت انجام شد.::");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slideshow $slideshow)
    {
        $count = Slideshow::where('position',$slideshow->position)
            ->count();
        // dd($count);
        if ($count == 1) {
            return redirect()
            ->back()
            ->with("danger","::در اسلایدشو موقعیت مورد نظر حداقل یک تصویر باید موجود باشد.::");
        }
        else{
            $file = '/public/images/'.$slideshow->image;
            $slideshow->delete();
            Storage::delete($file);
            return redirect()
                ->back()
                ->with("success","::عملیات با موفقیت انجام شد.::");
        }

    }

    public function changeVisibility(Request $request)
    {
        $this->authorize('changeVisibility',Slideshow::class);

        $slideshow = Slideshow::find($request->id);
        if($slideshow->visibility == 0){
            $slideshow->visibility = 1;
        }
        else if($slideshow->visibility == 1){
            $slideshow->visibility = 0;
        }
        $slideshow->save();

        $result["res"] = "success";
        $result["message"] = "مورد انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function changeVisibilityGroup(Request $request)
    {
        $this->authorize('changeVisibilityGroup',Slideshow::class);
        $result = [];
        if(isset($request->items)){
            foreach($request->items as $id){
                $slideshow = Slideshow::find($id);
                if($slideshow->visibility == 0)
                    $slideshow->visibility = 1;
                else if ($slideshow->visibility == 1)
                    $slideshow->visibility = 0;
                $slideshow->save();
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
}
