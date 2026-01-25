@extends('shop.layouts.master')
@section('title', $title . ' طرح ' . $prayermat->color_design->design->title . ' رنگ ' .
    $prayermat->color_design->color->color)
@section('head')
    @if (app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('shop/css/product.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('shop/css/ltr/product.css') }}">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
@endsection
@section('content')
    <main>
        <div class="container py-4 mb-5" style="padding: 0 2rem !important;margin-top:100px">
            <!-- Breadcrumb -->
            <div class="row rounded-4 shadow-sm bg-white px-4 mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/store" class="text-decoration-none text-muted"><i
                                    class="fas fa-home"></i> {{ __('products.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('prayermat.storeIndex') }}"
                                class="text-decoration-none text-muted">{{ __('products.praymat_products') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $prayermat->category->title }} طرح {{ $prayermat->color_design->design->title }} رنگ
                            {{ $prayermat->color_design->color->color }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="row rounded-4 shadow-sm bg-white p-4 mb-5">
                @php
                    $images = $prayermat->images()->get()->sortby('ordering');
                    $prices = $prayermat->prices->where('local', 'تومان')->first();
                @endphp
                @php
                    $price = 0;
                    $off = 0;
                    if ($prices->offPrice > 0) {
                        if ($prices->offType == 'مبلغ') {
                            $price = $prices->price - $prices->offPrice;
                            $off = $prices->offPrice;
                        } elseif ($prices->offType == 'درصد') {
                            $off = $prices->price * ($prices->offPrice / 100);
                            $price = $prices->price - $off;
                        }
                    } else {
                        $price = $prices->price;
                    }
                @endphp

                <!-- Middle Column - Product Gallery -->
                <div class="col-lg-7 order-lg-1 mb-2 rounded-3 p-2">
                    <div class="product-gallery">
                        <!-- اسلایدر اصلی -->

                        <div class="swiper main-slider" id="mainSlider">
                            <div class="swiper-wrapper">
                                @foreach ($images as $key => $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/images/' . $image['name']) }}"
                                            style="border-radius: 10px;" alt="{{ $image['name'] }}"
                                            class="product-image-show"
                                            data-zoom-src="{{ asset('storage/images/' . $image['name']) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- لنز زوم -->
                        <div class="zoom-lens" id="zoomLens"></div>

                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-start align-items-center gap-2" style="margin-top: 10px;">
                            <a href="#" id="share-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ __('product.share') }}" class="share-btn telegram">
                                <i class="fa-solid fa-share-nodes"></i>
                            </a>
                            <a href="#" id="compare" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ __('product.compare') }}" class="share-btn telegram"
                                data-image="{{ asset('/storage/images/thumbnails/' . $prayermat->images->first()->name) }}"
                                data-moddel="{{ substr($prayermat->category->model, 4) }}"
                                data-design="{{ $prayermat->color_design->design->title ?? '' }}"
                                data-color="{{ $prayermat->color_design->color->color ?? '' }}"
                                data-title="{{ $prayermat->title }}" data-price="{{ $prices->price }}"
                                data-pay="{{ $price }}" data-off="{{ $off }}"
                                data-offType="{{ $prices->offType }}" data-local="{{ $prices->local }}"
                                data-id="{{ $prayermat->id }}"
                                data-model="{{ substr($prayermat->category->model, 4) }}">
                                <i class="fa-solid fa-shuffle"></i>
                            </a>
                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ __('product.wishlist') }}"
                                class="share-btn telegram  favorites-btn @if ($prayermat->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                data-image="{{ asset('/storage/images/thumbnails/' . $prayermat->images->first()->name) }}"
                                data-moddel="{{ substr($prayermat->category->model, 4) }}"
                                data-design="{{ $prayermat->color_design->design->title ?? '' }}"
                                data-color="{{ $prayermat->color_design->color->color ?? '' }}"
                                data-title="{{ $prayermat->title }}" data-price="{{ $prices->price }}"
                                data-pay="{{ $price }}" data-off="{{ $off }}"
                                data-offType="{{ $prices->offType }}" data-local="{{ $prices->local }}"
                                data-id="{{ $prayermat->id }}"
                                data-model="{{ substr($prayermat->category->model, 4) }}">
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                        <div class="w-100 d-flex justify-content-end align-items-center"
                            style="margin-top: 10px;position: relative;gap: 13px;">
                            <!-- دکمه مشاهده گالری -->
                            <div class="view-gallery mt-0" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <i class="fa-solid fa-expand" style="top: 0"></i>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>

                <!-- left Column - Additional Info -->
                <div class="col order-lg-3 mb-2">
                    <h1 class="product-title">
                        {{ $prayermat->category->title }} طرح
                        {{ $prayermat->color_design->design->title }} رنگ
                        {{ $prayermat->color_design->color->color }}
                    </h1>
                    <div class="rating">
                        @php
                            $score = $comments->sum('score') / ($comments->count() > 0 ? $comments->count() : 1);
                        @endphp
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $score ?? 0)
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor
                        <span class="text-muted">({{ number_format($score, 1) }} از ۵ - {{ $comments->count() }}
                            نظر)</span>
                    </div>
                    <ul class="product-specs ">
                        <li>{{ __('product.product_code') }}: {{ $prayermat->code }}</li>
                        <li>
                            {{ __('product.color_count') }}:
                            {{ $prayermat->color_design->design->countOfColor }}
                            {{ __('product.colors') }}
                        </li>
                        <li>{{ __('product.contains') }}: {{ $prayermat->contains }}</li>
                        <li>{{ __('product.color') }}: {{ $prayermat->color_design->color->color }}</li>
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="color-title">{{ __('product.category') }} :</h6>
                        <a href="{{ route('prayermat.storeIndex') }}"
                            class="tag">{{ $prayermat->category->title }}</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="color-title">{{ __('product.tags') }} :</h6>
                        <span class="tag">{{ $prayermat->color_design->design->title }}</span>
                    </div>
                    <div class="categories-tags">
                        <hr>
                        <div class="price-section text-start">
                            @if ($off > 0)
                                <span class="original-price">{{ number_format($prices->price) }} تومان</span>
                            @endif
                            <span class="discounted-price">{{ number_format($price) }} تومان</span>
                        </div>

                        <div class="stock-info">
                            <i class="fas fa-box-open ms-1"></i>
                            {{-- @if ($prayermat->quantity == 0)
                                <span class="text-bold"> اتمام موجودی در انبار </span>
                            @elseif($prayermat->quantity <= 5)
                            @elseif($prayermat->quantity > 5)
                            <span class="text-success text-bold"> موجود در انبار</span>
                            @endif --}}
                            <span class="text-bold">
                                {{ __('product.available_qty', ['count' => $prayermat->quantity]) }}
                            </span>
                        </div>
                        <div class="quantity-control">
                            <div class="quantity-controls gap-2">
                                <button class="minus-btn" data-model="{{ substr($prayermat->category->model, 4) }}"
                                    data-id="{{ $prayermat->id }}">-</button>
                                <span class="count item-quantity-product" id="item-quantity-product">1</span>
                                <button class="plus-btn" data-model="{{ substr($prayermat->category->model, 4) }}"
                                    data-id="{{ $prayermat->id }}">+</button>
                            </div>
                            <button class="btn btn-primary @if ($prayermat->quantity != 0) addToCart @endif"
                                data-image="{{ asset('/storage/images/thumbnails/' . $prayermat->images->first()->name) }}"
                                data-id="{{ $prayermat->id }}"
                                data-moddel="{{ substr($prayermat->category->model, 4) }}"
                                data-design="{{ $prayermat->color_design->design->title ?? '' }}"
                                data-color="{{ $prayermat->color_design->color->color ?? '' }}"
                                data-title="{{ $prayermat->title }}" data-price="{{ $prices->price }}"
                                data-pay="{{ $price }}" data-off="{{ $off }}"
                                data-offType="{{ $prices->offType }}"
                                data-local="{{ $prices->local }}">{{ __('product.add_to_cart') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row bg-white rounded-4 shadow-sm mb-5">
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/24hours.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">{{ __('product.guarantee_title') }}</h5>
                            <span class="point-span">{{ __('product.guarantee_sub') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/newest.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">{{ __('product.newest_title') }}</h5>
                            <span class="point-span">{{ __('product.newest_sub') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/offBadges.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">{{ __('product.discount_title') }}</h5>
                            <span class="point-span">{{ __('product.discount_sub') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/quality.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">{{ __('product.best_price_title') }}</h5>
                            <span class="point-span">{{ __('product.best_price_sub') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gap-5 mb-5">
                <div class="col p-0">
                    <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                        <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                            {{-- <i class="fa-solid fa-info info-badge-icon"></i> --}}
                            <i class="fa-solid fa-circle-info info-badge-icon"></i>
                            <h5 class="m-0">{{ __('product.description') }}</h5>
                        </div>
                        <p class="text-justify text-muted">
                            {{ $prayermat->description }}
                        </p>
                    </div>
                    <div class="bg-white rounded-4 p-4 shadow-sm">
                        <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                            <i class="fa-regular fa-comments info-badge-icon"></i>
                            <h5 class="m-0">{{ __('product.comments_title') }}</h5>
                        </div>
                        <form action="/comment" method="POST" class="">
                            @csrf
                            <input type="hidden" name="product" value="{{ $prayermat->id }}">
                            <input type="hidden" name="model" value="prayermat">
                            <div class="mb-4">
                                <div class="autocomplete @error('text') filled @enderror" id="autocompleteBoxtext">
                                    <input type="text" id="searchInputtext" value="{{ old('text') }}"
                                        class="" name="text" oninput="nameinput('text')">
                                    <label for="searchInputtext">
                                        {{ __('product.comment_placeholder') }}
                                    </label>
                                    <span class="clear-btn" id="clearBtn_text" onclick="clearInput('text')"
                                        @if (old('text')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('text')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                {{ __('product.your_rating') }} :
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
                                <button type="submit" class="btn btn-primary w-25 mb-3">ثبت دیدگاه</button>
                            @else
                                <button type="submit" class="btn btn-primary w-25 mb-3">
                                    {{ __('product.submit_comment') }}
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col bg-white rounded-4 p-4 shadow-sm">
                    <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                        {{-- <i class="fa-solid fa-info info-badge-icon"></i> --}}
                        <i class="fa-solid fa-circle-info info-badge-icon"></i>
                        <h5 class="m-0">{{ __('product.details') }}</h5>
                    </div>
                    <ul class="list-group list-group-flush p-0">
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.dimensions') }}</span>
                                <span class="point-span">{{ $prayermat->dimensions }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.weight') }}</span>
                                <span class="point-span">{{ $prayermat->weight }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.material') }}</span>
                                <span class="point-span">{{ $prayermat->kind }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.sewing_type') }}</span>
                                <span class="point-span">{{ $prayermat->sewingType }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.lining') }}</span>
                                <span class="point-span">{{ $prayermat->haveEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.lining_material') }}</span>
                                <span class="point-span">{{ $prayermat->kindOfEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.washable') }}</span>
                                <span class="point-span">{{ $prayermat->washable }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.uses') }}</span>
                                <span class="point-span">{{ $prayermat->uses }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @if ($likeprayermats->count() > 0)
                <div class="row mb-5 bg-white rounded-4 shadow-sm p-3">
                    {{-- <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                        <i class="fa-regular fa-comments info-badge-icon"></i>
                        <div>
                            <h5 class="m-0">محصولات مشابه</h5>
                        </div>
                    </div> --}}
                    <div class=" d-flex align-items-center justify-content-between w-100  p-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('shop/assets/svgs/cart-shopping-solid-full.svg') }}" alt="محصولات مشابه"
                                width="30">
                            <h2 class="title m-0">{{ __('product.related_products') }}</h2>
                        </div>
                        <div class="">
                            <!-- دکمه‌های کنترل جداگانه -->
                            <div class="custom-splide-controls">
                                <button class="splide-prev-btn splide-hot-prev-btn">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                                <span id="hot-range" class="slide-range">1-4</span>
                                <button class="splide-next-btn splide-hot-next-btn">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="splide" id="hot_slider" role="group" aria-label="Splide Basic HTML Example">
                        <div class="splide__track py-3">
                            <ul class="splide__list">
                                @foreach ($likeprayermats as $key => $prayermat)
                                    @php
                                        $prices = $prayermat->prices->where('local', 'تومان')->first();
                                    @endphp
                                    @php
                                        $price = 0;
                                        $off = 0;
                                        if ($prices->offPrice > 0) {
                                            if ($prices->offType == 'مبلغ') {
                                                $price = $prices->price - $prices->offPrice;
                                                $off = $prices->offPrice;
                                            } elseif ($prices->offType == 'درصد') {
                                                $off = $prices->price * ($prices->offPrice / 100);
                                                $price = $prices->price - $off;
                                            }
                                        } else {
                                            $price = $prices->price;
                                        }
                                    @endphp
                                    <li class="splide__slide">
                                        <div class="product-div p-2">
                                            <div class="hot-product-card">
                                                <div class="hot-image-container">
                                                    <img src="{{ asset('/storage/images/thumbnails/' . $prayermat->images->first()->name) }}"
                                                        alt="{{ $prayermat->category->title }}"
                                                        class="hot-product-image">
                                                </div>
                                                <div class="overlay">
                                                    <h3 class="product-title">
                                                        {{ $prayermat->category->title }} طرح
                                                        {{ $prayermat->color_design->design->title }}
                                                        رنگ
                                                        {{ $prayermat->color_design->color->color }}</h3>
                                                    <div
                                                        class="product-price w-100 d-flex justify-content-between align-items-center mb-2">
                                                        <div
                                                            class="d-flex align-items-center justify-content-center gap-2">
                                                            <a href="
                                                            @switch($prayermat->category->model)
                                                                @case('App\prayermat')
                                                                  {{ route('prayermat.show', [$prayermat->id]) }}
                                                                  @break
                                                                @case('App\prayermat')
                                                                  {{ route('prayermat.show', [$prayermat->id]) }}
                                                                  @break
                                                                @case('App\Prayermat')
                                                                  {{ route('prayermat.show', [$prayermat->id]) }}
                                                                  @break
                                                                @case('App\Bedcover')
                                                                  {{ route('bedcover.show', [$prayermat->id]) }}
                                                                  @break
                                                                @case('App\Shoe')
                                                                  {{ route('shoe.show', [$prayermat->id]) }}
                                                                  @break
                                                            @endswitch
                                                            "
                                                                class="buy-button text-decoration-none h-100 px-3 py-1">مشاهده</a>
                                                        </div>
                                                        <div class="d-flex flex-column hot-product-price">
                                                            @if ($prices->offPrice > 0)
                                                                <span
                                                                    class="d-flex align-items-center justify-content-between mb-1"
                                                                    dir="ltr"><del
                                                                        class="old-price">{{ number_format($prices->price) }}</del><span
                                                                        class="badge bg-danger">
                                                                        @if ($prices->offType == 'مبلغ')
                                                                            {{ round(($prices->offPrice * 100) / $prices->price, 0) }}%
                                                                        @elseif($prices->offType == 'درصد')
                                                                            {{ $prices->offPrice }}%
                                                                        @endif
                                                                    </span></span>
                                                                <span class="price">
                                                                    @if ($prices->offType == 'مبلغ')
                                                                        {{ number_format($prices->price - $prices->offPrice) }}
                                                                    @elseif($prices->offType == 'درصد')
                                                                        {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                                    @endif
                                                                    <svg viewBox="0 0 15 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg" width="20"
                                                                        height="20">
                                                                        <path
                                                                            d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                            fill="#A3A3A3"></path>
                                                                    </svg>
                                                                </span>
                                                            @else
                                                                <span class="price">{{ number_format($prices->price) }}
                                                                    <svg viewBox="0 0 15 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg" width="20"
                                                                        height="20">
                                                                        <path
                                                                            d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                            fill="#A3A3A3"></path>
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="px-1 pt-2 hot-description border-top d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <span class="fs-10">28 عدد فروش رفته</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                                        <button
                                                            class="buy-button shadow-none add-to-cart favorites-btn @if ($prayermat->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                            data-image="{{ asset('/storage/images/thumbnails/' . $prayermat->images->first()->name) }}"
                                                            data-moddel="{{ substr($prayermat->category->model, 4) }}"
                                                            data-design="{{ $prayermat->color_design->design->title ?? '' }}"
                                                            data-color="{{ $prayermat->color_design->color->color ?? '' }}"
                                                            data-title="{{ $prayermat->title }}"
                                                            data-price="{{ $prices->price }}"
                                                            data-pay="{{ $price }}"
                                                            data-off="{{ $off }}"
                                                            data-offType="{{ $prices->offType }}"
                                                            data-local="{{ $prices->local }}"
                                                            data-id="{{ $prayermat->id }}"
                                                            data-model="{{ substr($prayermat->category->model, 4) }}"
                                                            data-id="{{ $prayermat->id }}"
                                                            data-model="{{ substr($prayermat->category->model, 4) }}"
                                                            style="width:30px;height:30px"><i
                                                                class="@if ($prayermat->favorites->where('user_id', Auth::id())->count() > 0) fa-solid @else fa-regular @endif fa-heart text-danger"></i></button>
                                                        <button
                                                            class="buy-button shadow-none add-to-cart @if ($prayermat->quantity != 0) addToCart @endif"
                                                            style="width:30px;height:30px"
                                                            data-image="{{ asset('/storage/images/thumbnails/' . $prayermat->images->first()->name) }}"
                                                            data-id="{{ $prayermat->id }}"
                                                            data-moddel="{{ substr($prayermat->category->model, 4) }}"
                                                            data-design="{{ $prayermat->color_design->design->title ?? '' }}"
                                                            data-color="{{ $prayermat->color_design->color->color ?? '' }}"
                                                            data-title="{{ $prayermat->title }}"
                                                            data-price="{{ $prices->price }}"
                                                            data-pay="{{ $price }}"
                                                            data-off="{{ $off }}"
                                                            data-offType="{{ $prices->offType }}"
                                                            data-local="{{ $prices->local }}"><i
                                                                class="fa-solid fa-cart-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row bg-white gap-5 rounded-4 shadow-sm p-3">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                    {{-- <i class="fa-solid fa-info info-badge-icon top-0"></i> --}}
                    <i class="fa-regular fa-comments info-badge-icon"></i>
                    <div>
                        <h5 class="m-0">{{ __('product.user_comments') }}</h5>
                        <span class="point-span">
                            {{ __('product.comments_count', ['count' => $comments->count()]) }}
                        </span>
                    </div>
                </div>
                @foreach ($comments as $comment)
                    <div class="col-12 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1 d-flex justify-content-start align-items-center gap-3">
                                <img src="{{ asset('storetemplate/dist/img/' . $comment->user->image) }}"
                                    class="rounded-circle" alt="user" width="60">
                                <div class="">
                                    <strong>{{ $comment->user->name }} {{ $comment->user->family }}</strong> - <span
                                        class="point-span">{{ $comment->created_at->format('d F Y') }}</span>
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
        </div>
        <!-- Gallery Modal -->
        <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="galleryModalLabel">{{ __('product.gallery') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="swiper modal-swiper" id="modalSwiper">
                            <div class="swiper-wrapper">
                                @foreach ($images as $key => $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/images/' . $image['name']) }}"
                                            alt="{{ $image['name'] }}" class="product-image-show">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    @else
        <script src="{{ asset('shop/js/ltr/main-menu-full.js') }}"></script>
    @endif
    <script>
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
        $(document).ready(function() {
            $("#compare").click(function(event) {
                event.preventDefault();
                var id = $(this).data("id");
                var model = $(this).data("model");
                var $btn = $(this);
                const image = $btn.data('image');
                const title = $btn.data('title');
                const design = $btn.data('design');
                const color = $btn.data('color');
                const price = $btn.data('price');
                $.ajax({
                    type: "GET",
                    url: document.location.origin + "/compare/add",
                    data: {
                        id: id,
                        model: model,
                    },
                    success: function(data) {
                        document.querySelector(".compare-badge").textContent = data;
                        document.querySelector(".compare-items-count").textContent = data +
                            " کالا";
                        const $compList = $("#navbarCompareList"); // لیست داخل منو
                        const exists = $compList.find(
                            `.compare-item[data-id="${id}"][data-model="${model}"]`);
                        if (exists.length === 0) {
                            const newItem = `
                    <div class="compare-item"
                        data-id="${id}"
                        data-model="${model}" >
                        <img src="${image}"
                            alt="product" class="cart-item-image">
                        <div class="cart-item-content">
                            <div class="cart-item-title">
                                ${title} طرح ${design} رنگ ${color}
                            </div>
                            <div class="cart-item-price">
                                ${Number(price).toLocaleString()} تومان
                            </div>
                        </div>
                    </div>
                    `;

                            $compList.prepend(newItem);
                        }

                        Swal.fire({
                            icon: "success",
                            title: "عملیا با موفقیت انجام شد.",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                });
            });
            $('#share-btn').click(function(e) {
                e.preventDefault();
                if (navigator.share) {
                    navigator.share({
                        title: "{{ $prayermat->title }}",
                        text: "مشترک عزیز، این محصول را ببینید: {{ $prayermat->title }}",
                        url: "{{ url()->current() }}"
                    }).catch((error) => console.log('Error sharing:', error));
                } else {
                    alert("مرورگر شما قابلیت اشتراک‌گذاری مستقیم را پشتیبانی نمی‌کند.");
                }
            });

            // Initialize Swipers
            var mainSwiper = new Swiper("#mainSlider", {
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                loop: true,
            });

            var modalSwiper = new Swiper("#modalSwiper", {
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                loop: true,
            });

            // Quantity Control
            maxQuantity = {{ $prayermat->quantity }};
            $('.plus-btn').click(function() {
                var currentVal = parseInt($('#item-quantity-product').text());
                if (currentVal < maxQuantity) {
                    $('#item-quantity-product').text(currentVal + 1);
                }
            });

            $('.minus-btn').click(function() {
                var currentVal = parseInt($('#item-quantity-product').text());
                if (currentVal > 1) {
                    $('#item-quantity-product').text(currentVal - 1);
                }
            });

            // Add to Cart
            $('.add-to-cart-show').click(function() {
                var quantity = $('#item-quantity-product').text();
                alert(quantity + ' عدد از این محصول به سبد خرید اضافه شد');
            });

            // Countdown Timer
            function updateCountdown() {
                var now = new Date();
                var target = new Date(now);
                target.setDate(target.getDate() + 2); // 2 days from now

                var diff = target - now;

                var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                $('#countdown').text('زمان باقیمانده: ' + days + ' روز و ' + hours + ':' + minutes + ':' + seconds);
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();


            // مقدار زوم را اینجا تنظیم کن (1 = بدون زوم, 1.5 = یک ونیم برابر, 2 = دو برابر)
            let zoomLevel = 1.5;

            (function() {
                const lens = document.getElementById('zoomLens');
                let zoomImg = null;
                let currentImg = null;
                let handlers = {
                    mousemove: null,
                    mouseenter: null,
                    mouseleave: null
                };

                function cleanup() {
                    if (!currentImg) return;
                    currentImg.removeEventListener('mousemove', handlers.mousemove);
                    currentImg.removeEventListener('mouseenter', handlers.mouseenter);
                    currentImg.removeEventListener('mouseleave', handlers.mouseleave);
                    lens.innerHTML = '';
                    zoomImg = null;
                    currentImg = null;
                }

                function initImageZoom() {
                    cleanup();

                    const activeImg = document.querySelector(
                        '.main-slider .swiper-slide-active .product-image-show');
                    if (!activeImg) return;
                    currentImg = activeImg;

                    const src = activeImg.dataset.zoomSrc || activeImg.src;
                    zoomImg = new Image();
                    zoomImg.src = src;
                    zoomImg.alt = 'zoom';
                    lens.innerHTML = '';
                    lens.appendChild(zoomImg);

                    zoomImg.onload = () => {
                        // اندازهٔ طبیعی تصویر
                        const natW = zoomImg.naturalWidth;
                        const natH = zoomImg.naturalHeight;

                        // هندلرها
                        handlers.mouseenter = () => {
                            lens.style.opacity = '1';
                        };
                        handlers.mouseleave = () => {
                            lens.style.opacity = '0';
                        };

                        handlers.mousemove = (e) => {
                            const imgRect = currentImg
                                .getBoundingClientRect(); // نمایش شده در صفحه (width/height ممکن است کراپ شده)
                            const dispW = imgRect.width;
                            const dispH = imgRect.height;

                            // 1) محاسبهٔ فاکتور اسکیل که مرورگر برای object-fit: cover استفاده می‌کند
                            // s = max(displayWidth / naturalWidth, displayHeight / naturalHeight)
                            const s = Math.max(dispW / natW, dispH / natH);

                            // 2) اندازه تصویر اسکیل‌شده (scaled) که در واقع داخل باکس قرار می‌گیرد یا بزرگتر است
                            const scaledW = natW * s;
                            const scaledH = natH * s;

                            // 3) چون cover هست، بخشی از scaled image ممکنه بیرون بپره؛ offsetScaled نشان‌دهندهٔ مقدار کراپ شده از سمت چپ/بالا است
                            // offsetScaledX = (scaledW - dispW) / 2
                            // offsetScaledY = (scaledH - dispH) / 2
                            const offsetScaledX = (scaledW - dispW) / 2;
                            const offsetScaledY = (scaledH - dispH) / 2;

                            // 4) موقعیت موس نسبت به بالای-چپ تصویر نمایش داده‌شده
                            const mouseX = e.clientX - imgRect.left;
                            const mouseY = e.clientY - imgRect.top;

                            // جلوگیری اگر موس بیرون تصویر باشه
                            if (mouseX < 0 || mouseY < 0 || mouseX > dispW || mouseY > dispH) {
                                lens.style.opacity = '0';
                                return;
                            }

                            // 5) حالا مختصات نقطهٔ مربوطه در scaled image:
                            // scaledCoordX = offsetScaledX + mouseX
                            // scaledCoordY = offsetScaledY + mouseY
                            const scaledCoordX = offsetScaledX + mouseX;
                            const scaledCoordY = offsetScaledY + mouseY;

                            // 6) تبدیل مختصات scaled به مختصات natural (تقسیم بر s)
                            // naturalCoordX = scaledCoordX / s
                            // naturalCoordY = scaledCoordY / s
                            const naturalX = scaledCoordX / s;
                            const naturalY = scaledCoordY / s;

                            // 7) قرار دادن لنز: ما می‌خواهیم مرکز لنز روی موس باشد
                            const lensW = lens.offsetWidth;
                            const lensH = lens.offsetHeight;

                            let lensLeft = mouseX - lensW / 2;
                            let lensTop = mouseY - lensH / 2;

                            // محدود کردن داخل منطقهٔ نمایش‌شده
                            lensLeft = Math.max(0, Math.min(lensLeft, dispW - lensW));
                            lensTop = Math.max(0, Math.min(lensTop, dispH - lensH));

                            // تبدیل موقعیت لنز به مختصات نسبت به کانتینر .product-gallery
                            const galleryRect = currentImg.closest('.product-gallery')
                                .getBoundingClientRect();
                            const leftOnPage = imgRect.left - galleryRect.left + lensLeft;
                            const topOnPage = imgRect.top - galleryRect.top + lensTop;

                            lens.style.left = leftOnPage + 'px';
                            lens.style.top = topOnPage + 'px';

                            // 8) اندازهٔ تصویر داخل لنز بر اساس zoomLevel
                            const zoomedW = natW * zoomLevel;
                            const zoomedH = natH * zoomLevel;
                            zoomImg.style.width = zoomedW + 'px';
                            zoomImg.style.height = zoomedH + 'px';

                            // 9) حالا باید تصویر زوم‌شده طوری جابجا شود که naturalX,naturalY در مرکز لنز قرار گیرد:
                            // موقعیت دلخواه (در px) داخل تصویر زوم‌شده: (naturalX * zoomLevel, naturalY * zoomLevel)
                            // برای قرار دادن این نقطه در مرکز لنز، left = (naturalX * zoomLevel) - lensW/2  (و سپس منفی کنیم چون تصویر داخل لنز حرکت می‌کند)
                            let targetLeft = (naturalX * zoomLevel) - (lensW / 2);
                            let targetTop = (naturalY * zoomLevel) - (lensH / 2);

                            // محدودیت‌ها: تصویر زوم‌شده نباید بیرون برود (so clamp)
                            const maxShiftX = Math.max(0, zoomedW - lensW);
                            const maxShiftY = Math.max(0, zoomedH - lensH);

                            // clamp targetLeft to [0, maxShiftX], سپس اعمال منفی برای CSS left
                            targetLeft = Math.max(0, Math.min(targetLeft, maxShiftX));
                            targetTop = Math.max(0, Math.min(targetTop, maxShiftY));

                            zoomImg.style.left = (-targetLeft) + 'px';
                            zoomImg.style.top = (-targetTop) + 'px';
                        };

                        // وصل کردن هندلرها به تصویر فعلی
                        currentImg.addEventListener('mouseenter', handlers.mouseenter);
                        currentImg.addEventListener('mouseleave', handlers.mouseleave);
                        currentImg.addEventListener('mousemove', handlers.mousemove);
                    };
                }

                // init اولیه
                initImageZoom();

                // وقتی اسلایدر عوض شد دوباره init کن (و cleanup خودکار انجام می‌شود)
                if (typeof mainSwiper !== 'undefined' && mainSwiper.on) {
                    mainSwiper.on('slideChange', () => {
                        // کوچکترین تاخیر برای اطمینان از active class و layout
                        setTimeout(initImageZoom, 20);
                    });
                }

                // برای تغییر زوم از بیرون
                window.setZoomLevel = function(z) {
                    zoomLevel = Math.max(0.2, z);
                };

                // export برای تست
                window.initImageZoom = initImageZoom;
            })();

            // مخفی شدن لنز هنگام رفتن روی دکمه‌های اسلایدر
            $(".swiper-button-next, .swiper-button-prev").on("mouseenter", () => {
                $("#zoomLens").css("opacity", 0);
            });
            $(".swiper-button-next, .swiper-button-prev").on("mouseleave", () => {
                $("#zoomLens").css("opacity", 1);
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            // 🛒 افزودن محصول به سبد خرید
            $(document).on('click', '.addToCart', function() {
                const $btn = $(this);

                const card = $btn.closest('.product-card');
                if (card) {
                    card.removeClass('hovered'); // حذف کلاس
                }

                // برداشتن فوکوس از روی دکمه (مهم!)
                if (document.activeElement && document.activeElement instanceof HTMLElement) {
                    document.activeElement.blur();
                }

                // گرفتن اطلاعات از data attributes
                const id = $btn.data('id');
                const model = $btn.data('moddel');
                const price = $btn.data('price');
                const off = $btn.data('off');
                const offType = $btn.data('offType');
                const pay = $btn.data('pay');
                const local = $btn.data('local');
                const title = `${$btn.data('title')} طرح ${$btn.data('design')} رنگ ${$btn.data('color')}`;
                const image = $btn.data('image') || '/images/no-image.png';
                const quantity = parseInt($('#item-quantity-product').text()) || 1;
                const url = `${document.location.origin}/cart/add/${id}/${model}/${quantity}`;

                // درخواست AJAX
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        product: id,
                        controller: model
                    },
                    success: function(response) {
                        if (response == "1") {
                            // ✅ موفقیت
                            updateNavbarCart({
                                id,
                                title,
                                price,
                                image,
                                quantity: quantity,
                                model: model,
                                off: off,
                                offType: offType,
                            });

                            if (!$btn.hasClass("favorites")) {
                                Swal.fire({
                                    icon: "success",
                                    title: "محصول به سبد خرید اضافه شد!",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "خطا در افزودن محصول!",
                                text: "تعداد کالای درخواستی بیشتر از موجودی انبار است."
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "خطا در ارتباط با سرور!",
                            text: "اتصال اینترنت یا سرور بررسی شود."
                        });
                    }
                });
            });

            // 🧩 تابع برای آپدیت کردن dropdown در navbar
            function updateNavbarCart(item) {
                const $badge = $(".shopping-cart-badge");
                const $cartList = $("#navbarCartList");

                // افزایش badge
                let count = parseInt($badge.text()) || 0;
                $badge.text(count + 1);

                // چک وجود آیتم
                const existingItem = $cartList.find(`[data-id="${item.id}"][data-model="${item.model}"]`);

                if (existingItem.length > 0) {
                    // اگر بود، فقط تعداد را افزایش بده
                    const $quantitySpan = existingItem.find('.item-quantity');
                    const currentQuantity = parseInt($quantitySpan.text()) || 0;
                    newQuantity = currentQuantity +1;
                    $quantitySpan.text(currentQuantity + 1);

                    const basePrice = existingItem.data('base-price');
                    const baseOffPrice = existingItem.data('base-off-price') || 0;
                    const offType = existingItem.data('off-type');
                    /** محاسبه‌ی قیمت کل یک محصول */
                    let priceAfterDiscount = 0;
                    let priceBeforeDiscount = basePrice * newQuantity;
                    let discountAmount = 0;

                    if (baseOffPrice > 0) {
                        if (offType === 'مبلغ') {
                            discountAmount = baseOffPrice * newQuantity;
                            priceAfterDiscount = (basePrice * newQuantity) - discountAmount;
                        } else if (offType === 'درصد') {
                            const d = basePrice * (baseOffPrice / 100);
                            discountAmount = d * newQuantity;
                            priceAfterDiscount = (basePrice * newQuantity) - discountAmount;
                        }
                    } else {
                        priceAfterDiscount = basePrice * newQuantity;
                    }

                    /** آپدیت قیمت داخل آیتم */
                    const $priceElement = existingItem.find('.cart-item-price');

                    if (discountAmount > 0) {
                        $priceElement.html(`
                    <span class="cart-item-old-price">${priceBeforeDiscount.toLocaleString()} تومان</span>
                    <span class="cart-item-new-price">${priceAfterDiscount.toLocaleString()} تومان</span>
                `);
                    } else {
                        $priceElement.html(`
                    <span class="cart-item-new-price">${priceAfterDiscount.toLocaleString()} تومان</span>
                `);
                    }
                } else {
                    // اگر نبود، آیتم جدید بساز (با data attributes کامل)
                    const newItem = `
            <div class="cart-item"
                data-id="${item.id}"
                data-model="${item.model}"
                data-base-price="${item.price}"
                data-base-off-price="${item.off}"
                data-off-type="${item.offType}">

                <img src="${item.image}" alt="${item.title}" class="cart-item-image">

                <div class="cart-item-content">
                    <div class="cart-item-title">${item.title}</div>

                    <div class="cart-item-price">
                        ${Number(item.price * item.quantity).toLocaleString()} تومان
                    </div>

                    <div class="quantity-controls">
                        <button class="decrease" data-model="${item.model}" data-id="${item.id}">-</button>
                        <span class="count item-quantity">${item.quantity}</span>
                        <button class="increase" data-model="${item.model}" data-id="${item.id}">+</button>
                        <a href="#" class="delete-item me-3"
                            data-id="${item.id}"
                            data-model="${item.model}">
                            <i class="far fa-trash-alt text-danger"></i>
                        </a>
                    </div>
                </div>
            </div>
        `;

                    $cartList.prepend(newItem);
                }

                // جمع کل و badge را آپدیت کن
                updateCartBadge();
                updateCartTotal();
            }

        });



        // favorites actions
        $(document).on("click", ".favorites-btn", function(event) {
            event.preventDefault();

            var $btn = $(this);

            const id = $btn.data('id');
            const model = $btn.data('model');
            const price = $btn.data('price');
            const off = $btn.data('off');
            const offType = $btn.data('offType');
            const pay = $btn.data('pay');
            const local = $btn.data('local');
            const title = $btn.data('title');
            const image = $btn.data('image') || '/images/no-image.png';
            const url = `${document.location.origin}/cart/add/${id}/${model}`;
            const design = $btn.data('design');
            const color = $btn.data('color');



            if ($btn.hasClass('active')) {
                var urlFavorites = document.location.origin + "/user/remove-favorite/";
            } else {
                var urlFavorites = document.location.origin + "/user/add-favorite";
            }

            $.ajax({
                type: "GET",
                url: urlFavorites,
                data: {
                    id: id,
                    model: model
                },
                success: function(data) {

                    // اگر سرور گفت نیاز به لاگین داری
                    if (data.res === "auth") {
                        Swal.fire({
                            title: `
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('/hometemplate/img/logo.png') }}" width="30">
                                    <h2 class="title m-0">ورود به حساب کاربری</h2>
                                </div>`,
                            html: `
                        <form id="loginAjaxForm">
                            <div class="mx-5 text-center">
                                <div class="mb-3 mt-4">
                                    <div class="autocomplete" id="autocompleteBoxlogin">
                                        <input type="text" id="searchInputlogin" class=""
                                            oninput="nameinput('login')">
                                        <label for="searchInputlogin">شماره موبایل یا آدرس ایمیل</label>
                                        <span class="clear-btn" id="clearBtn_login" onclick="clearInput('login')"
                                            >×</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="autocomplete" id="autocompleteBoxpassword">
                                        <input type="password" id="searchInputpassword" class="" name="password"
                                            oninput="nameinput('password')">
                                        <label for="searchInputpassword">رمز عبور</label>
                                        <span class="clear-btn" id="clearBtn_password" onclick="clearInput('password')">×</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">ورود</button>
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <div class="mb-2"><a href="{{ route('password.request') }}">رمز عبور را فراموش کرده‌اید؟</a>
                                        </div>
                                    @endif
                                    <div class="mb-2">حساب کاربری ندارید؟ <a href="{{ route('register') }}">ثبت نام کنید</a></div>
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
                                        title: "ورود موفقیت‌آمیز",
                                        timer: 1500,
                                        showConfirmButton: false
                                    });

                                    setTimeout(() => location.reload(), 1200);
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: "error",
                                        title: "ورود ناموفق",
                                        text: "ایمیل یا رمز عبور اشتباه است"
                                    });
                                }
                            });
                        });

                        return; // ادامه اجرا متوقف شود
                    }

                    // پیام اصلی
                    var text = (data.res === "error") ?
                        "خطا در اجرای عملیات" :
                        "عملیات با موفقیت انجام شد.";

                    // -----------------------------
                    // 🔥 تغییر حالت آیکون قلب
                    // -----------------------------
                    if (data.res === "success") {
                        // شناسه محصول کلیک شده
                        const productId = $btn.data("id");

                        // 🔥 تمام دکمه‌های علاقه‌مندی با این ID را بگیر
                        const allSameFavorites = $(`.favorites-btn[data-id='${productId}']`);

                        updateNavbarFavorites({
                            id,
                            title,
                            price,
                            image,
                            quantity: 1,
                            model: model,
                            off: off,
                            offType: offType,
                            design: design,
                            color: color
                        });
                        // روی همه اعمال کن
                        allSameFavorites.each(function() {
                            if ($(this).hasClass('active')) {
                                const $item = $(this);
                                if ($item.hasClass('discount-squer')) {
                                    $item.find(".fa-heart")
                                        .removeClass("text-danger")
                                        .addClass("text-white");
                                } else {
                                    $item.find(".fa-heart")
                                        .removeClass("fa-solid")
                                        .addClass("fa-regular");
                                }
                                $item.removeClass("active");
                            } else {
                                const $item = $(this);
                                $item.addClass("active");
                                if ($item.hasClass('discount-squer')) {
                                    $item.find(".fa-heart")
                                        .removeClass("text-white")
                                        .addClass("text-danger");
                                } else {
                                    $item.find(".fa-heart")
                                        .removeClass("fa-regular")
                                        .addClass("fa-solid");
                                }
                                $item.find(".fa-heart")
                                    .removeClass("fa-regular text-white")
                                    .addClass("fa-solid text-danger");
                            }

                        });
                    }

                    // Swal.fire({
                    //     icon: title === "خطا در اجرای عملیات" ? "error" : "success",
                    //     title: title,
                    //     text: data.message
                    // });
                },

                // 🟥 گرفتن خطاهای HTTP مثل 401, 500, 404
                error: function(xhr) {

                    // اگر لاگین نیستی → سرور 401 می‌دهد
                    if (xhr.status === 401) {
                        Swal.fire({
                            title: `
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <img src="{{ asset('/hometemplate/img/logo.png') }}" width="30">
                                    <h2 class="title m-0">ورود به حساب کاربری</h2>
                                </div>`,
                            html: `
                        <form id="loginAjaxForm">
                            <div class="mx-5 text-center">
                                <div class="mb-3 mt-4">
                                    <div class="autocomplete" id="autocompleteBoxlogin">
                                        <input type="text" id="searchInputlogin" class=""
                                            oninput="nameinput('login')">
                                        <label for="searchInputlogin">شماره موبایل یا آدرس ایمیل</label>
                                        <span class="clear-btn" id="clearBtn_login" onclick="clearInput('login')"
                                            >×</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="autocomplete" id="autocompleteBoxpassword">
                                        <input type="password" id="searchInputpassword" class="" name="password"
                                            oninput="nameinput('password')">
                                        <label for="searchInputpassword">رمز عبور</label>
                                        <span class="clear-btn" id="clearBtn_password" onclick="clearInput('password')">×</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">ورود</button>
                                <div class="text-center" style="font-size: 14px;">
                                    @if (Route::has('password.request'))
                                        <div class="mb-2"><a class="text-decoration-none " href="{{ route('password.request') }}">رمز عبور را فراموش کرده‌اید؟</a>
                                        </div>
                                    @endif
                                    <div class="mb-2">حساب کاربری ندارید؟ <a class="text-decoration-none" href="{{ route('register') }}">ثبت نام کنید</a></div>
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
                                        title: "ورود موفقیت‌آمیز",
                                        timer: 1500,
                                        showConfirmButton: false
                                    });

                                    setTimeout(() => location.reload(), 1200);
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: "error",
                                        title: "ورود ناموفق",
                                        text: "ایمیل یا رمز عبور اشتباه است"
                                    });
                                }
                            });
                        });

                        return; // ادامه اجرا متوقف شود
                    }

                    // سایر خطاها
                    Swal.fire({
                        icon: "error",
                        title: "خطا",
                        text: "متأسفانه مشکلی در ارتباط با سرور رخ داد."
                    });
                }
            });
        });

        // 🧡 تابع آپدیت منوی علاقه مندی ها
        function updateNavbarFavorites(item) {
            const $badge = $(".favorites-badge"); // شمارشگر علاقه‌مندی
            const $badge2 = $("#favorites-items-count"); // شمارشگر علاقه‌مندی
            const $favList = $("#navbarFavoritesList"); // لیست داخل منو
            // چک کن آیا محصول وجود دارد
            const exists = $favList.find(`.favorites-item[data-id="${item.id}"][data-model="${item.model}"]`);
            if (exists.length > 0) {
                exists.remove(); // حذف از لیست
                // بروزرسانی تعداد
                let count = parseInt($badge.text()) || 0;
                $badge.text(count > 0 ? count - 1 : 0);
                $badge2.html(count > 0 ? count - 1 + ' کالا ' : 0 + ' کالا ');

                return "removed";
            }
            if (exists.length === 0) {
                // افزایش عدد
                let count = parseInt($badge.text()) || 0;
                $badge.text(count + 1);
                $badge2.html(count + 1 + ' کالا ');

                const newItem = `
                <div class="favorites-item"
                    data-id="${item.id}"
                    data-model="${item.model}" >
                    <img src="${item.image}"
                        alt="product" class="cart-item-image">
                    <div class="cart-item-content">
                        <div class="cart-item-title">
                            ${item.title} طرح ${item.design} رنگ ${item.color}
                        </div>
                        <div class="cart-item-price">
                            ${Number(item.price).toLocaleString()} تومان
                        </div>
                        <div
                            class="d-flex justify-content-start gap-2 align-items-center w-100 bg-white">
                            <button class="buy-button add-to-cart favorites-btn active"
                                data-image="${item.image}"
                                data-moddel="${item.model}"
                                data-design="${item.design}"
                                data-color="${item.color}"
                                data-title="${item.title}"
                                data-price="${item.price}"
                                data-pay="${item.pay}"
                                data-off="${item.off}"
                                data-offType="${item.offType}"
                                data-local="${item.local}"
                                data-id="${item.id}"
                                data-model="${item.model}"
                                style="width: 30px;height:30px"><i
                                    class="fa-solid fa-heart text-danger fa-lg"></i></button>
                            <button class="buy-button add-to-cart addToCart"
                                data-image="${item.image}"
                                data-moddel="${item.model}"
                                data-design="${item.design}"
                                data-color="${item.color}"
                                data-title="${item.title}"
                                data-price="${item.price}"
                                data-pay="${item.pay}"
                                data-off="${item.off}"
                                data-offType="${item.offType}"
                                data-local="${item.local}"
                                data-id="${item.id}"
                                data-model="${item.model}"
                                style="width: 30px;height:30px"><i
                                    class="fa-solid fa-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
                `;

                $favList.prepend(newItem);
            }
        }


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

        document.getElementById("comment_btn")?.addEventListener("click", function() {
            Swal.fire({
                title: `
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <img src="{{ asset('/hometemplate/img/logo.png') }}" width="30">
                                    <h2 class="title m-0">ورود به حساب کاربری</h2>
                                </div>`,
                html: `
                        <form id="loginAjaxForm">
                            <div class="mx-5 text-center">
                                <div class="mb-3 mt-4">
                                    <div class="autocomplete" id="autocompleteBoxlogin">
                                        <input type="text" id="searchInputlogin" class=""
                                            oninput="nameinput('login')">
                                        <label for="searchInputlogin">شماره موبایل یا آدرس ایمیل</label>
                                        <span class="clear-btn" id="clearBtn_login" onclick="clearInput('login')"
                                            >×</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="autocomplete" id="autocompleteBoxpassword">
                                        <input type="password" id="searchInputpassword" class="" name="password"
                                            oninput="nameinput('password')">
                                        <label for="searchInputpassword">رمز عبور</label>
                                        <span class="clear-btn" id="clearBtn_password" onclick="clearInput('password')">×</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">ورود</button>
                                <div class="text-center" style="font-size: 14px;">
                                    @if (Route::has('password.request'))
                                        <div class="mb-2"><a class="text-decoration-none " href="{{ route('password.request') }}">رمز عبور را فراموش کرده‌اید؟</a>
                                        </div>
                                    @endif
                                    <div class="mb-2">حساب کاربری ندارید؟ <a class="text-decoration-none" href="{{ route('register') }}">ثبت نام کنید</a></div>
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
                            title: "ورود موفقیت‌آمیز",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => location.reload(), 1200);
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "ورود ناموفق",
                            text: "ایمیل یا رمز عبور اشتباه است"
                        });
                    }
                });
            });

        });

        // Hot===========================================================================================
        var HotSplide = new Splide("#hot_slider", {
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
                    perPage: 2
                },
                480: {
                    perPage: 1
                },
            },
        });
        HotSplide.mount();

        const prevBtnHot = document.querySelector(".splide-hot-prev-btn");
        const nextBtnHot = document.querySelector(".splide-hot-next-btn");

        // اضافه کردن event listener برای دکمه‌ها
        if (prevBtnHot) {
            prevBtnHot.addEventListener("click", function() {
                HotSplide.go("<");
            });
        }

        if (nextBtnHot) {
            nextBtnHot.addEventListener("click", function() {
                HotSplide.go(">");
            });
        }

        // به‌روزرسانی وضعیت دکمه‌ها هنگام تغییر اسلاید
        HotSplide.on("moved", function() {
            updateButtonStatesHot();
            updateRangeDisplay(HotSplide, "hot-range");
        });

        // تابع برای به‌روزرسانی وضعیت دکمه‌ها
        function updateButtonStatesHot() {
            const index = HotSplide.index;
            const length = HotSplide.length;

            if (prevBtnHot) {
                prevBtnHot.disabled = index === 0;
            }

            if (nextBtnHot) {
                nextBtnHot.disabled = index >= length - HotSplide.options.perPage;
            }
        }

        // مقداردهی اولیه وضعیت دکمه‌ها
        updateButtonStatesHot();
        updateRangeDisplay(HotSplide, "hot-range");

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
@endsection
