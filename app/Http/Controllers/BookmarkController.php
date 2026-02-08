<?php

namespace App\Http\Controllers;

use App\Bookmark;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookmarks = Bookmark::orderBy('created_at','desc')->get();
        return view('bookmark.index', compact('bookmarks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last = Bookmark::orderByDesc('sort')->first();
        return view('bookmark.create',compact('last'));
    }

    function convertNumbersToEnglish($string)
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persianNumbers, $englishNumbers, $string);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_fa' => 'required|string',
            'title_en' => 'required|string',
            'body_fa' => 'required|string',
            'body_en' => 'required|string',
            'sort' => 'nullable|unique:bookmarks,sort',
            'start_at' => 'nullable',
            'end_at' => 'nullable',
            'active' => 'boolean',
            'height' => 'nullable|integer',
            'duration' => 'nullable',
        ]);

        $data = $request->all();

        // ابتدا مقادیر شمسی از فرم رو بگیریم
        $startAtShamsi = $request->start_at; // ۱۴۰۴/۱۱/۱۲ ۱۶:۵۴:۵۲
        $endAtShamsi   = $request->end_at;

        $startAtShamsi = $this->convertNumbersToEnglish($startAtShamsi);
        $endAtShamsi   = $this->convertNumbersToEnglish($endAtShamsi);

        $data['start_at'] = $startAtShamsi ? Verta::parse($startAtShamsi)->subDay(1)->datetime() : null;
        $data['end_at']   = $endAtShamsi   ? Verta::parse($endAtShamsi)->subDay(1)->datetime() : null;



        $bookmark = Bookmark::create($data);

        return redirect()->route('bookmark.index')->with('success', 'بوکمارک با موفقیت اضافه شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $bookmark) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        return view('bookmark.edit', compact('bookmark'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        $request->validate([
            'title_fa' => 'required|string',
            'title_en' => 'required|string',
            'body_fa' => 'required|string',
            'body_en' => 'required|string',
            'sort' => 'nullable',
            'start_at' => 'nullable',
            'end_at' => 'nullable',
            'active' => 'boolean',
            'height' => 'nullable',
            'duration' => 'nullable',
        ]);

        $data = $request->all();

        // ابتدا مقادیر شمسی از فرم رو بگیریم
        $startAtShamsi = $request->start_at; // ۱۴۰۴/۱۱/۱۲ ۱۶:۵۴:۵۲
        $endAtShamsi   = $request->end_at;

        $startAtShamsi = $this->convertNumbersToEnglish($startAtShamsi);
        $endAtShamsi   = $this->convertNumbersToEnglish($endAtShamsi);

        $data['start_at'] = $startAtShamsi ? Verta::parse($startAtShamsi)->subDay(1)->datetime() : null;
        $data['end_at']   = $endAtShamsi   ? Verta::parse($endAtShamsi)->subDay(1)->datetime() : null;



        $bookmark->update($data);

        return redirect()->route('bookmark.index')->with('success', 'بوکمارک با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();
        return redirect()->back()->with('success', 'بوکمارک با موفقیت حذف شد.');
    }

    public function changeVisibility(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bookmarks,id'
        ]);

        try {
            $bookmark = Bookmark::findOrFail($request->id);
            $bookmark->update([
                'active' => !$bookmark->active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'وضعیت پاپ‌آپ تغییر کرد',
                'is_active' => $bookmark->active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر وضعیت'
            ], 500);
        }
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/editor/', $pathName);
            $path = 'file/editor/' . $pathName;

            return response()->json([
                'url' => asset($path)
            ]);
        }
    }
}
