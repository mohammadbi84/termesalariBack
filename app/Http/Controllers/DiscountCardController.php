<?php

namespace App\Http\Controllers;

use App\DiscountCard;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Requests\DiscountCardRequest;
use Hekmatinasser\Verta\Verta;

class DiscountCardController extends Controller
{
    public function __construct()
    {  
        $this->middleware('auth');
        $this->authorizeResource(DiscountCard::class, 'discountCard');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discountCards = DiscountCard::with('orders')
            ->orderby('created_at','desc')
            ->get();
        // dd($discountCards);
            return view('discountCard.index')
                ->with('discountCards', $discountCards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("discountCard.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountCardRequest $request)
    {
        // dd($request->all());
        if ($request->type_scope == 'public') {
            if ($request->count_usable == '') {
                return redirect()->back()
                ->with('danger', 'لظفا تعداد دفعات استفاده از کد تخفیف را وارد کنید.')->withInput();
            }
        }
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        date_default_timezone_set('Asia/Tehran');
        $start_date= str_replace($persian, $english, $request->start_date);
        $expire_date= str_replace($persian, $english, $request->expire_date);
        $start_date = Verta::parse($start_date);
        $expire_date = Verta::parse($expire_date);
        // dd("expire ".verta($expire_date),"start ".verta($start_date));
        // dd($expire_date->lte($start_date));
        if ($expire_date->lte($start_date)) {
            return redirect()->back()
                ->with('danger', 'تاریخ انقضا نباید برابر یا قبل از تاریخ شروع اعتبار باشد .')->withInput();
        }

        $start_date = $start_date->dateTime();
        $expire_date = $expire_date->dateTime();

        if($request->combination == 'alphanumeric')
            $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            // substr(sha1(time()), 0, $length_of_string);
        elseif($request->combination == 'numeric')
            $str = '0123456789'; 

        $i = 1;
        while ($i <= $request->count) {
            $code = substr(str_shuffle($str), 0, $request->length);
            $count = DiscountCard::where('code', $code)->count();
            if($count == 0)
            {
                $i++;
                $discountCard = new DiscountCard;
                $discountCard->code = $code;
                $discountCard->type_scope = $request->type_scope;
                $discountCard->type_amount = $request->type_amount;
                $discountCard->amount = $request->amount;
                $discountCard->start_date = $start_date;
                $discountCard->expire_date = $expire_date;
                if ($request->type_scope == 'private') {
                    $discountCard->count_usable = 1;
                }
                else
                    $discountCard->count_usable = $request->count_usable;
                $discountCard->save();
            }
        }

        return redirect()->route('discountCard.index')
                ->with('success', 'ایجاد '.($i - 1).' کد تخفیف با موفقیت انجام شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiscountCard  $discountCard
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountCard $discountCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscountCard  $discountCard
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountCard $discountCard)
    {
        return view('discountCard.edit')
            ->with('discountCard', $discountCard);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscountCard  $discountCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscountCard $discountCard)
    {
        // dd($request->all());
        $rules = [
            'code' => 'required|string|unique:discount_cards,code,'. $discountCard->id ,
            'type_amount' => 'required|string' ,
            'type_scope' => 'required|string' ,
            'count_usable' => 'nullable|numeric' ,
            'amount' => 'required|numeric' ,
            'start_date' => 'required|string' ,
            'expire_date' => 'required|string' ,
        ];
        $request->validate($rules);
        if ($request->type_scope == 'public') {
            if ($request->count_usable == '') {
                return redirect()->route('discountCard.create')
                ->with('danger', 'لظفا تعداد دفعات استفاده از کد تخفیف را وارد کنید.')->withInput();
            }
        }
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        date_default_timezone_set('Asia/Tehran');
        $start_date= str_replace($persian, $english, $request->start_date);
        $expire_date= str_replace($persian, $english, $request->expire_date);
        $start_date = Verta::parse($start_date);
        $expire_date = Verta::parse($expire_date);

        if ($expire_date->lte($start_date)) {
            return redirect()->route('discountCard.create')
                ->with('danger', 'تاریخ انقضا نباید برابر یا قبل از تاریخ شروع اعتبار باشد .')->withInput();
        }

        $start_date = $start_date->dateTime();
        $expire_date = $expire_date->dateTime();

        $discountCard->code = $request->code;
        $discountCard->type_scope = $request->type_scope;
        $discountCard->type_amount = $request->type_amount;
        $discountCard->amount = $request->amount;
        $discountCard->start_date = $start_date;
        $discountCard->expire_date = $expire_date;
        if ($request->type_scope == 'private') {
            $discountCard->count_usable = 1;
        }
        else
            $discountCard->count_usable = $request->count_usable;
        $discountCard->save() ;
        return redirect()->route('discountCard.index')
                ->with('success', 'عملیات ویرایش با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscountCard  $discountCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountCard $discountCard)
    {
        $order = Order::where('discount_card_id',$discountCard->id)
            ->get();


        if ($order->count() == 0 and $discountCard->is_gifted == 0) {
            $discountCard->delete();
            $result["res"] = "success";
            $result["message"] = "کد تخفیف انتخابی با موفقیت حدف شد .";
        }
        else if ($order->count() > 0)
        {
            $result["res"] = "error";
            $result["message"] = "از این کد تخفیف  استفاده شده است و قابل حذف نمی باشد .";
        }

        else if ($discountCard->is_gifted == 1)
        {
            $result["res"] = "error";
            $result["message"] = "این کد تخفیف هدیه شده است و قابل حذف نمی باشد .";
        }

        return $result;
    }

    public function deleteGroup(Request $request)
    {
        // dd($request->all());
        $this->authorize('deleteGroup', DiscountCard::class);
        $orders = Order::whereIn('discount_card_id',$request->items)
            ->pluck('discount_card_id');

        $discountCards = DiscountCard::whereIn('id',$request->items)
            ->get();

        $discountItems = "";
        $discountFlag = 0;

        $isGiftedFlag = 0;
        $isGiftedItems = "";
        foreach ($discountCards as $key=>$discountCard) {
            if(in_array($discountCard->id,$orders->all()))
            {
                $discountItems .= " ::". $discountCard->code .":: ";
                $discountFlag = 1;
            }
            if ($discountCard->is_gifted == 1) {
                $isGiftedItems .= " ::". $discountCard->code .":: ";
                $isGiftedFlag = 1;
            }
        }

        if($discountFlag == 1)
        {
            $result["res"] = "error";
            $result["message"] = "از کد تخفیف ".$discountItems."  استفاده شده است و قابل حذف نمی باشد . لطفا آنها را از انتخاب خارج کنید.";
        }
        if ($isGiftedFlag == 1){
            $result["res"] = "error";
            $result["message"] = "کد تخفیف ".$isGiftedItems."  هدیه شده است و قابل حذف نمی باشد . لطفا آنها را از انتخاب خارج کنید.";
        }

        if($discountFlag == 0 and $isGiftedFlag == 0)
        {
            DiscountCard::whereIn('id',$request->items)->delete();
            $result["res"] = "success";
            $result["message"] = "موارد انتخابی حذف شد.";
        }

        return $result;
        
    }

    public function changeIsGifted(Request $request)
    {
        $this->authorize('changeIsGifted',DiscountCard::class);

        $discountCard = DiscountCard::find($request->id);
        $order = Order::where('discount_card_id',$discountCard->id)
            ->get();
        if ($order->count() > 0) {
            $result["res"] = "error";
            $result["message"] = "از این کد تخفیف استفاده شده است و امکان تغییر آن وجود ندارد.";
            return $result;
        }
        if($discountCard->is_gifted == 0){
            $discountCard->is_gifted = 1;
        }
        else if($discountCard->is_gifted == 1){
            $discountCard->is_gifted = 0;
        }
        $discountCard->save();
        
        $result["res"] = "success";
        $result["message"] = "مورد انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function changeIsGiftedGroup(Request $request)
    {
        $this->authorize('changeIsGiftedGroup',DiscountCard::class);
        $result = [];
        $discountItems = "";
        $discountFlag = 0;
        if(isset($request->items)){
            foreach($request->items as $id){
                $discountCard = DiscountCard::find($id);
                $order = Order::where('discount_card_id',$discountCard->id)
                    ->get();
                if ($order->count() > 0) {
                    $discountItems .= " ::". $discountCard->code .":: ";
                    $discountFlag = 1;
                }
            }
            if ($discountFlag == 0) {
                foreach($request->items as $id){
                    $discountCard = DiscountCard::find($id);
                    if($discountCard->is_gifted == 0)
                        $discountCard->is_gifted = 1;
                    else if ($discountCard->is_gifted == 1)
                        $discountCard->is_gifted = 0;
                        $discountCard->save();
                }
                $result["res"] = "success";
                $result["message"] = "موارد انتخابی با موفقیت تغییر وضعیت یافت .";
            }
            elseif($discountFlag == 1)
            {
                $result["res"] = "error";
                $result["message"] = "ازکد تخفیف ".$discountItems." استفاده شده است و قابل تغییر نمی باشد . لطفا آنها را از انتخاب خارج کنید.";
            }
            
        }
        else
        {
            $result["res"] = "error";
            $result["message"] = "لطفا ابتداسطرهای مورد نظر را انتخاب کنید.";
        }
        return $result;
    }
}
