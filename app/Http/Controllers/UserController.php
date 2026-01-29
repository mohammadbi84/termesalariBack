<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\City;
use App\Subcity;
use App\Order;
use App\Orderitem;
use App\Favorite;
use App\Comment;
use App\Recipient;
use App\UserMessage;
use App\Newsletter;
use App\Tablecloth;
use App\Bedcover;
use App\Bag;
use App\Shoe;
use App\Fabric;
use App\Frame;
use App\Pillow;
use App\Prayermat;
use App\Payment;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::all();

        return view("user.index")
            ->with("users", $users);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        $user = User::where('id', $user->id)
            ->with('comments')
            ->with('favorites')
            ->with('orders')
            ->first();
        // dd($user);
        $orders = $user->orders->filter(function ($item) {
            foreach ($item->payments as $pay) {
                // dd($pay);
                if ($pay->tracing_code <> '' or $pay->res_code == 0) {
                    return true;
                } else
                    return false;
            }
        });
        // dd($user);
        // dd($payment);
        $userMessages = UserMessage::where('user_id', $user->id)
            ->orWhere('parentID', $user->id)
            ->orderby('created_at')
            ->get();

        return view('user.show')
            ->with('user', $user)
            ->with('orders', $orders)
            ->with('userMessages', $userMessages);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        // $user = User::find($id);
        $cities = City::all();
        // $subcities = Subcity::all();
        $companySubcities = [];

        if (isset($user->city_id)) {
            $companySubcities = Subcity::where('city_id', $user->city_id)
                ->get();
        }

        return view("user.edit")
            ->with('user', $user)
            ->with("cities", $cities)
            // ->with("subcities",$subcities)
            ->with("companySubcities", $companySubcities);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {

        $this->authorize('update', $user);
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $birthday = str_replace($persian, $english, $request->birthday);
        $birthday = Verta::parse($birthday);
        $birthday = $birthday->dateTime();
        // $birthday = $birthday->dateTime()->getTimestamp();


        $user->fill($request->all());
        $user->birthday = $birthday;
        $user->city_id = $request->city_id;
        $user->subcity_id = $request->subcity_id;
        $user->save();

        $companySubcities = [];

        if (isset(Auth::user()->city_id)) {
            $companySubcities = Subcity::where('city_id', Auth::user()->city_id)
                ->get();
        }

        $cities = City::all();
        // return view("user.profile")
        return redirect()
            ->back()
            ->with('success', '::ویرایش با موفقیت انجام شد ::')
            ->with("cities", $cities)
            ->with("companySubcities", $companySubcities);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // $this->authorize('delete', $id);
        $orders = $user->orders()->get();
        $favorites = $user->favorites()->get();
        $comments = $user->comments()->get();
        $userMessages = $user->userMessages()->get();
        $msg = "درخواست شما برای حذف پذیرفته نشد. چون اطلاعات این کاربر در بخش";
        $delFlag = 0;
        if ($comments->count() > 0) {
            $msg .= " ::نظرات::  ";
            $delFlag = 1;
        }
        if ($favorites->count() > 0) {
            $msg .= " ::علاقه مندی ها:: ";
            $delFlag = 1;
        }
        if ($userMessages->count() > 0) {
            $msg .= "::پیام ها:: ";
            $delFlag = 1;
        }
        if ($orders->count() > 0) {
            $msg .= " ::سفارش ها:: ";
            $delFlag = 1;
        }
        $msg .= "وجود دارد.";

        if ($delFlag == 1) {
            $result["res"] = "error";
            $result["message"] = $msg;
            return $result;
        } else if ($delFlag == 0) {
            $user->delete();
            $result["res"] = "success";
            $result["message"] = "گزینه انتخابی با موفقیت حذف شد .";
        }



        // if($user->delete())
        // {
        //     $result["res"] = "success";
        //     $result["message"] = "گزینه انتخابی با موفقیت حدف شد .";
        // }
        // else
        // {
        //     $result["res"] = "error";
        //     $result["message"] = "عملیات حذف با خطا روبرو شده است.";
        // }
        return $result;
    }

    public function profile()
    {

        $this->authorize('profile', User::class);

        $cities = City::all();
        $subcities = Subcity::all();
        $companySubcities = [];

        if (isset(Auth::user()->city_id)) {
            $companySubcities = Subcity::where('city_id', Auth::user()->city_id)
                ->get();
        }
        return view("user.profile")
            ->with("cities", $cities)
            ->with("subcities", $subcities)
            ->with("companySubcities", $companySubcities);
    }

    public function convertPersianToEnglish($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $output = str_replace($persian, $english, $string);
        return $output;
    }

    public function myOrders()
    {
        $this->authorize('myOrders', User::class);
        //Log::info()
        //dd(Auth::id());
        // $listOrders = Payment::with('order')
        //     ->where('tracing_code','<>','')
        //     ->orWhere('res_code','0')
        //     ->get()
        //     ->sortbyDesc('created_at');
        $listOrders = Order::where('user_id', Auth::id())
            ->get();

        $unsuccessOrders = $listOrders->filter(function ($item) {
            foreach ($item->payments as $payment) {
                if ($payment->tracing_code <> '' or $payment->res_code == 0) {
                    return false;
                } else
                    return true;
            }
        });

        $successOrders = $listOrders->filter(function ($item) {
            foreach ($item->payments as $payment) {
                if ($payment->tracing_code <> '' or $payment->res_code == 0) {
                    return true;
                } else
                    return false;
            }
        });



        // dd($unsuccessOrders);

        return view('user.my-orders')
            ->with('listOrders', $listOrders)
            ->with('successOrders', $successOrders)
            ->with('unsuccessOrders', $unsuccessOrders);
    }

    public function myOrder($id)
    {
        $this->authorize('myOrder', User::class);
        $order = Order::find($id);
        // dd($order);
        return view('user.my-order')
            ->with('order', $order);
    }

    public function myPayments()
    {
        $this->authorize('myPayments', User::class);
        $orders = Order::where('user_id', Auth::id())
            ->pluck('id');
        $listPayments = Payment::with('order')
            ->whereIn('order_id', $orders)
            ->orderby('created_at', 'desc')
            ->get();
        return view('user.my-payments')
            ->with('listPayments', $listPayments);
    }

    public function changePassword()
    {
        $this->authorize('changePassword', User::class);
        return view('user.change-password');
    }

    public function updatePassword(Request $request)
    {
        $this->authorize('updatePassword', User::class);
        $rules = [
            'currentPassword' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ];
        $request->validate($rules);
        $user = Auth::user();
        if (Hash::check($request->currentPassword, $user->password)) {
            // dd(111);
            return redirect()
                ->back()
                ->with("danger", ":: رمز عبور فعلی نادرست می باشد . ::");
        } else {
            // dd(222);
            $user->password = Hash::make($request->currentPassword);
            $user->save();
            return redirect()
                ->back()
                ->with('success', ':: رمز عبور با موفقیت تغییر یافت . ::');
        }
    }

    public function favorites(Request $request)
    {
        $this->authorize('favorites', User::class);
        $favorites = Favorite::where('user_id', Auth::id())
            ->get();
        // dd($favorites);
        return view('user.favorites')
            ->with('favorites', $favorites);
    }

    public function comments(Request $request)
    {
        $this->authorize('comments', User::class);
        $comments = Comment::where('user_id', Auth::id())
            // ->groupby('commentable_type','commentable_id')
            ->orderby('created_at', 'asc')
            ->get();
        return view('user.comments')
            ->with('comments', $comments);
    }

    public function deleteComment(Request $request)
    {
        $this->authorize('deleteComment', User::class);
        $comment = Comment::find($request->id);
        $comment->delete();
        $count = Comment::where('user_id', Auth::id())
            ->where('commentable_type', $request->model)
            ->where('commentable_id', $request->parentId)
            ->get()->count();
        $result["res"] = "success";
        $result["message"] = "گزینه انتخابی با موفقیت حدف شد .";
        $result["count"] = $count;
        return $result;
    }

    public function deleteComments(Request $request)
    {
        $this->authorize('deleteComments', User::class);
        $comments = Comment::where('commentable_id', $request->id)
            ->where('commentable_type', $request->model)
            ->where('user_id', Auth::id())
            ->delete();
        // $comments->detach();
        $result["res"] = "success";
        $result["message"] = "گزینه انتخابی با موفقیت حدف شد .";
        return $result;
    }

    public function recipients(Request $request)
    {
        $this->authorize('recipients', User::class);
        $recipients = Recipient::where('user_id', Auth::id())
            ->where('visibility', 1)
            ->get();
        return view('user.recipients')
            ->with('recipients', $recipients);
    }

    public function messages(Request $request)
    {
        $this->authorize('messages', User::class);
        // $userMessages = UserMessage::where('user_id',Auth::id())
        //     ->where('parentID',0)
        //     ->orderby('created_at','desc')
        //     ->get();

        $userMessages = UserMessage::orderby('created_at', 'desc')
            ->get();

        foreach ($userMessages as $key => $message) {
            if ($message->parentID != 0) {
                $userMessages[$key] = $message->parent()->withTrashed()->first();
                if ($message->isRead == 0) {
                    $userMessages[$key]->isRead = 0;
                }
            }
        }

        $userMessages = $userMessages->unique('id');

        return view('user.messages')
            ->with('userMessages', $userMessages);
    }

    public function messageStore(Request $request)
    {
        $this->authorize('messageStore', User::class);
        $rules = [
            'subject' => 'required|string',
            'message' => 'required|string',
        ];
        $request->validate($rules);
        $message = new UserMessage;
        $message->fill($request->all());
        $message->user_id = Auth::id();
        $message->save();

        // $userMessages = UserMessage::where('user_id',Auth::id());
        return redirect()->route('user.messages')
            ->with('success', ':: ارسال پیام با موفقیت انجام شد ::');
    }

    public function messageDetail(string $id)
    {
        $this->authorize('messageDetail', User::class);
        // $messageDetails = UserMessage::where('user_id',Auth::id())
        //     ->where('parentID',$id)
        //     ->orderby('created_at','asc')
        //     ->get();

        $messageDetails = UserMessage::where('parentID', $id)
            // ->where('parentID',$id)
            ->orderby('created_at', 'asc')
            ->get();

        $messageStart = UserMessage::where('id', $id)
            ->first();

        if (isset($messageStart) and $messageStart->isRead == 0) {
            $messageStart->isRead = 1;
            $messageStart->save();
        }

        // return $messageDetail;
        return view('user.message-details')
            ->with('messageDetails', $messageDetails)
            ->with('messageStart', $messageStart);
    }

    public function messageRead(Request $request)
    {
        $this->authorize('messageRead', User::class);
        $message = UserMessage::withTrashed()
            ->where('id', $request->message_id)
            ->first();

        if (isset($message) and $message->isRead == 0 and $message->user_id != Auth::id()) {
            $message->isRead = 1;
            $message->save();
        }
        return true;
    }

    public function saveAnswer(Request $request, UserMessage $messageStart)
    {
        $this->authorize('saveAnswer', User::class);
        $rules = [
            // 'subject' => 'required|string',
            'message' => 'required|string',
        ];
        $request->validate($rules);
        $message = new UserMessage;
        $message->fill($request->all());
        $message->user_id = Auth::id();
        $message->parentID = $messageStart->id;
        $message->save();
        return redirect()->back();
    }

    public function delConversation(Request $request)
    {
        $this->authorize('delConversation', User::class);
        // dd($request->id);
        $userMessages = UserMessage::where('id', $request->id)
            ->orWhere('parentID', $request->id);

        if ($userMessages->delete()) {
            $result["res"] = "success";
            $result["message"] = "پیام انتخابی به همراه گفتگوهای مربوط به آن حذف شد.";
            return $result;
        }
    }

    public function delMessage(Request $request)
    {
        $this->authorize('delMessage', User::class);
        // dd($request->all());
        $userMessage = UserMessage::where('id', $request->id);

        if ($userMessage->delete()) {
            $result["res"] = "success";
            $result["message"] = "پیام انتخابی با موفقیت حذف شد.";
            return $result;
        }
    }

    public function changeImage($image)
    {
        $this->authorize('changeImage', User::class);
        // dd($image);/
        $user = User::find(Auth::id());
        $user->image = $image;
        $user->save();
        return redirect()->back();
    }

    public function changeStatus($user)
    {
        $this->authorize('changeStatus', User::class);
        // dd($user);
        $user = user::find($user);
        if ($user->isActive == "0") {
            $user->isActive = "1";
        } else if ($user->isActive == "1") {
            $user->isActive = "0";
        }
        $user->save();

        $result["res"] = "success";
        $result["message"] = "کاربر انتخابی تغییر وضعیت یافت.";
        return $result;
    }

    public function changeStatusGroup(Request $request)
    {
        $this->authorize('changeStatusGroup', User::class);
        $result = [];
        if (isset($request->items)) {
            foreach ($request->items as $id) {
                $user = User::find($id);
                if ($user->isActive == 0)
                    $user->isActive = 1;
                else if ($user->isActive == 1)
                    $user->isActive = 0;
                $user->save();
            }
            $result["res"] = "success";
            $result["message"] = "موارد انتخابی با موفقیت تغییر وضعیت یافت .";
        } else {
            $result["res"] = "error";
            $result["message"] = "لطفا ابتداسطرهای مورد نظر را انتخاب کنید.";
        }
        return $result;
    }

    public function saveChange(Request $request, int $id)
    {
        $this->authorize('saveChange', User::class);
        $rules = [
            'name' => 'required|string',
            'family' => 'required|string',
            'nationalCode' => 'nullable|numeric|unique:users,nationalCode,' . $id,
            'mobile' => 'required|numeric|unique:users,mobile,' . $id,
            'birthday' => 'required|',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'password' => 'required|string|min:8|max:50' ,

            'image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:max_width=150,max_height=150',

            'companyName' => 'nullable|string',

            'companyEconomyID' => 'nullable|required_with:companyName,companyNationalID,companyRegistrationID,city_id,subcity_id|numeric|unique:users,companyEconomyID,' . $id,

            'companyNationalID' => 'nullable|required_with:companyName,companyEconomyID,companyRegistrationID,city_id,subcity_id|numeric|unique:users,companyNationalID,' . $id,

            'companyRegistrationID' => 'nullable|required_with:companyName,companyEconomyID,companyNationalID,city_id,subcity_id|numeric|unique:users,companyRegistrationID,' . $id,

            'city_id' => 'required_with:companyName,companyEconomyID,companyNationalID,companyRegistrationID,subcity_id',

            'subcity_id' => 'required_with:companyName,companyEconomyID,companyNationalID,companyRegistrationID,city_id',

            'companyTel' => 'nullable|required_with:companyName,companyEconomyID,companyNationalID,companyRegistrationID|numeric',
            'companySite' => 'nullable',
        ];
        $request->validate($rules);

        // dd($request->all());

        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $birthday = str_replace($persian, $english, $request->birthday);
        $birthday = Verta::parse($birthday);
        $birthday = $birthday->dateTime();
        // $birthday = $birthday->dateTime()->getTimestamp();

        $user = User::find($id);
        $user->fill($request->all());
        $user->birthday = $birthday;
        $user->city_id = $request->city_id;
        $user->subcity_id = $request->subcity_id;
        $user->save();

        $companySubcities = [];

        if (isset(Auth::user()->city_id)) {
            $companySubcities = Subcity::where('city_id', Auth::user()->city_id)
                ->get();
        }

        $cities = City::all();
        // return view("user.profile")
        return redirect()
            ->back()
            ->with('success', '::ویرایش با موفقیت انجام شد ::')
            ->with("cities", $cities)
            ->with("companySubcities", $companySubcities);
    }

    public function adminProfile(Request $request)
    {
        $this->authorize('adminProfile', User::class);
        return view('user.admin-profile');
    }

    public function adminProfileStore(Request $request, User $user)
    {
        $this->authorize('adminProfileStore', User::class);
        // dd($request->all());
        $rules = [
            'name' => 'required|string',
            'family' => 'required|string',
        ];
        $request->validate($rules);
        $user->name = $request->name;
        $user->family = $request->family;
        $user->save();
        return redirect()
            ->back()
            ->with('success', 'عملیات ویرایش با موفقیت انجام شد.');
    }

    public function adminChangeImage($image)
    {
        $this->authorize('adminChangeImage', User::class);
        // dd($image);
        $user = User::find(Auth::id());
        $user->image = $image;
        $user->save();
        return redirect()->back();
    }

    public function adminChangePassword(Request $request)
    {
        $this->authorize('adminChangePassword', User::class);
        return view('user.admin-change-password');
    }

    public function dashboard()
    {
        $this->authorize('dashboard', User::class);

        $countComments = Comment::count();

        $countNewsletters = Newsletter::count();

        $orders = Order::all();
        $orders = $orders->filter(function ($item) {
            // dd($item);
            if ($item->status == 2) {
                // dd(1);
                return false;
            } else {
                foreach ($item->payments as $payment) {
                    if ($payment->tracing_code <> '' or $payment->res_code == 0) {
                        return true;
                    } else
                        return false;
                }
            }
        });

        $countOrderitems = 0;
        $sumPrice = 0;
        $sumOff = 0;
        foreach ($orders as $order) {
            foreach ($order->orderitems as $orderitem) {
                $countOrderitems = $countOrderitems + $orderitem->count;
                $sumPrice = $sumPrice + $orderitem->price;
                $sumOff = $sumOff + $orderitem->offPrice;
            }
        }

        $countUsers = User::count();

        $lastUsers = User::where('role', 'user')
            ->orderby('created_at', 'desc')
            ->take(12)
            ->get();

        // $list = Payment::with('order')
        //     ->where('tracing_code','<>','')
        //     ->orWhere('res_code','0')
        //     ->get()
        //     ->sortbyDesc('created_at');
        $lastOrders = Order::whereHas('payments', function ($q) {
            $q->where(function ($qq) {
                $qq->whereNotNull('tracing_code')
                    ->orWhere('res_code', 0);
            });
        })
            ->latest()
            ->take(10)
            ->get();



        $topRequests = Orderitem::with('orderitemable')->select(DB::raw('sum(count) as sum, orderitemable_id, orderitemable_type'))
            ->groupBy('orderitemable_id', 'orderitemable_type')
            ->orderby('sum', 'desc')
            ->take(10)
            ->get();

        // dd($topRequests);
        $topRequests = $topRequests->filter(function ($item) {
            // dd($item);
            if ($item->orderitemable == null) {
                return false;
            } else if ($item->orderitemable->visibility == 0) {
                return false;
            } else
                return true;
        });

        // $currentYearData = Orderitem::whereYear('created_at',now()->format('Y'))
        //     ->get();


        $oldYearData = Orderitem::whereYear('created_at', (now()->format('Y')) - 1)
            ->get();

        $currentMounthShamsi = intVal(Verta(now())->format('m'));
        $currentMounthMiladi = intVal(now()->format('m'));

        $currentYearData = [];
        for ($i = 12; $i > 0; $i--) {
            if ($i < $currentMounthShamsi) {
                array_push($currentYearData, 0);
                continue;
            }
            $price = Orderitem::whereYear('created_at', now()->format('Y'))
                ->whereMonth('created_at', $currentMounthMiladi)
                ->select(DB::raw('sum(price) - sum(offPrice) as sumPrice'))
                ->first();
            // dd($price);
            array_push($currentYearData, $price->sumPrice);
            $currentMounthMiladi--;
        }

        $oldYearData = [];
        $oldYear = intVal(now()->format('Y') - 1);
        for ($i = 12; $i > 0; $i--) {
            $price = Orderitem::whereYear('created_at', $oldYear)
                ->whereMonth('created_at', $i)
                ->select(DB::raw('sum(price) - sum(offPrice) as sumPrice'))
                ->first();

            array_push($oldYearData, $price->sumPrice);
        }

        $countProducts = Tablecloth::count() +
            Shoe::count() +
            Bedcover::count() +
            Bag::count() +
            Fabric::count() +
            Frame::count() +
            Pillow::count() +
            Prayermat::count();

        // $countOrders = Order::where('status','0')
        //     ->get();
        // $countOrders = 0;
        // foreach ($orders as $key => $order) {
        //     if ($order->status == 0) {
        //         foreach ($order->payments as $payment) {
        //             if ($payment->tracing_code <> '' or $payment->res_code == 0) {
        //                 $countOrders++;
        //             }
        //         }
        //     }
        // }
        // dd($countOrders);




        // $countOrders = Payment::with('order')
        //     ->where('tracing_code', '<>', '')
        //     ->orWhere('res_code', '0')
        //     ->count();
        $countOrders = Order::whereHas('payments', function ($q) {
            $q->where(function ($qq) {
                $qq->whereNotNull('tracing_code')
                    ->orWhere('res_code', 0);
            });
        })->count();
        // dd($countOrders);

        $orderitems = Orderitem::all()
            ->groupby('orderitemable_type');
        $countOfTypeProducts = 0; //تعداد اقلام فروخته شده
        foreach ($orderitems as $orderitem) {
            $countOfTypeProducts = $countOfTypeProducts + $orderitem->groupby('orderitemable_id')->count();
        }

        return view('user.dashboard')
            ->with('countComments', $countComments)
            ->with('countNewsletters', $countNewsletters)
            ->with('countOrderitems', $countOrderitems)
            ->with('countUsers', $countUsers)
            ->with('lastUsers', $lastUsers)
            ->with('lastOrders', $lastOrders)
            ->with('topRequests', $topRequests)
            ->with('currentYearData', $currentYearData)
            ->with('oldYearData', $oldYearData)
            ->with('countOrders', $countOrders)
            ->with('sumPrice', $sumPrice)
            ->with('sumOff', $sumOff)
            ->with('countProducts', $countProducts)
            ->with('countOfTypeProducts', $countOfTypeProducts);
    }

    public function export()
    {
        $this->authorize('export', User::class);
        return Excel::download(new UserExport, 'user.xlsx');
    }

    public function resendVerifyEmail()
    {
        Auth::user()->sendEmailVerificationNotification();
    }
}//End Class

//https://medium.com/@selvakumar_P/laravel-send-mail-from-localhost-xampp-4b85e002ebe1
