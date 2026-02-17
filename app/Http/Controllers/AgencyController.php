<?php

namespace App\Http\Controllers;

use App\Agency;
use App\City;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::with('city', 'state')
            ->latest()
            ->paginate(15);

        return view('agency.index', compact('agencies'));
    }

    /* =========================
        فرم ایجاد
    ========================= */
    public function create()
    {
        $cities = City::orderBy('name')->where('parent', null)->get();
        return view('agency.create', compact('cities'));
    }

    /* =========================
        ذخیره
    ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'name_fa' => 'required|string',
            'name_en' => 'required|string',
            'image' => 'nullable|image',
            'address_fa' => 'required',
            'address_en' => 'required',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:cities,id',
            'slider_images.*' => 'nullable|image',
        ]);

        DB::beginTransaction();

        try {

            /* ---------- عکس اصلی ---------- */
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('agencies', 'public');
            }


            $socialLinks = [];
            if ($request->has('social') && is_array($request->social)) {
                foreach ($request->social as $item) {
                    if (!empty($item['platform']) && !empty($item['url'])) {
                        $socialLinks[] = [
                            'platform' => $item['platform'],
                            'url' => $item['url']
                        ];
                    }
                }
            }
            /* ---------- ساخت نمایندگی ---------- */
            $agency = Agency::create([
                'name_fa' => $request->name_fa,
                'name_en' => $request->name_en,
                'image' => $imagePath,
                'address_fa' => $request->address_fa,
                'address_en' => $request->address_en,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'social_links' => $socialLinks,
            ]);

            /* ---------- تصاویر اسلایدر ---------- */
            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $key => $image) {
                    $path = $image->store('public/images/');

                    $img = new Image;
                    $img->name = basename($path);
                    $img->imageable()->associate($agency);
                    $img->ordering = $key++;
                    $img->save();
                }
            }

            DB::commit();

            return redirect()
                ->route('agency.index')
                ->with('success', 'نمایندگی با موفقیت ایجاد شد');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withErrors('خطا در ذخیره اطلاعات');
        }
    }

    /* =========================
        فرم ویرایش
    ========================= */
    public function edit(Agency $agency)
    {
        $cities = City::orderBy('name')->where('parent', null)->get();

        return view('agency.edit', compact('agency', 'cities'));
    }

    /* =========================
        آپدیت
    ========================= */
    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'name_fa' => 'required|string',
            'name_en' => 'required|string',
            'image' => 'nullable|image',
            'address_fa' => 'required',
            'address_en' => 'required',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:cities,id',
            'slider_images.*' => 'nullable|image',
        ]);

        DB::beginTransaction();

        try {

            /* ---------- عکس اصلی ---------- */
            if ($request->hasFile('image')) {

                if ($agency->image) {
                    Storage::disk('public')->delete($agency->image);
                }

                $agency->image = $request->file('image')
                    ->store('agencies', 'public');
            }

            /* ---------- آپدیت اطلاعات ---------- */
            $agency->update([
                'name_fa' => $request->name_fa,
                'name_en' => $request->name_en,
                'address_fa' => $request->address_fa,
                'address_en' => $request->address_en,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'city_id' => $request->city_id,
                'state_id' => $request->state_id,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'social_links' => [
                    'instagram' => $request->instagram,
                    'telegram' => $request->telegram,
                    'whatsapp' => $request->whatsapp,
                ],
            ]);

            /* ---------- افزودن تصاویر جدید ---------- */
            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $key => $image) {

                    $path = $image->store('public/images/');

                    $img = new Image;
                    $img->name = basename($path);
                    $img->imageable()->associate($agency);
                    $img->ordering = $key++;
                    $img->save();
                }
            }

            DB::commit();

            return redirect()
                ->route('agency.index')
                ->with('success', 'نمایندگی با موفقیت بروزرسانی شد');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withErrors('خطا در بروزرسانی اطلاعات');
        }
    }

    /* =========================
        حذف
    ========================= */
    public function destroy(Agency $agency)
    {
        if ($agency->image) {
            Storage::disk('public')->delete($agency->image);
        }

        $agency->delete();

        return back()->with('success', 'نمایندگی حذف شد');
    }

    public function deleteMainImage(Agency $agency)
    {
        // بررسی وجود فایل
        if ($agency->image && Storage::disk('public')->exists($agency->image)) {
            Storage::disk('public')->delete($agency->image);
        }

        // به‌روزرسانی فیلد image به null
        $agency->update(['image' => null]);

        return response()->json(['success' => true]);
    }

    /**
     * حذف یک تصویر از اسلایدر
     */
    public function deleteSliderImage(Image $sliderImage)
    {
        // حذف فایل از storage
        if ($sliderImage->name && Storage::disk('public')->exists($sliderImage->path)) {
            Storage::disk('public')->delete($sliderImage->path);
        }

        // حذف رکورد از دیتابیس
        $sliderImage->delete();

        return response()->json(['success' => true]);
    }

    public function getByProvince($provinceId)
    {
        $cities = City::where('parent', $provinceId)->get(['id', 'name']);
        return response()->json($cities);
    }
}
