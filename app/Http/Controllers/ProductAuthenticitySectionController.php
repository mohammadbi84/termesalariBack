<?php

namespace App\Http\Controllers;

use App\ProductAuthenticitySection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductAuthenticitySectionController extends Controller
{
    public function edit()
    {
        $section = ProductAuthenticitySection::first();
        return view('product-authenticity.edit', compact('section'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_fa' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_fa' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'background_image' => 'nullable|image|max:4096',
        ]);

        DB::beginTransaction();

        try {

            $section = ProductAuthenticitySection::first() ?? new ProductAuthenticitySection();

            $section->title_fa = $request->title_fa;
            $section->title_en = $request->title_en;

            $section->description_fa = $request->description_fa;
            $section->description_en = $request->description_en;

            // تصویر اصلی
            if ($request->hasFile('image')) {
                if ($section->image) {
                    Storage::delete($section->image);
                }

                $section->image = $request->file('image')
                    ->store('authenticity', 'public');
            }

            // بک گراند
            if ($request->hasFile('background_image')) {
                if ($section->background_image) {
                    Storage::delete($section->background_image);
                }

                $section->background_image = $request->file('background_image')
                    ->store('authenticity', 'public');
            }

            $section->save();

            DB::commit();

            return back()->with('success', 'بخش نشان اصالت با موفقیت ذخیره شد.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('danger', 'خطا در ذخیره اطلاعات');
        }
    }
}
