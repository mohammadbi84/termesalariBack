<?php

namespace App\Http\Controllers;

use App\TrustSection;
use App\TrustCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrustSectionController extends Controller
{
    public function edit()
    {
        $section = TrustSection::with('counters')->first();
        return view('trust.edit', compact('section'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_fa' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_fa' => 'nullable|string',
            'description_en' => 'nullable|string',
            'counters.*.title_fa' => 'nullable|string|max:255',
            'counters.*.title_en' => 'nullable|string|max:255',
            'counters.*.number' => 'nullable|numeric',
        ]);

        DB::beginTransaction();

        try {

            $section = TrustSection::first() ?? new TrustSection();

            $section->title_fa = $request->title_fa;
            $section->title_en = $request->title_en;
            $section->description_fa = $request->description_fa;
            $section->description_en = $request->description_en;

            $section->save();

            // حذف قبلی‌ها
            $section->counters()->delete();

            // ثبت جدیدها
            if ($request->has('counters')) {
                foreach ($request->counters as $index => $counter) {

                    if (!empty($counter['title_fa']) || !empty($counter['title_en'])) {

                        TrustCounter::create([
                            'trust_section_id' => $section->id,
                            'title_fa' => $counter['title_fa'] ?? null,
                            'title_en' => $counter['title_en'] ?? null,
                            'number' => $counter['number'] ?? 0,
                            'order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return back()->with('success','بخش اعتماد به ما با موفقیت ذخیره شد.');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('danger','خطا در ذخیره اطلاعات');
        }
    }
}
