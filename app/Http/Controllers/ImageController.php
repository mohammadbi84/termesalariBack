<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    public function delOneImage (Request $request)
    {
        // return $request->all();
        $class="App\\" . $request->model;
        $product = $class::find($request->id);
        $image = $product->images()
            ->where('id',$request->key)
            ->first();
        $order = $image->ordering;

        $file[0] = '/public/images/'.$image->name;
        $file[1] = '/public/images/thumbnails/'.$image->name;
        // dd($file);
        Storage::delete($file);
        $image->delete();

        //change ordering
        $otherImages = Image::where('imageable_id',$request->id)
            ->where('imageable_type',$class)
            ->where('id','<>',$image->id)
            ->where('ordering','>',$image->ordering)
            ->get();
        foreach ($otherImages as $key => $image) {
            $image->ordering = $image->ordering - 1;
            $image->save();
        }

        return response()->json("ok");
    }

    public function ordering(Request $request)
    {
        // dd($request->all());
        $newIndex = $request->newIndex;
        $oldIndex = $request->oldIndex;
        $newIndex++;//از صفر شروع میشه
        $oldIndex++;//از صفر شروع میشه
        $image1 = Image::find($request->id1);
        if ($newIndex > $oldIndex) {
            // dd(1);
            $otherImages = Image::where('imageable_id',$image1->imageable_id)
                ->where('imageable_type',$image1->imageable_type)
                ->where('id','<>',$image1->id)
                ->where('ordering','<=',$newIndex)
                ->where('ordering','>=',$oldIndex)
                ->get(); 
            // dd($otherImages);
            foreach ($otherImages as $image) {
                $image->ordering = $image->ordering - 1;
                $image->save();
            }
        }
        elseif ($newIndex < $oldIndex) {
            // dd(2);
            $otherImages= Image::where('imageable_id',$image1->imageable_id)
                ->where('imageable_type',$image1->imageable_type)
                ->where('id','<>',$image1->id)
                ->where('ordering','<=',$oldIndex)
                ->where('ordering','>=',$newIndex)
                ->get();
            foreach ($otherImages as $image) {
                $image->ordering = $image->ordering + 1;
                $image->save();
            }
        }
        $image1->ordering = $newIndex;
        $image1->save();
    }

    
}
