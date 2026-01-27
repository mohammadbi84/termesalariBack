<?php

namespace App\Http\Controllers;

use App\Popup;
use App\PopupImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PopupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'getActive']);
    }

    public function index()
    {
        $popups = Popup::withCount('images')
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('popup.index', compact('popups'));
    }

    public function create()
    {
        return view('popup.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_fa' => 'required|string|max:255',
            'description_fa' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'orders' => 'nullable|array',
            'orders.*' => 'nullable|integer|min:0',
            'durations' => 'nullable|array',
            'durations.*' => 'nullable|integer|min:1',
        ], [
            'title_fa.required' => 'عنوان فارسی الزامی است.',
            'link.url' => 'لینک وارد شده معتبر نیست.',
            'images.*.image' => 'فایل باید تصویر باشد.',
            'images.*.max' => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',
            'end_at.after_or_equal' => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        try {
            $popup = Popup::create($data);

            // ذخیره تصاویر
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $pathName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move('file/popup/', $pathName);
                    $path = 'file/popup/' . $pathName;

                    PopupImage::create([
                        'popup_id' => $popup->id,
                        'image' => $path,
                        'order' => $data['orders'][$index] ?? $index,
                        'duration' => $data['durations'][$index] ?? 5000, // پیش‌فرض 3 ثانیه
                    ]);
                }
            }

            return redirect()->route('popup.index')
                ->with('success', 'پاپ‌آپ با موفقیت ایجاد شد.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در ایجاد پاپ‌آپ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Popup $popup)
    {
        $popup->load(['images' => function($query) {
            $query->orderBy('order');
        }]);

        return view('popup.edit', compact('popup'));
    }

    public function update(Request $request, Popup $popup)
    {
        $validator = Validator::make($request->all(), [
            'title_fa' => 'required|string|max:255',
            'description_fa' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'orders' => 'nullable|array',
            'orders.*' => 'nullable|integer|min:0',
            'durations' => 'nullable|array',
            'durations.*' => 'nullable|integer|min:1',
            'existing_images' => 'nullable|array',
            'existing_orders' => 'nullable|array',
            'existing_durations' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        try {
            // بروزرسانی اطلاعات پاپ‌آپ
            $popup->update($data);

            // بروزرسانی تصاویر موجود
            if ($request->has('existing_images')) {
                foreach ($popup->images as $image) {
                    if (in_array($image->id, $request->existing_images ?? [])) {
                        $index = array_search($image->id, $request->existing_images);
                        $image->update([
                            'order' => $request->existing_orders[$index] ?? $image->order,
                            'duration' => $request->existing_durations[$index] ?? $image->duration,
                        ]);
                    }
                }
            }

            // افزودن تصاویر جدید
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $pathName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move('file/popup/', $pathName);
                    $path = 'file/popup/' . $pathName;

                    PopupImage::create([
                        'popup_id' => $popup->id,
                        'image' => $path,
                        'order' => $data['orders'][$index] ?? $index,
                        'duration' => $data['durations'][$index] ?? 5000, // پیش‌فرض 3 ثانیه
                    ]);
                }
            }

            return redirect()->route('popup.index')
                ->with('success', 'پاپ‌آپ با موفقیت بروزرسانی شد.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در بروزرسانی پاپ‌آپ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Popup $popup)
    {
        try {
            // حذف تصاویر از استوریج
            foreach ($popup->images as $image) {
                if (File::exists($image->image)) {
                    File::delete($image->image);
                }
            }

            $popup->delete();

            return response()->json([
                'success' => true,
                'message' => 'پاپ‌آپ با موفقیت حذف شد.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف پاپ‌آپ: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteImage(PopupImage $image)
    {
        try {
            if (File::exists($image->image)) {
                    File::delete($image->image);
                }
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'تصویر با موفقیت حذف شد.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف تصویر: ' . $e->getMessage()
            ], 500);
        }
    }

    public function changeVisibility(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:popups,id'
        ]);

        try {
            $popup = Popup::findOrFail($request->id);
            $popup->update([
                'is_active' => !$popup->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'وضعیت پاپ‌آپ تغییر کرد',
                'is_active' => $popup->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر وضعیت'
            ], 500);
        }
    }

    /**
     * دریافت پاپ‌آپ فعال (برای استفاده در فرانت)
     */
    public function getActive()
    {
        $popup = Popup::active()
            ->with(['images' => function($query) {
                $query->orderBy('order');
            }])
            ->first();

        if (!$popup) {
            return response()->json([
                'active' => false,
                'message' => 'No active popup'
            ]);
        }

        return response()->json([
            'active' => true,
            'popup' => [
                'title' => app()->getLocale() == 'fa' ? $popup->title_fa : $popup->title_en,
                'description' => app()->getLocale() == 'fa' ? $popup->description_fa : $popup->description_en,
                'link' => $popup->link,
                'images' => $popup->images->map(function($image) {
                    return [
                        'url' => $image->image_url,
                        'duration' => $image->duration ?? 3000,
                    ];
                }),
            ]
        ]);
    }

    public function getActivePopup()
{
    try {
        // دریافت پاپ‌آپ فعال
        $popup = Popup::active()
            ->with(['images' => function($query) {
                $query->orderBy('order');
            }])
            ->latest()
            ->first();

        // اگر پاپ‌آپ فعالی وجود ندارد
        if (!$popup) {
            return response()->json([
                'success' => false,
                'message' => 'No active popup found',
                'data' => null
            ]);
        }

        // انتخاب زبان بر اساس لوکال
        $locale = App::getLocale();
        $isRtl = in_array($locale, ['fa', 'ar']);

        // ساخت پاسخ
        $response = [
            'success' => true,
            'data' => [
                'id' => $popup->id,
                'title' => $locale === 'fa' ? $popup->title_fa : $popup->title_en,
                'description' => $locale === 'fa' ? $popup->description_fa : $popup->description_en,
                'link' => $popup->link,
                'is_active' => $popup->is_active,
                'start_at' => $popup->start_at ? $popup->start_at->format('Y-m-d H:i:s') : null,
                'end_at' => $popup->end_at ? $popup->end_at->format('Y-m-d H:i:s') : null,
                'is_rtl' => $isRtl,
                'images' => $popup->images->map(function($image) {
                    return [
                        'id' => $image->id,
                        'url' => asset('storage/' . $image->image),
                        'order' => $image->order,
                        'duration' => $image->duration ?? 3000,
                        'created_at' => $image->created_at->format('Y-m-d H:i:s'),
                    ];
                })->toArray(),
                'created_at' => $popup->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $popup->updated_at->format('Y-m-d H:i:s'),
            ]
        ];

        // ذخیره کوکی برای نمایش یک بار در روز
        return response()->json($response)
            ->cookie('popup_last_shown', $popup->id, 1440); // 24 ساعت

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching popup: ' . $e->getMessage(),
            'data' => null
        ], 500);
    }
}
}
