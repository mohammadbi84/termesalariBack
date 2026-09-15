@extends('shop.layouts.master')
@section('title', $article->title)
@section('head')
    @if (app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('shop/css/ltr/product.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('shop/css/product.css') }}">
    @endif
    <style>
        :root {
            --primary: #4FBA6C;
            --primary-dark: #3da45b;
            --primary-soft: #eefaf1;
            --text: #252525;
            --muted: #8b8b8b;
            --border: #ececec;
            --bg: #fff;
            --card-radius: 14px;
            --shadow: 0 6px 24px rgba(0, 0, 0, .055);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page-wrap {
            /* max-width: 1180px; */
            margin: 0 auto;
            padding: 35px 18px 70px;
            margin-top: 100px;
        }

        /* ---------- Common ---------- */
        .soft-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
        }

        .section-title {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            padding-right: 13px;
            font-size: 16px;
            font-weight: 700;
        }

        .section-title::before {
            content: "";
            position: absolute;
            right: 0;
            top: 7px;
            width: 4px;
            height: 25px;
            border-radius: 5px;
            background: var(--primary);
        }

        .btn-primary-soft {
            border: 1px solid rgba(79, 186, 108, .25);
            background: var(--primary-soft);
            color: var(--primary-dark);
            border-radius: 9px;
            font-size: 12px;
            padding: 5px 12px;
        }

        .btn-primary-soft:hover {
            background: var(--primary);
            color: #fff;
        }

        /* ---------- Article ---------- */
        .article-hero {
            overflow: hidden;
            border-radius: 14px;
            position: relative;
            background: #e8e8e8;
            aspect-ratio: 16 / 7.1;
        }

        .article-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .article-category {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            border: 1px solid rgba(79, 186, 108, .18);
            border-radius: 8px;
            padding: 2px 10px;
            font-size: 11px;
            margin-top: 12px;
        }

        .article-title {
            font-size: 20px;
            line-height: 1.8;
            font-weight: 800;
            margin: 8px 0 7px;
        }

        .article-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            color: #929292;
            font-size: 11px;
        }

        .article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .article-meta i {
            color: var(--primary);
        }

        .article-content-card {
            margin-top: 26px;
            padding: 25px 28px;
            position: relative;
        }

        .article-content-card::before {
            content: "";
            position: absolute;
            top: 18px;
            right: 0;
            width: 4px;
            height: 36px;
            border-radius: 5px 0 0 5px;
            background: var(--primary);
        }

        .content-heading {
            font-size: 15px;
            font-weight: 800;
            border-bottom: 1px solid var(--border);
            padding-bottom: 13px;
            margin-bottom: 20px;
        }

        .article-body {
            color: #686868;
            font-size: 13px;
            line-height: 2.35;
        }

        .article-body h2,
        .article-body h3 {
            color: #333;
            font-weight: 800;
            margin: 28px 0 12px;
        }

        .article-body h2 {
            font-size: 19px;
        }

        .article-body h3 {
            font-size: 16px;
        }

        .article-body p {
            margin-bottom: 16px;
        }

        .article-body blockquote {
            margin: 22px 0;
            padding: 12px 17px;
            border-right: 3px solid var(--primary);
            background: var(--primary-soft);
            color: #4e7459;
            border-radius: 7px;
        }

        .article-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            border-top: 1px solid var(--border);
            margin-top: 25px;
            padding-top: 14px;
            color: #8e8e8e;
            font-size: 11px;
        }

        .share-list {
            display: flex;
            align-items: center;
            gap: 6px;
            direction: ltr;
        }

        .share-list a {
            width: 27px;
            height: 27px;
            border: 1px solid #e7e7e7;
            border-radius: 7px;
            display: grid;
            place-items: center;
            color: #777;
            transition: .2s;
        }

        .share-list a:hover {
            color: #fff;
            background: var(--primary);
            border-color: var(--primary);
        }

        /* ---------- Comment login ---------- */
        .comment-login {
            margin-top: 22px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            color: #777;
            font-size: 12px;
        }

        .comment-login .alert-icon {
            color: #ef5350;
            font-size: 18px;
        }

        .comment-login a {
            color: var(--primary-dark);
            font-weight: 700;
        }

        /* ---------- Sidebar ---------- */
        .search-box {
            height: 47px;
            position: relative;
            margin-bottom: 17px;
        }

        .search-box input {
            width: 100%;
            height: 100%;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 0 15px 0 45px;
            outline: none;
            font-size: 12px;
            color: #555;
            transition: .2s;
            box-shadow: var(--shadow);
        }

        .search-box input:focus {
            border-color: rgba(79, 186, 108, .5);
            box-shadow: 0 0 0 3px rgba(79, 186, 108, .08);
        }

        .search-box button {
            position: absolute;
            left: 7px;
            top: 6px;
            width: 35px;
            height: 35px;
            border: 0;
            background: transparent;
            color: #aaa;
            font-size: 17px;
        }

        .sidebar-card {
            padding: 16px 17px;
            margin-bottom: 17px;
        }

        .sidebar-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            font-weight: 700;
        }

        .sidebar-heading i {
            color: var(--primary);
            font-size: 18px;
        }

        .post-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 0;
            border-bottom: 1px dashed #e7e7e7;
        }

        .post-item:last-child {
            border-bottom: 0;
            padding-bottom: 2px;
        }

        .post-thumb {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #fff;
            box-shadow: 0 2px 9px rgba(0, 0, 0, .12);
        }

        .post-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-info {
            min-width: 0;
            flex: 1;
        }

        .post-info .title {
            display: block;
            color: #555;
            font-size: 11px;
            line-height: 1.8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .post-stats {
            display: flex;
            gap: 12px;
            color: #aaa;
            font-size: 10px;
            margin-top: 1px;
        }

        .post-stats span {
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            padding-top: 7px;
        }

        .tag {
            padding: 3px 10px;
            border: 1px solid #e5e5e5;
            border-radius: 7px;
            color: #777;
            font-size: 10px;
            transition: .2s;
        }

        .tag:hover {
            border-color: rgba(79, 186, 108, .35);
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        /* ---------- Related ---------- */
        .related-section {
            margin-top: 48px;
        }

        .related-section .section-title {
            margin-bottom: 18px;
        }

        .splide__track {
            padding: 2px 1px 12px;
        }

        .related-card {
            height: 100%;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .045);
            transition: transform .2s, box-shadow .2s;
        }

        .related-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .related-image {
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: #eee;
        }

        .related-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }

        .related-card:hover .related-image img {
            transform: scale(1.035);
        }

        .related-body {
            padding: 11px 13px 9px;
        }

        .related-body h3 {
            margin: 0 0 4px;
            font-size: 12px;
            line-height: 1.8;
            font-weight: 800;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-body p {
            margin: 0;
            color: #999;
            font-size: 10px;
            line-height: 1.9;
        }

        .related-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 13px;
            border-top: 1px solid #f1f1f1;
            color: #aaa;
            font-size: 10px;
        }

        .author {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .author img {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            object-fit: cover;
        }

        .splide__arrow {
            background: #fff;
            border: 1px solid #e4e4e4;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
        }

        .splide__arrow svg {
            fill: var(--primary-dark);
        }

        .splide__pagination__page.is-active {
            background: var(--primary);
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 991.98px) {
            .page-wrap {
                padding-top: 20px;
            }

            .sidebar {
                order: 2;
            }

            .main-content {
                order: 1;
            }

            .article-title {
                font-size: 20px;
            }
        }

        @media (max-width: 575.98px) {
            body {
                font-size: 13px;
            }

            .page-wrap {
                padding-inline: 12px;
            }

            .article-content-card {
                padding: 20px 16px;
            }

            .article-title {
                font-size: 18px;
            }

            .article-hero {
                aspect-ratio: 16 / 9;
            }

            .article-bottom {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-title {
                font-size: 14px;
            }
        }

        .article-search-results {
            position: relative;
            z-index: 20;
            margin-top: -17px;
            margin-bottom: 17px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 0 0 12px 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .07);
            overflow: hidden;
        }

        .article-search-result {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            transition: .2s;
        }

        .article-search-result:last-child {
            border-bottom: 0;
        }

        .article-search-result:hover {
            background: var(--primary-soft);
        }

        .article-search-result-image {
            width: 55px;
            height: 55px;
            flex: 0 0 55px;
            border-radius: 8px;
            overflow: hidden;
            background: #eee;
        }

        .article-search-result-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-search-result-info {
            min-width: 0;
            flex: 1;
        }

        .article-search-result-title {
            display: block;
            color: #444;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.8;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .article-search-result-date {
            display: block;
            margin-top: 3px;
            color: #aaa;
            font-size: 9px;
        }

        .article-search-result-date i {
            color: var(--primary);
        }

        .article-search-empty {
            padding: 18px 12px;
            text-align: center;
            color: #999;
            font-size: 11px;
        }

        .article-search-empty i {
            display: block;
            color: var(--primary);
            font-size: 24px;
            margin-bottom: 5px;
        }

        .article-search-loading {
            padding: 15px;
            text-align: center;
            color: #999;
            font-size: 11px;
        }

        .article-search-loading i {
            color: var(--primary);
            margin-left: 5px;
        }

        .fixed_top {
            position: sticky;
            top: 100px;
        }
    </style>
    <style>
        .article-slide {
            height: auto;
        }

        .article-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(255, 250, 242, 0.96) 0%, rgba(255, 255, 255, 1) 100%);
            border: 1px solid rgba(74, 148, 84, 0.18);
            border-radius: 14px;
            box-shadow: 0 8px 10px rgba(40, 32, 20, 0.08);
            text-decoration: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .article-card:hover {
            border-top: 3px solid var(--primary-color);
            border-right: 3px solid var(--primary-color);
            text-decoration: none;
        }

        .article-card__image-wrap {
            position: relative;
            overflow: hidden;
            background: #e7f4eb;
        }

        .article-card__image {
            display: block;
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .article-card:hover .article-card__image {
            transform: scale(1.05);
        }

        .article-card__badge {
            position: absolute;
            top: 16px;
            right: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(39, 49, 38, 0.8);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
        }

        .article-card__body {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding: 18px 18px 20px;
        }

        .article-card__title {
            margin: 0 0 10px;
            font-size: 1.1rem;
            line-height: 1.8rem;
            font-weight: 700;
            color: #1f2a2b;
        }

        .article-card__summary {
            margin: 0;
            color: #5e656d;
            font-size: 0.9rem;
            line-height: 1.7;
            text-align: justify;
        }

        .article-card__link {
            margin-top: 18px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #2aab5c;
            font-size: 0.88rem;
            font-weight: 700;
            transition: gap 0.2s ease;
        }

        .article-card:hover .article-card__link {
            gap: 12px;
        }

        @media (max-width: 575.98px) {
            .article-card__image {
                height: 200px;
            }
        }
    </style>
@endsection
@section('content')
    <main class="page-wrap container">

        <div class="row g-4">

            <!-- Main article -->
            <section class="col-lg-8 main-content">

                <article>

                    <div class="article-hero">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="article-title">
                            {{ $article->title }}
                        </h1>

                        <div class="article-meta">
                            <span>{{$article->comments()->where('status', 1)->count()}} {{ __('user.comments.card_title') }} <i class="bi bi-chat"></i></span>
                            <span>{{ $article->views()->count() }} {{ __('main.view') }} <i class="bi bi-eye"></i></span>
                            <span>admin <i class="bi bi-person"></i></span>
                        </div>
                    </div>

                    <div class="soft-card article-content-card">

                        <div class="content-heading">
                            <i class="bi bi-file-earmark-text me-1" style="color:var(--primary)"></i>
                            {{ __('article.article_description') }}
                        </div>

                        <div class="article-body">
                            {!! $article->body !!}
                        </div>

                        <div class="article-bottom">
                            <span>
                                <i class="bi bi-calendar3 ms-1"></i>
                                {{ __('article.last_update') }}: {{ Verta($article->updated_at)->format('%d %B %Y') }}
                            </span>

                            <div class="share-list">
                                <a href="#" id="share-btn"><i class="fa-solid fa-share-nodes"></i></a>
                                <span class="me-1">{{ __('product.share') }}</span>
                            </div>
                        </div>

                    </div>

                </article>

            </section>


            <!-- Sidebar -->
            <aside class="col-lg-4 sidebar">

                <div class="fixed_top">
                    <div class="search-wrapper">

                        <div class="search-box">
                            <input type="text" id="article-search" placeholder="{{ __('article.search_placeholder') }}"
                                autocomplete="off">

                            <button type="button" id="article-search-btn"
                                aria-label="{{ __('article.search_placeholder') }}">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                        {{-- نتایج سرچ --}}
                        <div id="article-search-results"></div>

                    </div>

                    <div class="soft-card sidebar-card">
                        <div class="sidebar-heading">
                            <span>{{ __('article.latest_posts') }}</span>
                        </div>
                        @foreach ($articles as $other_article)
                            <a href="{{ route('article.show', $other_article) }}" class="post-item">
                                <div class="post-thumb">
                                    <img src="{{ asset('storage/' . $other_article->image) }}" alt="">
                                </div>
                                <div class="post-info">
                                    <span class="title">{{ $other_article->title }}</span>
                                    <div class="post-stats">
                                        <span><i
                                                class="bi bi-calendar3"></i>{{ Verta($other_article->updated_at)->format('%d %B %Y') }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if ($article->tags()->count())
                        <div class="soft-card sidebar-card">
                            <div class="sidebar-heading">
                                <span>{{ __('article.tags') }}</span>
                                <i class="bi bi-tags"></i>
                            </div>

                            <div class="tags">
                                @foreach ($article->tags as $tag)
                                    <span class="tag">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-4 p-4 shadow-sm">
                        <div class="sidebar-heading">
                            <span>{{ __('product.comments_title') }}</span>
                            <i class="fa-regular fa-comments info-badge-icon"></i>
                        </div>
                        <form action="/comment" method="POST" class="">
                            @csrf
                            <input type="hidden" name="product" value="{{ $article->id }}">
                            <input type="hidden" name="model" value="Article">
                            <div class="mb-4">
                                <div class="autocomplete @error('text') filled @enderror" id="autocompleteBoxtext">
                                    <input type="text" id="searchInputtext" value="{{ old('text') }}" class=""
                                        name="text" oninput="nameinput('text')">
                                    <label for="searchInputtext">
                                        {{ __('article.comment_placeholder') }}
                                    </label>
                                    <span class="clear-btn" id="clearBtn_text" onclick="clearInput('text')"
                                        @if (old('text')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('text')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                {{ __('article.your_rating') }} :
                                <!-- ریتینگ ستاره‌ها -->
                                <div class="rating-stars">
                                    <span class="star" data-value="1">★</span>
                                    <span class="star" data-value="2">★</span>
                                    <span class="star" data-value="3">★</span>
                                    <span class="star" data-value="4">★</span>
                                    <span class="star" data-value="5">★</span>
                                </div>

                                <!-- اینپوت مخفی برای ذخیره امتیاز -->
                                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 0) }}">
                            </div>
                            @if (Auth::check())
                                <button type="submit"
                                    class="btn btn-primary w-50 mb-3">{{ __('product.submit_comment') }}</button>
                            @else
                                <button type="submit" class="btn btn-primary w-50 mb-3">
                                    {{ __('product.submit_comment') }}
                                </button>
                            @endif
                        </form>
                    </div>
                </div>

            </aside>

        </div>

        <!-- Related articles -->
        @if ($articles->count())
            <!-- start articles -->
            <section id="articles" class="related-section">
                <div class="container mb-5 px-0">
                    <div class=" d-flex align-items-center justify-content-between w-100  p-2">
                        <div class="d-flex align-items-center gap-2">
                            <h4 class="title m-0">{{ __('main.articles') }}</h4>
                        </div>
                        <div class="">
                            <!-- دکمه‌های کنترل جداگانه -->
                            <div class="custom-splide-controls">
                                <button class="splide-prev-btn splide-article-prev-btn">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                                <span id="article-range" class="slide-range">1-4</span>
                                <button class="splide-next-btn splide-article-next-btn">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="splide" id="article_slider" role="group" aria-label="Splide Basic HTML Example">
                        <div class="splide__track py-3">
                            <ul class="splide__list">
                                @foreach ($articles as $key => $other_article)
                                    @php
                                        $other_articlePreview = \Illuminate\Support\Str::limit(
                                            strip_tags($other_article->body ?? ''),
                                            90
                                        );
                                    @endphp
                                    <li class="splide__slide article-slide">
                                        <a href="{{ route('article.show', [$other_article]) }}" class="article-card"
                                            aria-label="{{ $other_article->title }}">
                                            <div class="article-card__image-wrap">
                                                <img class="article-card__image"
                                                    src="{{ 'storage/' . $other_article->image }}"
                                                    alt="{{ $other_article->title }}" />
                                            </div>
                                            <div class="article-card__body">
                                                <h3 class="article-card__title">{{ $other_article->title }}</h3>
                                                @if (!empty($other_articlePreview))
                                                    <p class="article-card__summary">{{ $other_articlePreview }}</p>
                                                @endif
                                                <span class="article-card__link">
                                                    {{ __('main.moreInfo') }}
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end articles -->
        @endif

        <div class="bg-white gap-5 rounded-4 shadow-sm p-3 mt-5">
            <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                {{-- <i class="fa-solid fa-info info-badge-icon top-0"></i> --}}
                <i class="fa-regular fa-comments info-badge-icon"></i>
                <div>
                    <h5 class="m-0">{{ __('product.user_comments') }}</h5>
                    <span class="point-span">
                        {{ __('article.comments_count', ['count' => $article->comments()->where('status', 1)->count()]) }}
                    </span>
                </div>
            </div>
            @foreach ($article->comments()->where('status', 1)->get() as $comment)
                <div class="col-12 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 d-flex justify-content-start align-items-center gap-3">
                            <img src="{{ asset('storetemplate/dist/img/' . $comment->user->image) }}"
                                class="rounded-circle" alt="user" width="60">
                            <div class="">
                                <strong>{{ $comment->user->name }} {{ $comment->user->family }}</strong> - <span
                                    class="point-span">{{ Verta($comment->created_at)->format('%d %B %Y') }}</span>
                                <p class="m-0 text-justify">
                                    {{ $comment->text }}
                                </p>
                            </div>
                        </div>
                        <div class="">
                            <div class="rating">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $comment->score ?? 0)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    @if ($articles->count())
        <script>
            // Article===========================================================================================
            var ArticleSplide = new Splide("#article_slider", {
                perPage: 4,
                padding: "20px",
                gap: "1.7rem",
                arrows: false,
                pagination: false,
                direction: "rtl",
                breakpoints: {
                    1024: {
                        perPage: 4
                    },
                    768: {
                        perPage: 2,
                        focus: "start",
                        padding: {
                            left: "50px"
                        }
                    },
                    480: {
                        perPage: 1,
                        focus: "start",
                        padding: {
                            left: "150px"
                        }
                    },
                },
            });
            ArticleSplide.mount();

            const prevBtnArticle = document.querySelector(".splide-article-prev-btn");
            const nextBtnArticle = document.querySelector(".splide-article-next-btn");

            // اضافه کردن event listener برای دکمه‌ها
            if (prevBtnArticle) {
                prevBtnArticle.addEventListener("click", function() {
                    ArticleSplide.go("<");
                });
            }

            if (nextBtnArticle) {
                nextBtnArticle.addEventListener("click", function() {
                    ArticleSplide.go(">");
                });
            }

            // به‌روزرسانی وضعیت دکمه‌ها هنگام تغییر اسلاید
            ArticleSplide.on("moved", function() {
                updateButtonStatesArticle();
                updateRangeDisplay(ArticleSplide, "article-range");
            });

            // تابع برای به‌روزرسانی وضعیت دکمه‌ها
            function updateButtonStatesArticle() {
                const index = ArticleSplide.index;
                const length = ArticleSplide.length;

                if (prevBtnArticle) {
                    prevBtnArticle.disabled = index === 0;
                }

                if (nextBtnArticle) {
                    nextBtnArticle.disabled = index >= length - ArticleSplide.options.perPage;
                }
            }

            // مقداردهی اولیه وضعیت دکمه‌ها
            updateButtonStatesArticle();
            updateRangeDisplay(ArticleSplide, "article-range");

            // تابع برای به‌روزرسانی نمایش بازه
            function updateRangeDisplay(splide, rangeElementId) {
                const index = splide.index; // شماره اولین آیتم قابل مشاهده (صفر شروع)
                const perPage = splide.options.perPage;
                const total = splide.length;

                const start = index + 1; // چون index از 0 شروع میشه
                const end = Math.min(index + perPage, total);

                document.getElementById(rangeElementId).textContent = `${start}-${end}`;
            }
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#share-btn').click(function(e) {
                e.preventDefault();
                if (navigator.share) {
                    navigator.share({
                        title: "{{ $article->title }}",
                        text: "{{ __('article.share_text') }}{{ $article->title }}",
                        url: "{{ url()->current() }}"
                    }).catch((error) => console.log('Error sharing:', error));
                } else {
                    alert("{{ __('article.share_not_supported') }}");
                }
            });
        });

        $(document).ready(function() {

            let searchTimeout = null;

            const $searchInput = $('#article-search');
            const $searchResults = $('#article-search-results');

            function searchArticles() {
                const keyword = $searchInput.val().trim();

                if (keyword.length === 0) {
                    $searchResults.html('');
                    return;
                }

                if (keyword.length < 2) {
                    $searchResults.html('');
                    return;
                }

                $searchResults.html(`
                <div class="article-search-results">
                    <div class="article-search-loading">
                        <i class="bi bi-arrow-repeat"></i>
                        {{ __('article.searching') }}
                    </div>
                </div>
            `);

                $.ajax({
                    url: "{{ route('article.search') }}",
                    type: "GET",
                    data: {
                        q: keyword
                    },
                    success: function(response) {
                        $searchResults.html(response);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        $searchResults.html(`
                        <div class="article-search-results">
                            <div class="article-search-empty">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ __('article.search_error') }}
                            </div>
                        </div>
                    `);
                    }
                });
            }

            $searchInput.on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    searchArticles();
                }, 400);
            });

            $('#article-search-btn').on('click', function() {
                clearTimeout(searchTimeout);
                searchArticles();
            });

            $searchInput.on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    searchArticles();
                }
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-wrapper').length) {
                    $searchResults.html('');
                }
            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');

            // ستاره‌های قبلی انتخاب شده
            stars.forEach(star => {
                if (star.dataset.value <= ratingInput.value) {
                    star.classList.add('active');
                }
            });

            // هاور روی ستاره‌ها
            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const value = this.dataset.value;

                    stars.forEach(s => {
                        s.classList.remove('active');
                        if (s.dataset.value <= value) {
                            s.classList.add('active');
                        }
                    });
                });
            });

            // کلیک روی ستاره
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.dataset.value;
                    ratingInput.value = value;

                    stars.forEach(s => {
                        s.classList.remove('active');
                        if (s.dataset.value <= value) {
                            s.classList.add('active');
                        }
                    });
                });
            });

            // وقتی موس از روی ریتینگ خارج شد
            document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
                const currentValue = ratingInput.value;

                stars.forEach(s => {
                    s.classList.remove('active');
                    if (s.dataset.value <= currentValue) {
                        s.classList.add('active');
                    }
                });
            });
        });


        document.getElementById("comment_btn")?.addEventListener("click", function() {
            Swal.fire({
                title: `
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('hometemplate/img/logo.png') }}" width="30">
                                    <h2 class="title m-0">{{ __('js.login_title') }}</h2>
                                </div>`,
                html: `
                        <form id="loginAjaxForm">
                            <div class="mx-5 text-center">
                                <div class="mb-3 mt-4">
                                    <div class="autocomplete" id="autocompleteBoxlogin">
                                        <input type="text" id="searchInputlogin" class=""
                                            oninput="nameinput('login')">
                                        <label for="searchInputlogin">{{ __('js.login_mobile_or_email') }}</label>
                                        <span class="clear-btn" id="clearBtn_login" onclick="clearInput('login')"
                                            >×</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="autocomplete" id="autocompleteBoxpassword">
                                        <input type="password" id="searchInputpassword" class="" name="password"
                                            oninput="nameinput('password')">
                                        <label for="searchInputpassword">{{ __('js.login_password') }}</label>
                                        <span class="clear-btn" id="clearBtn_password" onclick="clearInput('password')">×</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">{{ __('js.login_button') }}</button>
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <div class="mb-2"><a href="{{ route('password.request') }}">{{ __('js.forgot_password') }}</a>
                                        </div>
                                    @endif
                                    <div class="mb-2">{{ __('js.no_account') }} <a href="{{ route('register') }}">{{ __('js.register_link') }}</a></div>
                                </div>
                            </div>
                        </form>
                        `,
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                allowOutsideClick: true
            });

            // ارسال فرم لاگین با ایجکس
            $(document).on("submit", "#loginAjaxForm", function(e) {
                e.preventDefault();

                $.ajax({
                    url: "/login", // مسیر Laravel login
                    type: "POST",
                    data: {
                        login: $("#searchInputlogin").val(),
                        password: $("#searchInputpassword").val(),
                        _token: '<?php echo csrf_token(); ?>',
                    },
                    success: function(res) {
                        Swal.close();

                        Swal.fire({
                            icon: "success",
                            title: "{{ __('js.login_success') }}",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => location.reload(), 1200);
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "{{ __('js.login_failed') }}",
                            text: "{{ __('js.login_failed_text') }}"
                        });
                    }
                });
            });

        });

        $(document).on("input", ".only-number", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
            let name = $(this).attr("name");
            const box = document.getElementById("autocompleteBox" + name);
            const clearBtn = document.getElementById("clearBtn_" + name);
            let value2 = $(this).val();
            if (value2.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = "block";
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = "none";
            }
        });

        function nameinput(id) {
            const input = document.getElementById("searchInput" + id);
            const box = document.getElementById("autocompleteBox" + id);
            const clearBtn = document.getElementById("clearBtn_" + id);
            if (input.value.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = "block";
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = "none";
            }
        }

        function clearInput(id) {
            const box = document.getElementById("autocompleteBox" + id);
            box.classList.remove("filled");
            const input = document.getElementById("searchInput" + id);
            input.value = "";
            const clearBtn = document.getElementById("clearBtn_" + id);
            clearBtn.style.display = "none";

            if (id == "state") {
                const box2 = document.getElementById("autocompleteBoxcity");
                const input2 = document.getElementById("searchInputcity");
                input2.value = "";
                document.getElementById("selectedIdcity").value = "";
                box2.classList.remove("filled");
                const clearBtn2 = document.getElementById("clearBtn_city");
                clearBtn2.style.display = "none";
            }
        }
    </script>
@endsection
