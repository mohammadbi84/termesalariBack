<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tablecloth;
use App\Recipient;
use App\City;
use App\Subcity;
use App\User;
use App\Post;
use App\Order;
use App\Orderitem;
use App\PaymentMethod;
use App\DiscountCard;
use Auth;
use Illuminate\Support\Facades\Gate;


class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->except('index','add','change','destroy','cartDeleteItem');
    }

    public function index()
    {
        session()->forget(['discountCardPrice' , 'discountCardID']);
        if (session()->has('cart')) {
            // dd(111);
            $cart = session('cart');
            $sum = 0;
            $list=['products'=>[],'models'=>[],'quantities'=>[]];
            foreach ($cart as $productID => $value)
            {
                foreach ($value as $model=>$data) {

                    $class="App\\".$model;
                    array_push($list['products'], $class::find($productID));
                    array_push($list['models'], $model);
                    array_push($list['quantities'], $data['quantity']);
                    $sum = $sum + $data['quantity'];

                }
            }
            // dd($list);
            return view('cart.new.cart')
            ->with('cart', $cart)
            ->with('sum', $sum)
            ->with('list', $list);
        }
        return view('cart.new.cart');
    }
    //     else
    //         return "<div style='color:red; text-align:center;direction:rtl;font-family:system-ui'>متاسفانه دسترسی به این صفحه برای شما وجود ندارد.</div>";
    // }

     public function add(string $product, string $controller)
    {
        // session()->flush();
        $class="App\\".$controller;
        $product = $class::find($product);
        $q = $product->quantity;

        if(session()->has('cart'))
            $cart = session('cart');

        if($q > 0 )
        {
            if(isset($cart[$product->id][$controller]))
            {
                if($product->quantity > $cart[$product->id][$controller]['quantity'])
                {
                // dd($cart[$product->id][$controller]);
                    $cart[$product->id][$controller]['quantity']++;
                }
                else
                    return 0;
            }
            else {
                $cart[$product->id][$controller]['quantity'] = 1;
                $cart[$product->id][$controller]['model'] = $controller;
            }
            // dd($cart);
            session(['cart' => $cart]);
        // session()->flush();

            return 1;
        }
        elseif($q == 0 )
            return 0;

    }

    public function change(Request $request)
    {
        // dd($request->all());
        $action = $request->action;
        $product = $request->product;
        $model = $request->model;
        if(session()->has('cart')){
            $cart = session('cart');
        }
        if(isset($cart[$product][$model])){
            if ($action == 'increase'){
                $class="App\\".$model;
                $item = $class::find($product);

                if($item->quantity > $cart[$product][$model]['quantity']){
                    $cart[$product][$model]['quantity']++;
                }
                else
                    return "error";
            }
            elseif($action == 'decrease'){
                if ($cart[$product][$model]['quantity'] == 1){
                    unset($cart[$product][$model]);
                    session(['cart' => $cart]);
                    return "finish";
                }
                else
                    $cart[$product][$model]['quantity']--;
            }
        }
        session(['cart' => $cart]);

        // return $cart[$product]['quantity'];
        return $cart[$product][$model];
    }

    public function destroy(string $product)
    {
        // code...
    }

    public function cartDeleteItem(Request $request)
    {
        // dd($book, session()->all());
        // dd($request->all());
        // dd(session('cart'));
        $cart = session('cart');
        // dd($cart[$request->id]['moddel']);
        if(isset($cart[$request->id][$request->model])){
            // dd("l");
            unset($cart[$request->id][$request->model]);
            session(['cart' => $cart]);
            return ['status' => 'success', 'count' => count($cart)];
        }
        return ['status' => 'error'];
    }

    public function cartlevel2()
    {
        if(Auth::check()){
            if (session()->has('cart')) {
                $cities = City::all();
                $posts = Post::where('active',1)
                    ->get();
                $payment_methods = PaymentMethod::where('active',1)
                    ->get();
                $recipients = Recipient::where('user_id',Auth::id())
                    ->where('visibility',1)
                    ->get();
                if($recipients->count() > 0)
                {
                    $date = Recipient::where('user_id',Auth::id())->max("created_at");
                    $cart = session('cart');
                    // dd($cart);
                    // foreach ($cart as $key => $value)
                    // {
                    //     $class="App\\".$value['moddel'];
                    //     $list->push($class::find($key));
                    // }
                    $list=['products'=>[],'models'=>[],'quantities'=>[]];
                    $sum = 0;
                    foreach ($cart as $productID => $value)
                    {
                        foreach ($value as $model=>$data) {

                            $class="App\\".$model;
                            array_push($list['products'], $class::find($productID));
                            array_push($list['models'], $model);
                            array_push($list['quantities'], $data['quantity']);
                            $sum = $sum + $data['quantity'];

                        }
                    }
                    return view('cart.cart-level2')
                    ->with('cart', $cart)
                    ->with('list', $list)
                    ->with('sum', $sum)
                    ->with('date', $date)
                    ->with('recipients',$recipients)
                    ->with('cities',$cities)
                    ->with('payment_methods',$payment_methods)
                    ->with('posts',$posts);
                }
                else
                    return view('recipient.create')
                        ->with('cities',$cities);
            }
            else
                return view('cart.index');

        }
    }

