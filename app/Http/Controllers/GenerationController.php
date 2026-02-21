<?php

namespace App\Http\Controllers;

use App\Generation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generations = Generation::all();
        return view('generation.index', compact('generations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('generation.create');
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
            'name_fa' => 'required',
            'name_en' => 'required',
            'pretext_fa' => 'required',
            'pretext_en' => 'required',
            'description_fa' => 'required',
            'description_en' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $input = $request->all();
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('generation', 'public');
        }
        $input['image'] = $imagePath;
        Generation::create($input);
        return redirect()->route('generation.index')->with('success', 'رکورد با موفقیت اضافه شد');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Generation  $generation
     * @return \Illuminate\Http\Response
     */
    public function edit(Generation $generation)
    {
        return view('generation.edit',compact('generation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Generation  $generation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Generation $generation)
    {
        $request->validate([
            'name_fa' => 'required',
            'name_en' => 'required',
            'pretext_fa' => 'required',
            'pretext_en' => 'required',
            'description_fa' => 'required',
            'description_en' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $input = $request->all();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('generation', 'public');
            $input['image'] = $imagePath;
        } else {
            unset($input['image']);
        }
        $generation->update($input);
        return redirect()->route('generation.index')->with('success', 'رکورد با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Generation  $generation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Generation $generation)
    {
        if ($generation->image) {
            Storage::disk('public')->delete($generation->image);
        }
        $generation->delete();
        return redirect()->route('generation.index')->with('success', 'رکورد با موفقیت حذف شد');
    }
}
