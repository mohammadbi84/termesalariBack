<?php

namespace App\Http\Controllers;

use App\CertificateSection;
use App\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CertificateSectionController extends Controller
{
    public function edit()
    {
        $section = CertificateSection::with('certificates')->first();
        return view('certificates.edit', compact('section'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_fa' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_fa' => 'nullable|string',
            'description_en' => 'nullable|string',
            'certificates.*' => 'nullable|image|max:4096',
        ]);

        DB::beginTransaction();

        try {

            $section = CertificateSection::first() ?? new CertificateSection();

            $section->title_fa = $request->title_fa;
            $section->title_en = $request->title_en;
            $section->description_fa = $request->description_fa;
            $section->description_en = $request->description_en;

            $section->save();

            // اگر تصاویر جدید آپلود شد
            if ($request->hasFile('certificates')) {

                foreach ($request->file('certificates') as $index => $file) {

                    $path = $file->store('certificates', 'public');

                    Certificate::create([
                        'certificate_section_id' => $section->id,
                        'image' => $path,
                        'order' => $index,
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'بخش گواهی‌ها با موفقیت ذخیره شد.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('danger', 'خطا در ذخیره اطلاعات');
        }
    }
    public function delete($id)
    {
        $certificate = Certificate::findOrFail($id);

        Storage::delete($certificate->image);
        $certificate->delete();

        return response()->json(['success' => true]);
    }
}
