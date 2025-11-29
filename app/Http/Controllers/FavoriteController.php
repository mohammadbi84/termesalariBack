<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Favorite::class, 'favorite');
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
        // $result = [];
        // if (Auth::check())
        // {
        //     $class="App\\".$request->model;
        //     $exist = Favorite::where('favoriteable_id',$request->id)
        //         ->where('favoriteable_type',$class)
        //         ->where('user_id',Auth::id())
        //         ->count();
        //     // dd($exist);
        //     if($exist == 0){
        //         $user_id = Auth::id();

        //         $favorite = new Favorite;
        //         $favorite->user_id = $user_id;
        //         $favorite->favoriteable_id = $request->id;
        //         $favorite->favoriteable_type= $class;
        //         $favorite->save();
        //         $result["res"] = "success";
        //         $result["message"] = "این محصول به لیست علاقه مندی های شما اضافه گردید.";
        //     }
        //     else
        //     {
        //         $result["res"] = "error";
        //         $result["message"] = "این محصول در لیست  علاقه مندی های شما وجود دارد.";
        //     }
        // }
        // else
        // {
        //     $result["res"] = "error";
        //     $result["message"] = "لطفا برای انجام این عملیات ابتدا با نام کاربری وارد سایت شوید.";
        // }
        // return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }

    public function addFavorite(Request $request)
    {
        $result = [];
        if (Auth::check())
        {
            $class="App\\".$request->model;
            $exist = Favorite::where('favoriteable_id',$request->id)
                ->where('favoriteable_type',$class)
                ->where('user_id',Auth::id())
                ->count();
            // dd($exist);
            if($exist == 0){
                $user_id = Auth::id();

                $favorite = new Favorite;
                $favorite->user_id = $user_id;
                $favorite->favoriteable_id = $request->id;
                $favorite->favoriteable_type= $class;
                $favorite->save();
                $result["res"] = "success";
                $result["message"] = "این محصول به لیست علاقه مندی های شما اضافه گردید.";
            }
            else
            {
                $result["res"] = "error";
                $result["message"] = "این محصول در لیست  علاقه مندی های شما وجود دارد.";
            }
        }
        else
        {
            $result["res"] = "error";
            $result["message"] = "لطفا برای انجام این عملیات ابتدا با نام کاربری وارد سایت شوید.";
        }
        return $result;
    }

    public function removeFavorite(Request $request)
    {
        $this->authorize('removeFavorite', Favorite::class);
        $favorite = Favorite::find($request->id);
        if (!$favorite) {
            $favorite = Favorite::where('favoriteable_id', $request->id)
                ->where('favoriteable_type', 'App\\' . $request->model)
                ->where('user_id', Auth::id())
                ->first();
        }
        $favorite->delete();
        $result["res"] = "success";
        $result["message"] = "این محصول با موفقیت از لیست علاقه مندی شما حذف شد.";
        return $result;

    }
}
