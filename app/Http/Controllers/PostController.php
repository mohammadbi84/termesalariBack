<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|integer|min:0',
            'delivery_time' => 'required'
        ],[
            'title.required'=>'عنوان الزامی است',
            'price.required'=>'هزینه ارسال الزامی است',
            'price.integer'=>'هزینه ارسال باید عددی باشد',
            'delivery_time.required'=>'زمان ارسال الزامی است',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'price' => $request->price,
            'delivery_time' => $request->delivery_time,
        ]);

        return redirect()->route('post.index')->with('success', 'شیوه ارسال با موفقیت ذخیره شد');
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|integer|min:0',
            'delivery_time' => 'required'
        ],[
            'title.required'=>'عنوان الزامی است',
            'price.required'=>'هزینه ارسال الزامی است',
            'price.integer'=>'هزینه ارسال باید عددی باشد',
            'delivery_time.required'=>'زمان ارسال الزامی است',
        ]);

        $post->update([
            'title' => $request->title,
            'price' => $request->price,
            'delivery_time' => $request->delivery_time,
        ]);

        return redirect()->route('post.index')->with('success', 'شیوه ارسال با موفقیت ویرایش شد');
    }

    public function destroy(Post $post)
    {
        if (Post::where('active', 1)->where('id', '!=', $post->id)->count()) {
            $post->delete();

            $result["res"] = "success";
            $result["message"] = "شیوه ارسال با موفقیت حذف شد.";
            return $result;
            return redirect()->route('post.index')->with('success', 'شیوه ارسال با موفقیت حذف شد');
        } else {
            $result["res"] = "error";
            $result["message"] = "حداقل یک شیوه ارسال فعال باید وجود داشته باشد.";
            return $result;
            return redirect()->route('post.index')->with('danger', 'حداقل یک شیوه ارسال فعال باید وجود داشته باشد.');
        }
    }
}
