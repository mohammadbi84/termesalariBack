<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('article.index', compact('articles'));
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required',
            'e_title' => 'nullable|string',
            'e_body' => 'nullable|string',
            'ar_title' => 'nullable|string',
            'ar_body' => 'nullable|string',
            'image' => 'nullable'
        ], [
            'title.required' => 'عنوان مقاله الزامی میباشد.',
            'body.required' => 'محتوای مقاله الزامی میباشد.',
            'image.required' => 'عکس مقاله الزامی میباشد.',
            'e_title.string' => 'عنوان انگلیسی مقاله باید رشته باشد.',
            'e_body.string' => 'محتوای انگلیسی مقاله باید رشته باشد.',
            'ar_title.string' => 'عنوان عربی مقاله باید رشته باشد.',
            'ar_body.string' => 'محتوای عربی مقاله باید رشته باشد.',
        ]);
        $article = new Article();
        $article->title = $request->title;
        $article->body = $request->body;
        $article->e_title = $request->e_title;
        $article->e_body = $request->e_body;
        $article->ar_title = $request->ar_title;
        $article->ar_body = $request->ar_body;
        $article->image = $request->image;
        $article->save();
        return redirect()->route('article.index')->with('success', 'مقاله با موفقیت ساخته شد.');
    }

    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required',
            'e_title' => 'nullable|string',
            'e_body' => 'nullable|string',
            'ar_title' => 'nullable|string',
            'ar_body' => 'nullable|string',
            'image' => 'nullable'
        ], [
            'title.required' => 'عنوان مقاله الزامی میباشد.',
            'body.required' => 'محتوای مقاله الزامی میباشد.',
            'image.required' => 'عکس مقاله الزامی میباشد.',
            'e_title.string' => 'عنوان انگلیسی مقاله باید رشته باشد.',
            'e_body.string' => 'محتوای انگلیسی مقاله باید رشته باشد.',
            'ar_title.string' => 'عنوان عربی مقاله باید رشته باشد.',
            'ar_body.string' => 'محتوای عربی مقاله باید رشته باشد.',
        ]);
        $article->title = $request->title;
        $article->body = $request->body;
        $article->e_title = $request->e_title;
        $article->e_body = $request->e_body;
        $article->ar_title = $request->ar_title;
        $article->ar_body = $request->ar_body;
        $article->image = $request->image;
        $article->save();
        return redirect()->route('article.index')->with('success', 'مقاله با موفقیت ویرایش شد.');
    }
    public function change_active($id)
    {
        $article = Article::findOrFail($id);
        $article->is_active = !$article->is_active;
        $article->save();
        return redirect()->route('article.index')->with('success', 'وضعیت مقاله با موفقیت تغییر یافت.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('article.index')->with('success', 'مقاله با موفقیت حذف شد.');
    }
}
