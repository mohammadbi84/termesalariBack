<?php

namespace App\Http\Controllers;

use App\Design;
use App\Color;
use App\ColorDesign;
// use App\DesignColor;
use App\Tablecloth;
use App\Bedcover;
use App\Fabric;
use App\Prayermat;
use App\Pillow;
use App\Frame;

use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Design::class, 'design');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designs = Design::orderby('created_at','desc')
            ->get();
        return view('design.index')
            ->with('designs',$designs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('design.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
           'title' => 'required|string',
           'countOfColor' => 'required|numeric',
           'active' => 'required|numeric' ,
        ];
        $request->validate($rules);
        $design = new Design;

        $design->fill($request->all());
        // $design->countOfColor = $request->countOfColor . " رنگ";
        $design->save();
        return redirect()->route('design.index')
            ->with('success','عملیات با موفقیت انجام شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design)
    {
        return view('design.edit')
            ->with('design',$design);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Design $design)
    {
        $rules = [
           'title' => 'required|string|unique:designs,title,'. $design->id ,
           'countOfColor' => 'required|numeric',
           'active' => 'required|numeric' ,
        ];
        $request->validate($rules);

        $design->fill($request->all());
        // $design->countOfColor = $request->countOfColor . " رنگ";
        $design->save();
        return redirect()->route('design.index')
            ->with('success','طرح انتخابی با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design)
    {
        $color_design = ColorDesign::where('design_id',$design->id)
            ->first();

        $countTablecloth = Tablecloth::where('color_design_id',$color_design->id)->count();

        $countBedcover = Bedcover::where('color_design_id',$color_design->id)->count();

        $countFabric = Fabric::where('color_design_id',$color_design->id)->count();

        $countPrayermat = Prayermat::where('color_design_id',$color_design->id)->count();

        $countPillow = Pillow::where('color_design_id',$color_design->id)->count();

        $countFrame = Frame::where('color_design_id',$color_design->id)->count();

        $message = "امکان حذف این طرح وجود ندارد. از این طرح در  محصولات ";
        $msgFlag = 0;
        if($countTablecloth > 0){
            $message .= " :: رومیزی :: ";
            $msgFlag = 1;
        }
        if($countBedcover > 0){
            $message .= " :: روتختی :: ";
            $msgFlag = 1;
        }
        if($countFabric > 0){
            $message .= " :: پارچه :: ";
            $msgFlag = 1;
        }
        if($countPrayermat > 0){
            $message .= " :: سجاده :: ";
            $msgFlag = 1;
        }
        if($countPillow > 0){
            $message .= " :: پشتی :: ";
            $msgFlag = 1;
        }
        if($countFrame > 0){
            $message .= " :: قاب :: ";
            $msgFlag = 1;
        }
        $message .= " استفاده شده است.";

        if($msgFlag == 1)
        {
            $result["res"] = "error";
            $result["message"] = $message;
            return $result;
        }
        elseif($msgFlag == 0)
        {
            $design->colors()->detach();
            $design->delete();
            $result["res"] = "success";
            $result["message"] = "طرح انتخابی با موفقیت حذف شد.";
            return $result;
        }
    }

    public function changeActive(Request $request)
    {
        $this->authorize('changeActive',Design::class);
        $design = Design::find($request->id);
        $result["message"] = "";
        if($design->active == 0){
            $design->active = 1;
            $result["message"] = "طرح  انتخابی  فعال شد.";
        }
        else if($design->active == 1){
            $design->active = 0;
            $result["message"] = "طرح  انتخابی  غیرفعال شد.";
        }
        $design->save();
        
        $result["res"] = "success";
        return $result;
    }

    public function listOfColors(Design $design)
    {
        $colors = Color::all();
        return view('design.list_of_colors')
            ->with('colors',$colors)
            ->with('design',$design);
    }

    // public function designColor_changeActive(Request $request)
    // {
    //     $this->authorize('designColor_changeActive',Design::class);
    //     $designColor = DesignColor::find($request->id);
    //     $result["message"] = "";
    //     if($designColor->active == 0){
    //         $designColor->active = 1;
    //         $result["message"] = "رنگ  انتخابی  فعال شد.";
    //     }
    //     else if($designColor->active == 1){
    //         $designColor->active = 0;
    //         $result["message"] = "رنگ  انتخابی  غیرفعال شد.";
    //     }
    //     $designColor->save();
        
    //     $result["res"] = "success";
    //     return $result;
    // }

    public function designColor_delete(Request $request)
    {
        // dd($request->all());
        $this->authorize('designColor_delete',Design::class);
        // $design = Design::find($request->designID);
        // $color = Color::find($request->colorID);
        // $color = $design->colors->where('id',$request->colorID);
        $color_design = ColorDesign::where('color_id',$request->colorID)
            ->where('design_id',$request->designID)
            ->first();
        // dd($color_design->id);
        $countTablecloth = Tablecloth::where('color_design_id',$color_design->id)->count();
        // dd($countTablecloth);
        $countBedcover = Bedcover::where('color_design_id',$color_design->id)->count();
        $countFabric = Fabric::where('color_design_id',$color_design->id)->count();
        $countPrayermat = Prayermat::where('color_design_id',$color_design->id)->count();
        $countPillow = Pillow::where('color_design_id',$color_design->id)->count();
        $countFrame = Frame::where('color_design_id',$color_design->id)->count();
        $message = "امکان حذف این رنگ وجود ندارد. از این رنگ در  محصولات ";
        $msgFlag = 0;
        if($countTablecloth > 0){
            $message .= " :: رومیزی :: ";
            $msgFlag = 1;
        }
        if($countBedcover > 0){
            $message .= " :: روتختی :: ";
            $msgFlag = 1;
        }
        if($countFabric > 0){
            $message .= " :: پارچه :: ";
            $msgFlag = 1;
        }
        if($countPrayermat > 0){
            $message .= " :: سجاده :: ";
            $msgFlag = 1;
        }
        if($countPillow > 0){
            $message .= " :: پشتی :: ";
            $msgFlag = 1;
        }
        if($countFrame > 0){
            $message .= " :: قاب :: ";
            $msgFlag = 1;
        }
        $message .= " استفاده شده است.";

        if($msgFlag == 1)
        {
            $result["res"] = "error";
            $result["message"] = $message;
            return $result;
        }
        elseif($msgFlag == 0)
        {
            $color_design->delete();
            $result["res"] = "success";
            $result["message"] = "رنگ انتخابی با موفقیت حذف شد..";
            return $result;
        }
    }
    public function designColor_store(Request $request)
    {
        $this->authorize('designColor_store',Design::class);
        // dd($request->all());
        $colors = $request->colors;
        $design = Design::find($request->design_id);
        // dd($design);
        // foreach ($colors as $color) {
            $design->colors()->syncWithoutDetaching($colors);

        // }
        $result["res"] = "success";
        return $result;
        // $count = DesignColor::where('color',$request->color)
        //     ->where('design_id', $request->design_id)
        //     ->count();
        // if($count == 0)
        // {
        //     $designColor = new DesignColor;
        //     $designColor->color = $request->color;
        //     $designColor->active = $request->active;
        //     $designColor->design_id = $request->design_id;
        //     $designColor->save();
        //     $result["res"] = "success";
        // }
        // elseif($count > 0)
        // {
        //     $result["res"] = "error";
        //     $result["message"] = "اطلاعات این رنگ قبلا ثبت شده است.";
        // }
        // return $result;
    }

    
}//End
