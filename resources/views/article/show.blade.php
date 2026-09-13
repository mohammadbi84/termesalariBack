@extends('shop.layouts.master')
@section('title', $article->title)
@section('head')
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
                            <span><i class="bi bi-person"></i> admin</span>
                            <span><i class="bi bi-chat"></i> 7 دیدگاه</span>
                            <span><i class="bi bi-eye"></i> {{$article->views()->count()}} بازدید</span>
                        </div>
                    </div>

                    <div class="soft-card article-content-card">

                        <div class="content-heading">
                            <i class="bi bi-file-earmark-text me-1" style="color:var(--primary)"></i>
                            توضیحات مقاله
                        </div>

                        <div class="article-body">
                            {!! $article->body !!}
                        </div>

                        <div class="article-bottom">
                            <span>
                                <i class="bi bi-calendar3 ms-1"></i>
                                آخرین بروزرسانی: {{ Verta($article->updated_at)->format('%d %B %Y') }}
                            </span>

                            <div class="share-list">
                                <a href="#" id="share-btn"><i class="fa-solid fa-share-nodes"></i></a>
                                <span class="me-1">اشتراک‌گذاری</span>
                            </div>
                        </div>

                    </div>

                </article>

            </section>


            <!-- Sidebar -->
            <aside class="col-lg-4 sidebar">

                <div class="search-box">
                    <input type="text" placeholder="جستجو در مقالات">
                    <button type="button" aria-label="جستجو">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <div class="soft-card sidebar-card">
                    <div class="sidebar-heading">
                        <span>آخرین پست‌ها</span>
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
                                            class="bi bi-calendar3"></i>{{ Verta($other_article->created_at)->format('%d %B %Y') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="soft-card sidebar-card">
                    <div class="sidebar-heading">
                        <span>برچسب‌ها</span>
                        <i class="bi bi-tags"></i>
                    </div>

                    <div class="tags">
                        <a href="#" class="tag">ترمه</a>
                        <a href="#" class="tag">رومیزی</a>
                        <a href="#" class="tag">رومیزی ترمه</a>
                        <a href="#" class="tag">ترمه یزد</a>
                        <a href="#" class="tag">ترمه سالاری</a>
                    </div>
                </div>

            </aside>
        </div>

        <!-- Related articles -->
        @if ($articles->count())
            <section class="related-section">

                <div class="section-title">
                    <span>مقالات مرتبط</span>
                    {{-- <a href="#" class="btn-primary-soft">مشاهده همه</a> --}}
                </div>

                <div id="relatedPosts" class="splide" aria-label="مقالات مرتبط">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($articles as $other_article)
                                <li class="splide__slide">
                                    <a href="{{ route('article.show', $other_article->id) }}" class="related-card d-block">
                                        <div class="related-image">
                                            <img src="{{ asset('storage/' . $other_article->image) }}"
                                                alt="{{ $other_article->title }}">
                                        </div>
                                        <div class="related-body">
                                            <h3>{{ $other_article->title }}</h3>
                                        </div>
                                        <div class="related-footer">
                                            <span><i class="bi bi-calendar3"></i>
                                                {{ Verta($other_article->created_at)->format('%d %B %Y') }}</span>
                                            <span class="author">
                                            admin
                                        </span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </section>
        @endif
    </main>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    @if ($articles->count())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Splide('#relatedPosts', {
                    direction: 'rtl',
                    type: 'slide',
                    perPage: 4,
                    perMove: 1,
                    gap: '14px',
                    pagination: false,
                    breakpoints: {
                        992: {
                            perPage: 3
                        },
                        768: {
                            perPage: 2
                        },
                        576: {
                            perPage: 1
                        }
                    }
                }).mount();
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#share-btn').click(function(e) {
                e.preventDefault();
                if (navigator.share) {
                    navigator.share({
                        title: "{{ $article->title }}",
                        text: "مشترک عزیز، این مقاله را ببینید: {{ $article->title }}",
                        url: "{{ url()->current() }}"
                    }).catch((error) => console.log('Error sharing:', error));
                } else {
                    alert("مرورگر شما قابلیت اشتراک‌گذاری مستقیم را پشتیبانی نمی‌کند.");
                }
            });
        });
    </script>
@endsection
