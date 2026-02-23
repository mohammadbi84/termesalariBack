<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // لیست مشتری‌ها
    public function index()
    {
        $clients = Client::orderBy('order')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    // ذخیره مشتری جدید
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('important-clients', 'public');
        }

        Client::create([
            'title' => $request->title,
            'image' => $imagePath,
            'order' => $request->order ?? 0,
        ]);

        return back()->with('success', 'مشتری با موفقیت اضافه شد.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // آپدیت
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $client->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('important-clients', 'public');
        }

        $client->update([
            'title' => $request->title,
            'image' => $imagePath,
            'order' => $request->order ?? 0,
        ]);

        return back()->with('success', 'ویرایش با موفقیت انجام شد.');
    }

    // حذف
    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success', 'حذف شد.');
    }
}
