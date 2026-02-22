<?php

namespace App\Http\Controllers;

use App\MissionSection;
use App\MissionCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MissionSectionController extends Controller
{
    public function edit()
    {
        $mission = MissionSection::with('counters')->first();

        return view('mission.edit', compact('mission'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_fa' => 'nullable|string|max:255',
            'description_fa' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'video_cover' => 'nullable|image|max:4096',
            'counters.*.title_fa' => 'nullable|string|max:255',
            'counters.*.title_en' => 'nullable|string|max:255',
            'counters.*.number' => 'nullable|numeric',
        ]);

        DB::beginTransaction();

        try {

            $mission = MissionSection::first() ?? new MissionSection();

            $mission->title_fa = $request->title_fa;
            $mission->description_fa = $request->description_fa;
            $mission->title_en = $request->title_en;
            $mission->description_en = $request->description_en;

            // آپلود ویدیو
            if ($request->hasFile('video')) {
                if ($mission->video_path) {
                    Storage::delete($mission->video_path);
                }

                $mission->video_path = $request->file('video')->store('mission/videos', 'public');
            }

            // آپلود کاور
            if ($request->hasFile('video_cover')) {
                if ($mission->video_cover) {
                    Storage::delete($mission->video_cover);
                }

                $mission->video_cover = $request->file('video_cover')->store('mission/covers', 'public');
            }

            $mission->save();

            // حذف شمارنده‌های قبلی
            $mission->counters()->delete();

            // ثبت شمارنده‌های جدید
            if ($request->has('counters')) {
                foreach ($request->counters as $index => $counter) {

                    if (!empty($counter['title_fa'])) {

                        MissionCounter::create([
                            'mission_section_id' => $mission->id,
                            'title_fa' => $counter['title_fa'],
                            'title_en' => $counter['title_en'],
                            'number' => $counter['number'] ?? 0,
                            'order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return back()->with('success', 'بخش رسالت با موفقیت ذخیره شد.');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'خطا در ذخیره اطلاعات');
        }
    }
}
