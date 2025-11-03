<?php

namespace App\Http\Controllers;

use App\Recipient;
use App\City;
use App\Subcity;
use App\User;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Requests\RecipientRequest;
use Auth;

class RecipientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Recipient::class, 'recipient');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipients = Recipient::all();
        // dd($recipients);
        return view('recipient.index')
            ->with('recipients',$recipients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user = User::find(Auth::id());
        $recipient = new Recipient;
        $recipient->fill($request->all());
        $recipient->nationalCode = $request->nationalCode;
        $recipient->city_id = $request->city_id;
        $recipient->subcity_id = $request->subcity_id;
        $recipient->user_id = Auth::id();
        $recipient->save();
        return redirect()->route('cart.cartlevel2')
                ->with('newRecipient', $recipient);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipient  $recipient
     * @return \Illuminate\Http\Response
     */
    public function show(Recipient $recipient)
    {
        $orders = Order::where('recipient_id',$recipient->id)
            ->get();

        return view('recipient.show')
            ->with('recipient',$recipient)
            ->with('orders',$orders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipient  $recipient
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipient $recipient)
    {
        $cities = City::all();
        $subcities = Subcity::where('city_id',$recipient->city_id)
            ->orderBy("name","asc")
            ->get();
        return view('recipient.edit')
            ->with('recipient',$recipient)
            ->with('cities',$cities)
            ->with('subcities',$subcities);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipient  $recipient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipient $recipient)
    {
        $recipient->fill($request->all());
        $recipient->city_id = $request->city_id;
        $recipient->subcity_id = $request->subcity_id;
        $recipient->save();
        $recipients = Recipient::all();
        return redirect()->route('user.recipients')
            ->with('recipients',$recipients);
        //return url()->previous();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipient  $recipient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipient $recipient)
    {
        $recipient->visibility = 0;
        $recipient->save();
        $result["res"] = "success";
        $result["message"] = "گزینه انتخابی با موفقیت حدف شد .";
        return $result;
    }

    public function selectSubcity(Request $request){
        $res = [
            'results' => []
        ];
        $subcities = Subcity::where('city_id',$request->id)
            ->orderBy("name","asc")
            ->get();
        foreach ($subcities as $subcity) {
            array_push($res['results'], ["id" => $subcity->id, "text" => $subcity->name]);
        }
        return $res;

    }
}
