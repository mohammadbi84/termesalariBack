<?php

namespace App\Http\Controllers;

use App\Color;
use App\Design;
use App\ColorDesign;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Color::class, 'color');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $colors = Color::all()
            ->sortByDesc('created_at');
        return view('color.index')
            ->with('colors',$colors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('color.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $colors = $request->color;
            foreach ($colors as $value) {
                if(isset($value)){
                    $count = Color::where('color',$value)
                        ->get()->count();
                    if($count < 1){
                        $color = Color::create(['color' => $value]);
                        // $student->teachers()->attach(\App\Teacher::create($dataArray)->id); 
                    }
                }
                
            }
        return redirect()->route('color.index')
            ->with('success','عملیات با موفقیت انجام شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        return view('color.edit')
            ->with('color',$color);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color $color)
    {
        $rules = [
           'color' => 'required|string|unique:colors,color,'. $color->id ,
        ];
        $request->validate($rules);
        $color->fill($request->all());
        $color->save();
        return redirect()->route('color.index')
            ->with('success','رنگ انتخابی با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        // dd($color);
        $msg = "درخواست شما برای حذف این رنگ پذیرفته نشد. در طرح (های) ";
        $delFlag = 0;
        // dd($designs = count($color->designs));
        $designs = $color->designs;
        // dd($designs);
        if(count($designs) > 0)
        {
            foreach ($designs as $design) {
                $msg .= $design->title . " ";
            }
            $delFlag = 1;
        }

        if($delFlag == 1)
        {
            $msg .= " از این رنگ استفاده شده است.";
            $result["res"] = "error";
            $result["message"] = $msg;
            return $result;
        }
        else if($delFlag == 0)
        {       
            $color->delete();
            $result["res"] = "success";
            $result["message"] = "رنگ انتخابی با موفقیت حذف شد.";
            return $result;
        }
    }

    public function showColors(Request $request){
        $this->authorize('showColors', Color::class);
        $colorDesigns = ColorDesign::where('design_id',$request->id)
            ->get();
        $colors = collect();
        foreach ($colorDesigns as $colorDesign) {
            $colors->push($colorDesign->color);
        }
        // dd($colors);
        return $colors;
    }
}
