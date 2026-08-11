<?php

namespace App\Http\Controllers;

use App\Amazing;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class AmazingController extends Controller
{
    public function index($model, $id)
    {
        $class = "App\\" . $model;
        $product = $class::find($id);
        $amazings = Amazing::where("productable_type", $class)
            ->where("productable_id", $id)
            ->get();

        return view('amazing.index', compact('amazings', 'product'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $model, $id)
    {
        $request->validate([
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'max_sale' => 'nullable|numeric',
            'discount' => 'required|numeric',
        ], [
            'start_date.required' => 'تاریخ شروع ازامی است.',
            'end_date.required' => 'تاریخ شروع ازامی است.',
            'discount.required' => 'تاریخ شروع ازامی است.',
        ]);

        $class = "App\\" . $model;
        $product = $class::find($id);

        if ($request->max_sale && $request->max_sale > $product->quantity) {
            return redirect()->back()
                ->with('danger', 'حدا اکثر فروش نباید بیشتر از موجودی انبار باشد.')->withInput();
        }

        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        date_default_timezone_set('Asia/Tehran');
        $start_date = str_replace($persian, $english, $request->start_date);
        $expire_date = str_replace($persian, $english, $request->end_date);
        $start_date = Verta::parse($start_date);
        $expire_date = Verta::parse($expire_date);
        if ($expire_date->lte($start_date)) {
            return redirect()->back()
                ->with('danger', 'تاریخ انقضا نباید برابر یا قبل از تاریخ شروع اعتبار باشد .')->withInput();
        }

        $start_date = $start_date->dateTime();
        $expire_date = $expire_date->dateTime();

        if (
            $product->amazings()->where('start_date', '>=', $start_date)->where('start_date', '<=', $expire_date)->first()
            || $product->amazings()->where('end_date', '>=', $start_date)->where('end_date', '<=', $expire_date)->first()
        ) {
            return redirect()->back()
                ->with('danger', 'در این بازه تاریخی شگفت انگیز وجود دارد')->withInput();
        }

        $amazing = Amazing::create([
            'productable_type' => $class,
            'productable_id' => $id,
            'start_date' => $start_date,
            'end_date' => $expire_date,
            'max_sale' => $request->max_sale,
            'discount' => $request->discount,
        ]);
        return redirect()->back()->with('success', 'شگفت انگیز با موفقیت اضافه شد.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $amazing = Amazing::find($id);
        $amazing->delete();

        $result["res"] = "success";
        $result["message"] = "شگفت انگیز با موفقیت حذف شد.";
        return $result;
    }

    public function changeActive(Request $request)
    {
        $amazing = Amazing::find($request->id);
        $result["message"] = "";
        if ($amazing->start_date >= now()) {
            if ($amazing->active == 0) {
                $amazing->active = 1;
                $result["message"] = "شگفت انگیز انتخابی  فعال شد.";
            } else if ($amazing->active == 1) {
                $amazing->active = 0;
                $result["message"] = "شگفت انگیز انتخابی  غیرفعال شد.";
            }
            $amazing->save();

            $result["res"] = "success";
            return $result;
        }
        $result["message"] = "تاریخ شروع شگفت انگیز گذشته.";
        $result["res"] = "error";
        return $result;
    }
}