public function cartfinal(Request $request)
{
        // dd(config('locale'));
    // dd($request->all());
    session()->put("recipient", $request->selectedRecipientId);
    session()->put("postType", $request->postType);
    session()->put("payType", $request->payType);
    $payType = PaymentMethod::where('method',$request->payType)
        ->first()->title;
    $post = Post::where('id',$request->postType)->first();
    $recipient = Recipient::where('id',$request->selectedRecipientId)->first();
    $cart = session('cart');
    // dd($cart);
    $list=['products'=>[],'models'=>[],'quantities'=>[]];
    $sum = 0;
    $payPrice = 0;
    $off = 0;
    $originalPrice = 0;
    foreach ($cart as $productID => $value)
    {
        foreach ($value as $model=>$data) {

            $class ="App\\".$model;
            $product = $class::find($productID);
            array_push($list['products'], $product);
            array_push($list['models'], $model);
            array_push($list['quantities'], $data['quantity']);
            $sum = $sum + $data['quantity'];

            $locale = config('app.locale');
            $localePrice = "";
            if($locale == 'fa')
                $localePrice = "تومان";

            $p = $product->prices->where('local',$localePrice)->first();
            $originalPrice = $originalPrice + ($p->price * $data['quantity']);
            if($p->offPrice > 0)
            {
                if($p->offType == 'مبلغ')
                {

                    $cartItemPrice = $p->price - $p->offPrice;
                    $cartItemOff = $p->offPrice;
                    $payPrice = $payPrice + ( ($p->price - $p->offPrice) * $data['quantity']);
                    $off = $off + ($cartItemOff * $data['quantity']);
                }
                elseif($p->offType == 'درصد')
                {
                    $cartItemPrice = $p->price - ($p->price * ($p->offPrice/100));
                    $cartItemOff = $p->price * ($p->offPrice/100);
                    $payPrice = $payPrice + (($p->price - $cartItemOff) * $data['quantity']);
                    $off = $off + ($cartItemOff * $data['quantity']);

                }
            }
            else
            {
                $cartItemPrice = $p->price;
                $payPrice = $payPrice + ($p->price * $data['quantity']);
            }

        }
    }
    $payPrice = $payPrice + $post->price;

    session()->put("sumPayPrice", $payPrice);
    session()->put("sumOff", $off);
    session()->put("sumOriginalPrice", $originalPrice);

    return view("cart.cartfinal")
        ->with('cart',$cart)
        ->with('list',$list)
        ->with('post',$post)
        ->with('recipient',$recipient)
        ->with('payType',$payType);
    }

    public function factor(Order $order)
    {
        return view('cart.factor')
            ->with('order',$order);
    }

    public function storeDiscountCard(Request $request)
    {
        // dd($request->all());
        if (session()->has('discountCardID')) {
            $result["res"] = "error";
            $result["message"] = "کد تخفیف ".session('discountCardID')."ثبت شده است و امکان ثبت کد جدید وجود ندارد .";
            return $result;
        }
        $discountCard = DiscountCard::where('code', $request->code)
            ->first();
        if (!isset($discountCard)) {
            $result["res"] = "error";
            $result["message"] = "کد تخفیف نامعتبر می باشد .";
        }
        else{
            $order = Order::where('discount_card_id',$discountCard->id)
                ->get();
            $user_order = Order::where('discount_card_id',$discountCard->id)
                ->where('user_id',Auth::id())
                ->get();
            if ($order->count() >= $discountCard->count_usable) {
                $result["res"] = "error";
                $result["message"] = "ظرفیت استفاده از این کد تخفیف پایان یافته است.";
            }
            elseif ($user_order->count() > 0) {
                $result["res"] = "error";
                $result["message"] = "شما از این کد تخفیف قبلا استفاده کرده اید .امکان استفاده مجدد از آن وجود ندارد.";
            }
            elseif (isset($discountCard) and $order->count() < $discountCard->count_usable and $user_order->count() == 0)
            {
                date_default_timezone_set('Asia/Tehran');
                $startDate = verta($discountCard->start_date);
                $expireDate = verta($discountCard->expire_date);
                $now = verta(now());
                if ($now->lt($startDate)){
                    $result["res"] = "error";
                    $result["message"] = "زمان استفاده از این کد تخفیف هنوز فرا نرسیده است .زمان شروع اعتبار ". verta($discountCard->start_date)->format('Y/m/d H:m:s') ."می باشد .";
                }
                elseif ($now->gt($expireDate)) {
                    $result["res"] = "error";
                    $result["message"] = "زمان استفاده از این کد تخفیف به پایان رسیده است  .";
                }
                elseif($now->between($startDate,$expireDate))
                {
                    $discountPrice = 0;
                    if ($discountCard->type_amount == "price") {
                        $discountPrice = $discountCard->amount;
                    }
                    else if ($discountCard->type_amount == "percent") {
                        // $discountPrice = round(($request->sum * $discountCard->amount) / 100 ,-2);
                        $discountPrice = ($request->sum * $discountCard->amount) / 100 ;
                    }
                    $result["res"] = "success";
                    $result["message"] = $discountPrice;
                    session()->put("discountCardPrice", $discountPrice);
                    session()->put("discountCardID", $discountCard->id);
                }
            }
        }

        return $result;
    }


}//End

