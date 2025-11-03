<?php

namespace App\Http\Controllers;

use App\Grade;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;

class GradeController extends Controller
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
        // dd($request->all(), $product, $model, $rate);
        $result = [];
        $product = $request->id;
        $model = $request->model;
        $rate = $request->value;
        if (Gate::allows('store-grade')) {
            if (Auth::check())
            {
                $userID = Auth::id();

                $class="App\\".$model;
                $product = $class::find($product);

                $grade = Grade::where([
                    ['user_id',$userID],
                     ['gradeable_id',$product->id],
                      ['gradeable_type',$class]
                ])->count();
                if($grade > 0){

                    $result["res"] = "error";
                    $result["message"] = "قبلا امتیاز شما برای این محصول به ثبت رسیده است.لطفا مجددا تلاش نفرمایید.";
                }
                else{
                    $grade = new Grade;
                    $grade->grade = $rate;
                    $grade->user_id = $userID;
                    $product->grades()->save($grade);
                    $result["res"] = "success";
                    $result["message"] = "باتشکر از شما کاربر عزیز";
                }
                
            }
        }
        else{   //Auth
            $result["res"] = "error";
            $result["message"] = "لطفا برای ثبت امتیاز ابتدا با نام کاربری وارد سایت شوید.";
             
        }
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        //
    }
}
