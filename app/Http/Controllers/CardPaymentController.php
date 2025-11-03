<?php

namespace App\Http\Controllers;

use App\CardPayment;
use Illuminate\Http\Request;
use App\Http\Requests\CardPaymentRequest;
use Hekmatinasser\Verta\Verta;
use App\Post;
use App\Order;
use App\Orderitem;
use App\PaymentMethod;
use App\DiscountCard;
use Auth;
use Trez\RayganSms\Facades\RayganSms;
use Illuminate\Support\Facades\Mail;
use App\Mail\FactorMail;
use Carbon\Carbon;

class CardPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(CardPayment::class, 'cardPayment');
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
        return view('cardPayment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function convertPersianToEnglish($string) 
    // {
    //     $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    //     $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
    //     $output= str_replace($persian, $english, $string);
    //     return $output;
    // }

    public function store(CardPaymentRequest $request)
    {
        // dd(session()->all());
        $cart = session('cart');
        foreach ($cart as $productID => $value)
        {
            foreach ($value as $model=>$data) {
                $class="App\\".$model;
                $product = $class::find($productID);
                if ($product->quantity < $data['quantity'] ) {
                    return redirect()->route('cardPayment.create')
                        ->with("danger","محصول  ". $product->title ." طرح " . $product->color_design->design->title . " رنگ " . $product->color_design->color->color . " با کد " . $product->code . " موجودی کافی ندارد. لطفا تعداد  آن را در سبد خرید کاهش دهید و یا با پشتیبانی سایت تماس بگیرید.");
                }
            }
        }
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $date = str_replace($persian, $english, $request->date);
        $date = Verta::parse($date);
        $date = $date->dateTime();

        $cardPayment = new CardPayment;
        $cardPayment->tracing_code = $request->tracing_code;
        $cardPayment->date = $date;
        $cardPayment->price = $request->price_cardPay;
        $cardPayment->save();

        $recipient_id = session("recipient");
        $post_id = session("postType");
        $post = Post::find($post_id);
        $payment_method = session("payType");
        $payment_method_id = PaymentMethod::where('method',$payment_method)
            ->first()->id;
        $user_id = Auth::id();

        $order = new Order;
        $order->user_id = $user_id;
        $order->recipient_id = $recipient_id;
        $order->post_id = $post_id;
        $order->payment_method_id = $payment_method_id;
        $locale = config('app.locale');
        $localePrice = "";
        if($locale == 'fa')
            $localePrice = "تومان";
        $order->postPrice = $post->price;
        $order->local = $localePrice;
        $order->status = 0;
        $order->orderable()->associate($cardPayment);

        $count_code = 1;
        while ($count_code > 0) {
            $code = Carbon::now()->timestamp;
            $count_code = Order::where('code',$code)
            ->count();
        }
        $order->code = $code;
        if(session()->has("discountCardID"))
        {
            $discountCard = DiscountCard::find(session("discountCardID"));
            $discountCard->user_id = $user_id;
            $discountCard->save();
            $order->discount_card_id = $discountCard->id;
        }
        $order->save();

        foreach ($cart as $productID => $value)
        {
            $orderitem = new Orderitem;
            foreach ($value as $model=>$data) {
                $class="App\\".$model;
                $product = $class::find($productID);
                $p = $product->prices->where('local',$localePrice)->first();

                $off = 0;
                if($p->offPrice > 0)
                {
                  if($p->offType == 'مبلغ') 
                    $off = $p->offPrice;
                  elseif($p->offType == 'درصد')
                    $off = $p->price * ($p->offPrice/100);
                }
                $orderitem->order_id = $order->id;
                $orderitem->offPrice = $off;
                $orderitem->price = $p->price;
                $orderitem->count = $data['quantity'];
                $orderitem->orderitemable()->associate($product);    
            }
            $orderitem->save();

            $product->quantity = $product->quantity - $data['quantity'];
            $product->save();


        }

        RayganSms::sendMessage(Auth::user()->mobile, Auth::user()->name . " " . Auth::user()->family . " عزیز، با سپاس از اعتماد و خرید شما از فروشگاه ترمه سالاری،کد فاکتور شما ". $order->code ." میباشد.");

        if (isset(Auth::user()->email) and isset(Auth::user()->email_verified_at)) {
            Mail::to(Auth::user()->email)
              ->send(new FactorMail($order));
        }
        
        // session()->forget(['cart']);
        session()->flush();
        return redirect()->route('cart.factor');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\CardPayment  $cardPayment
     * @return \Illuminate\Http\Response
     */
    public function show(CardPayment $cardPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardPayment  $cardPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(CardPayment $cardPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardPayment  $cardPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardPayment $cardPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardPayment  $cardPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardPayment $cardPayment)
    {
        //
    }
}
