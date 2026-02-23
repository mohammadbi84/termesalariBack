<?php

namespace App\Http\Controllers;

use App\Mainvideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainvideoController extends Controller
{
    public function edit()
    {
        $video = Mainvideo::first();
        return view('video.edit', compact('video'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover' => 'nullable|image|max:10000',
            'video' => 'required|file|mimetypes:video/mp4,video/mkv|max:100000'
        ]);

        DB::beginTransaction();

        try {

            $video = Mainvideo::first() ?? new Mainvideo();
            $path = $request->cover->store('image', 'public');
            if ($request->video) {
                $pathVideo = $request->video->store('video', 'public');
            }


            $video->title = $request->title;
            $video->video = $pathVideo;
            $video->cover = $path;

            $video->save();

            DB::commit();

            return back()->with('success', 'ویدیو موفقیت ذخیره شد.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('danger', 'خطا در ذخیره اطلاعات');
        }
    }
}
