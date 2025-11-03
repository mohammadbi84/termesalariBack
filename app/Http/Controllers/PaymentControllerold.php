<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\CardPaymentRequest;
use Hekmatinasser\Verta\Verta;
use App\Post;
use App\Order;
use App\Orderitem;
use App\PaymentMethod;
use App\DiscountCard;
use App\User;
use Auth;
use Trez\RayganSms\Facades\RayganSms;
use Illuminate\Support\Facades\Mail;
use App\Mail\FactorMail;
use Carbon\Carbon;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('ok');
        $payments = Payment::with('order')
            ->orderby('date','desc')
            ->get();
        $payments = $payments->filter(function($item){
            // dd($item);
            if ($item->order == "") {
                return false;
            }
                return true;
        });
        // dd($payments);
        return view('payment.index')
            ->with('payments',$payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(session()->all());
        if(session()->has('cart'))
        {
            if(session()->has('payType') and session("payType") != "")
            {
                $cart = session('cart');

                foreach ($cart as $productID => $value)
                {
                    foreach ($value as $model=>$data) {
                        $class="App\\".$model;
                        $product = $class::find($productID);
                        // dd($product);
                        if ($product->quantity < $data['quantity'] ) {
                            return redirect()->route('cart.index')
                                ->with("danger","محصول  ". $product->category->title ." طرح " . $product->color_design->design->title . " رنگ " . $product->color_design->color->color . " با کد " . $product->code . " موجودی کافی ندارد. لطفا تعداد  آن را در سبد خرید کاهش دهید و یا با پشتیبانی سایت تماس بگیرید.");
                        }
                        elseif($product->visibility == 0){
                            return redirect()->route('cart.index')
                                ->with("danger","محصول  ". $product->category->title ." طرح " . $product->color_design->design->title . " رنگ " . $product->color_design->color->color . " با کد " . $product->code . "از حالت انتشار خارج شده است.لطفا آن را از سبد خرید خود حذف کنید و یا با پشتیبانی سایت تماس بگیرید.");
                        }
                    }
                }


                $payType = session("payType");
                if($payType == 'card_payments'){
                    return view('cardPayment.create');
                }
                elseif ($payType == 'behpardakht') {
                    $amount = (int)session("sumPayPrice");
                    // $amount = 100;
                    $invoice = new Invoice;
                    $invoice->amount($amount);
                    $invoice->detail(['user_id' => '8']);
                    // $invoice->detail('detailName','your detail goes here');
                    return ShetabitPayment::purchase($invoice, function($driver, $transactionId) {
                        $date = Carbon::now()->toDateTimeString();
                        Session::put('transactionId', $transactionId);
                        $payment = new Payment;

                        $payType = session("payType");
                        $payment_method = session("payType");
                        $payment_method_id = PaymentMethod::where('method',$payment_method)
                            ->first()->id;
                        $payment->payment_method_id = $payment_method_id;
                        $payment->transaction_id = $transactionId;
                        $payment->date = $date;
                        $payment->price = (int)session("sumPayPrice");

                        $recipient_id = session("recipient");
                        $post_id = session("postType");
                        $post = Post::find($post_id);
                        
                        $user_id = Auth::id();

                        $order = new Order;
                        $order->user_id = $user_id;
                        $order->recipient_id = $recipient_id;
                        $order->post_id = $post_id;
                        $locale = config('app.locale');
                        $localePrice = "";
                        if($locale == 'fa')
                            $localePrice = "تومان";
                        $order->postPrice = $post->price;
                        $order->local = $localePrice;
                        $order->status = 0;

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
                            // $discountCard->user_id = $user_id;
                            $discountCard->is_gifted = 1;
                            $discountCard->save();
                            $order->discount_card_id = $discountCard->id;
                        }
                        $order->save();
                        $payment->order_id = $order->id;
                        $payment->save();

                        $cart = session('cart');
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
                        }

                    })->pay()->render();
                    //dd($test->purchase());
                        
                }
            }
        }
        else
            return redirect()->route('cart.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(session()->all());
        $cart = session('cart');
        foreach ($cart as $productID => $value)
        {
            foreach ($value as $model=>$data) {
                $class="App\\".$model;
                $product = $class::find($productID);
                if ($product->quantity < $data['quantity'] ) {
                    return redirect()->route('cart.index')
                        ->with("danger","محصول  ". $product->category->title ." طرح " . $product->color_design->design->title . " رنگ " . $product->color_design->color->color . " با کد " . $product->code . " موجودی کافی ندارد. لطفا تعداد  آن را در سبد خرید کاهش دهید و یا با پشتیبانی سایت تماس بگیرید.");
                }
                elseif($product->visibility == 0){
                    return redirect()->route('cart.index')
                        ->with("danger","محصول  ". $product->category->title ." طرح " . $product->color_design->design->title . " رنگ " . $product->color_design->color->color . " با کد " . $product->code . "از حالت انتشار خارج شده است.لطفا آن را از سبد خرید خود حذف کنید و یا با پشتیبانی سایت تماس بگیرید.");
                }
            }
        }
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $date = str_replace($persian, $english, $request->date);
        $date = Verta::parse($date);
        $date = $date->dateTime();

        $payment = new Payment;

        $payType = session("payType");
        $payment_method = session("payType");
        $payment_method_id = PaymentMethod::where('method',$payment_method)
            ->first()->id;
        // if($payType == 'card_payments'){
            $payment->payment_method_id = $payment_method_id;
            $payment->tracing_code = $request->tracing_code;
            $payment->date = $date;
            $payment->price = $request->price_cardPay;
        // }//Card Payments

        

        $recipient_id = session("recipient");
        $post_id = session("postType");
        $post = Post::find($post_id);
        
        $user = Auth::user();

        $order = new Order;
        $order->user_id = $user->id;
        $order->recipient_id = $recipient_id;
        $order->post_id = $post_id;
        // $order->payment_method_id = $payment_method_id;
        $locale = config('app.locale');
        $localePrice = "";
        if($locale == 'fa')
            $localePrice = "تومان";
        $order->postPrice = $post->price;
        $order->local = $localePrice;
        $order->status = 0;
        // $order->orderable()->associate($cardPayment);
        // $payment->order()->associate($order);

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
            // $discountCard->user_id = $user_id;
            $discountCard->is_gifted = 1;
            $discountCard->save();
            $order->discount_card_id = $discountCard->id;
        }
        $order->save();
        $payment->order_id = $order->id;
        // $payment->order->associate($order);
        $payment->save();


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
        RayganSms::sendMessage('09134577500',"فاکتوری با کد " .$order->code." به نام ". Auth::user()->name . " " . Auth::user()->family ." با مبلغ". (int)session("sumPayPrice") . $order->local. " صادر شد.");

        if (isset(Auth::user()->email) and isset(Auth::user()->email_verified_at)) {
             Mail::to(Auth::user()->email)
               ->send(new FactorMail($order));
        }
        
        session()->forget(['cart']);
        session()->flush();
        Auth::login($user, true);
        return redirect()->route('cart.factor',[$order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verifyPayment(Request $request)
    {
        // dd('sa');
        //dd("aaaaaaa",$request->all());
        $payment = Payment::where('transaction_id',$request->RefId)
            ->first();
         //dd($payment);
        $transaction_id = $payment->transaction_id;
        $amount = $payment->price;

        $payment->res_code = $request->ResCode;
        $payment->ref_id = $request->RefId;
        $payment->saleReferenceId = $request->SaleReferenceId;

        $order = Order::find($payment->order_id);
        $user = User::find($order->user_id);

        try {
            $receipt = ShetabitPayment::amount($amount)->transactionId($transaction_id)->verify();
            $payment->description = "پرداخت موفق";
            // dd($receipt,$receipt->getDetails(),$receipt->getTransactionId,$receipt->getReferenceId());
            // $ref_id = $receipt->getReferenceId();
            // You can show payment referenceId to the user.
            // echo $receipt->getReferenceId();
            $orderItems = Orderitem::where('order_id',$payment->order_id)
                ->get();
            foreach ($orderItems as $orderitem)
            {
                $product = $orderitem->orderitemable_type::find($orderitem->orderitemable_id);
                $product->quantity = $product->quantity - $orderitem->count;
                $product->save();
            }
            $payment->save();

            RayganSms::sendMessage($user->mobile, $user->name . " " . $user->family . " عزیز، با سپاس از اعتماد و خرید شما از فروشگاه ترمه سالاری،کد فاکتور شما ". $order->code ." میباشد.");
            RayganSms::sendMessage('09134577500',"فاکتوری با کد " .$order->code." به نام ". $user->name . " " . $user->family ." با مبلغ". $amount . $order->local. " صادر شد.");

            if (isset($user->email) and isset($user->email_verified_at)) {
                Mail::to($user->email)
                  ->send(new FactorMail($order));
            }

            session()->forget(['cart']);
            session()->flush();
            Auth::login($user, true);
            return redirect()->route('cart.factor',[$order]);

        } catch (InvalidPaymentException $exception) {
            /**
                when payment is not verified, it will throw an exception.
                We can catch the exception to handle invalid payments.
                getMessage method, returns a suitable message that can be used in user interface.
            **/
            // echo $exception->getMessage();
            $payment->description = $exception->getMessage();
            $error = $exception->getMessage();
            $payment->save();
            Auth::login($user, true);
            return view('payment.payment-error')
                ->with('error',$error);
        }//Catch
        
    }

}//END CLASS
