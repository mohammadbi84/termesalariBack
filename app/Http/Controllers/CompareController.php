<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompareController extends Controller
{
	public function index()
	{
		return view("compare.compare");
		// return view("compare.index");
	}

    public function add(Request $request)
    {
    	// dd($request->all());
        // dd(session('compares'));
    	$compares = [
            "product"=>[],
            "model"=>[]
        ];
    	$class = "App\\".$request->model;
        $product = $class::find($request->id);
        if(session()->has('compares'))
        	$compares = session('compares');
        $compares["product"][$request->id] = $product;
        $compares["model"][$request->id] = $request->model;
        // dd($compares);
        session()->put('compares', $compares);
        session()->save();
        return count($compares["product"]);
    	// session()->flush();

    }

    public function remove(Request $request)
    {
    	// dd($request->getRequestUri()=="/compare/remove");
        if(session()->has('compares')){
        	$compares = session('compares');
        	// dd($compares);
            unset($compares["product"][$request->id]);
	        unset($compares["model"][$request->id]);
        	// dd($compares);
	        session()->put('compares', $compares);
	        session()->save();
	        // dd(session('compares'));

	        // if($request->expectsJson())
        		return count($compares["product"]);
        	// else
        	// 	return redirect()->back();
        }

    }

}//End
