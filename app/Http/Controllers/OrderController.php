<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Facades\Storage;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Order::class, 'order');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Payment::with('order')
            ->where('tracing_code','<>','')
            ->orWhere('res_code','0')
            ->get()
            ->sortbyDesc('created_at');
        // $orders = Order::all()
        //     ->sortbyDesc('created_at');
        // dd($list);
        $list = $list->filter(function($item){
            // dd($item);
            if ($item->order == "") {
                return false;
            }
            // else if ($item->order->status == 2) {
            //     // dd(1);
            //     return false;
            // }
            else if ($item->tracing_code <> '' or $item->res_code == 0) {
                return true;
            }
            else
                return false;
        });
        // dd($list);
        return view('order.index')
            ->with('list',$list);
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // $payment = Payment::where('order_id',$order->id)
        //     ->where(function($query) {
        //         $query->where('tracing_code','<>','')
        //             ->orWhere('res_code','0');
        //     })
        //     ->get();
        // dd($order);
        return view('order.show')
            // ->with('payment',$payment)
            ->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if($order->delete())
        {
            $result["res"] = "success";
            $result["message"] = "گزینه انتخابی با موفقیت حدف شد .";
        }
        else
        {
            $result["res"] = "error";
            $result["message"] = "عملیات حذف با خطا روبرو شده است.";
        }
        return $result;
    }

    // public function confirmOrder(Request $request)
    // {
    //     $this->authorize('confirmOrder',Order::class);
    //     $order = Order::find($request->id);
    //     $result["message"] = "";
    //     // if($order->status == "0"){
    //         $order->status = "1";
    //         $result["message"] = "فاکتور انتخابی برای ارسال کالا تایید شد.";
    //     // }
    //     $order->save();
        
    //     $result["res"] = "success";
    //     return $result;
    // }

    // public function rejectOrder(Request $request)
    // {
    //     $this->authorize('rejectOrder',Order::class);
    //     $order = Order::find($request->id);
    //     $result["message"] = "";
    //     if($order->status == "0"){
    //         $order->status = "2";
    //         $result["message"] = "سفارش انتخابی رد شد.";
    //     }
    //     $order->save();
        
    //     $result["res"] = "success";
    //     return $result;
    // }

    public function setStatus(Request $request)
    {
        $this->authorize('setStatus',Order::class);
        // dd($request->all());
        $order = Order::find($request->id);
        $result["message"] = "";
        if ($request->action == 'confirm') {
            $order->status = "1";
            $result["message"] = "سفارش انتخابی تایید شد.";
        }
        elseif ($request->action == 'reject'){
            $order->status = "2";
            $result["message"] = "سفارش انتخابی رد شد.";
            foreach ($order->orderitems as $key => $orderitem) {
                $orderitem->orderitemable->quantity = $orderitem->orderitemable->quantity + $orderitem->count;
                $orderitem->orderitemable->save();
            }
        }
        $order->save();
        
        $result["res"] = "success";
        return $result;
    }

    // public function changeStatusGroup(Request $request)
    // {
    //     $this->authorize('changeStatusGroup',Order::class);
    //     $result = [];
    //     if(isset($request->items)){
    //         foreach($request->items as $id){
    //             $order = Order::find($id);
    //             if($order->status == 0){
    //                 $order->status = 1;
    //             }
    //             else if ($order->status == 1)
    //                 $order->status = 0;
    //             $order->save();
    //         }
    //         $result["res"] = "success";
    //         $result["message"] = "موارد انتخابی با موفقیت تغییر وضعیت یافت .";
    //     }
    //     else
    //     {
    //         $result["res"] = "error";
    //         $result["message"] = "لطفا ابتداسطرهای مورد نظر را انتخاب کنید.";
    //     }
    //     return $result;
    // }

    public function getPostInfo(Request $request)
    {
        // dd($request->all());
        $order = Order::find($request->order_id);
        // $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        // $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
         
        // $post_date= str_replace($persian, $english, $order->post_date);
        $data['code'] = $order->post_code;
        $data['date'] = Verta($order->post_date)->format('Y/m/d H:m:s');
        // $data['date'] = $order->post_date;
        // dd($data);
        return $data;
    }

    public function savePostInfo(Request $request)
    {
        $this->authorize('savePostInfo',Order::class);
        // dd($request->all());
        $order = Order::find($request->order_id);
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
         
        $post_date= str_replace($persian, $english, $request->post_date);
        $post_date = Verta::parse($post_date);
        $post_date = $post_date->dateTime();

        $order->post_code = $request->post_code;
        $order->post_date = $post_date;
        $order->save();
        return Verta($post_date)->format('Y/m/d H:m:s');
        
    }

    public function printAddresses( $items)
    {
        // dd($items);
        $items = json_decode($items);
        // var_dump($items);
        $orders = Order::whereIn('id',$items)
            ->get();
        // dd(storage_path()."/app/public/Addresses.docx");
        $source = storage_path()."/app/public/Addresses.docx";

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($source);
        $values = [];
        foreach ($orders as $order) {
           array_push($values, [
                        "order_id"=>"",
                        "receiver"=>$order->recipient->city->name.", ".$order->recipient->subcity->name.", ".$order->recipient->address.", پلاک  ".$order->recipient->houseId."جناب ".$order->recipient->name." ".$order->recipient->family,
                        "mobile"=>$order->recipient->mobile,
                        "zipcode"=>$order->recipient->zipcode,
                        ]
                     );
        }

        // $templateProcessor->cloneRowAndSetValues('order_id', $values);
        $templateProcessor->cloneBlock('block', 0, true, false, $values);
        $destination = storage_path()."/app/public/downloadAddresses.docx";

        $templateProcessor->saveAs($destination);

        return response()->download($destination);
    }

    public function printAddress($id)
    {
        if (isset($id)){
            $orders = Order::where('id',$id)
                ->get();
            // dd($orders);
            $source = storage_path()."/app/public/Address.docx";
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($source);
            $values = [];
            foreach ($orders as $order) {
               array_push($values, [
                            "receiver"=>$order->recipient->city->name.", ".$order->recipient->subcity->name.", ".$order->recipient->address.", پلاک  ".$order->recipient->houseId."جناب ".$order->recipient->name." ".$order->recipient->family,
                            "mobile"=>$order->recipient->mobile,
                            "zipcode"=>$order->recipient->zipcode,
                            ]
                         );
            }

            $templateProcessor->cloneBlock('block', 0, true, false, $values);
            $destination = storage_path()."/app/public/downloadAddress.docx";
            // dd($destination);
            $templateProcessor->saveAs($destination);

            // $headers = [
            //     'Content-Description: File Transfer',
            //     'Content-Type: application/octet-stream',
            //     'Content-Disposition: attachment; filename="downloadAddress.docx"',
            //     'Expires: 0',
            //     'Cache-Control: must-revalidate',
            //     'Pragma: public'
            // ];

            return response()->download($destination);
        }
    }

    public function unsuccessOrders()
    {
        $list = Payment::with('order')
            ->where('tracing_code','=','')
            ->orWhere('res_code','<>','0')
            ->get()
            ->sortbyDesc('created_at');
        $list = $list->filter(function($item){
            // dd($item);
            if ($item->order == "") {
                return false;
            }
            else if ($item->tracing_code == '' or $item->res_code != 0) {
                return true;
            }
            else
                return false;
        });
        // dd($list);
        return view('order.unsuccess-orders')
            ->with('list',$list);
    }


}
