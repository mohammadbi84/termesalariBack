@extends('shop.layouts.master')
@section('title', $title . __('products.design') . ($bedcover->color_design->design->title) . __('products.color') .
    ($bedcover->color_design->color->color))
@section('head')
    @if (app()->getLocale() == 'en')
    <link rel="stylesheet" href="{{ asset('shop/css/ltr/product.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('shop/css/product.css') }}">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
@endsection
@section('content')
    <script>
        maxQuantity = {{ $bedcover->quantity }};
    </script>
    <main>
        <div class="container py-4 mb-5" style="padding: 0 2rem !important;margin-top:100px">
            <!-- Breadcrumb -->
            <div class="row rounded-4 shadow-sm bg-white px-4 mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/store" class="text-decoration-none text-muted"><i
                                    class="fas fa-home"></i> {{ __('products.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bedcover.storeIndex') }}"
                                class="text-decoration-none text-muted">{{ __('products.bedcover_products') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $bedcover->category->title }}
                            {{ __('products.design') }}
                            {{ $bedcover->color_design->design->title }}
                            {{ __('products.color') }}
                            {{ $bedcover->color_design->color->color }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="row rounded-4 shadow-sm bg-white p-4 mb-5">
                @php
                    $images = $bedcover->images()->get()->sortby('ordering');
                    $prices = $bedcover->prices->where('local', 'تومان')->first();
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
                                        <img src="{{ asset('storage/' . $image['name']) }}" style="border-radius: 10px;"
                                            alt="{{ $image['name'] }}" class="product-image-show"
                                            data-zoom-src="{{ asset('storage/' . $image['name']) }}">
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
                                data-image="{{ asset('/storage/' . $bedcover->images->first()->name) }}"
                                data-moddel="{{ substr($bedcover->category->model, 4) }}"
                                data-design="{{ $bedcover->color_design->design->title ?? '' }}"
                                data-color="{{ $bedcover->color_design->color->color ?? '' }}"
                                data-title="{{ $bedcover->category->title }}"
                                data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                data-off="{{ $off }}" data-offType="{{ $prices->offType }}"
                                data-local="{{ $prices->local }}" data-id="{{ $bedcover->id }}"
                                data-model="{{ substr($bedcover->category->model, 4) }}">
                                <i class="fa-solid fa-shuffle"></i>
                            </a>
                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ __('product.wishlist') }}"
                                class="share-btn telegram  favorites-btn @if ($bedcover->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                data-image="{{ asset('/storage/' . $bedcover->images->first()->name) }}"
                                data-moddel="{{ substr($bedcover->category->model, 4) }}"
                                data-design="{{ $bedcover->color_design->design->title ?? '' }}"
                                data-color="{{ $bedcover->color_design->color->color ?? '' }}"
                                data-title="{{ $bedcover->category->title }}"
                                data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                data-off="{{ $off }}" data-offType="{{ $prices->offType }}"
                                data-local="{{ $prices->local }}" data-id="{{ $bedcover->id }}"
                                data-model="{{ substr($bedcover->category->model, 4) }}">
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
                        {{ $bedcover->category->title }}
                        {{ __('products.design') }}
                        {{ $bedcover->color_design->design->title }}
                        {{ __('products.color') }}
                        {{ $bedcover->color_design->color->color }}
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
                        <span class="text-muted">({{ number_format($score, 1) }} {{ __('products.of') }} 5 -
                            {{ $comments->count() }}
                            {{ __('products.comment') }})</span>
                    </div>
                    <ul class="product-specs ">
                        <li>{{ __('product.product_code') }}: {{ $bedcover->code }}</li>
                        <li>
                            {{ __('product.color_count') }}:
                            {{ $bedcover->color_design->design->countOfColor }}
                            {{ __('product.colors') }}
                        </li>
                        <li>{{ __('product.contains') }}:
                            {{ $bedcover->contains }}</li>
                        <li>{{ __('product.color') }}:
                            {{ $bedcover->color_design->color->color }}
                        </li>
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="color-title">{{ __('product.category') }} :</h6>
                        <a href="{{ route('bedcover.storeIndex') }}"
                            class="tag">{{ $bedcover->category->title }}</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="color-title">{{ __('product.tags') }} :</h6>
                        <span
                            class="tag">{{ $bedcover->color_design->design->title }}</span>
                    </div>
                    <div class="categories-tags">
                        <hr>
                        <div class="price-section text-start">
                            @if ($off > 0)
                                <span class="original-price">{{ number_format($prices->price) }}
                                    {{ __('products.currency') }}</span>
                            @endif
                            <span class="discounted-price">{{ number_format($price) }}
                                {{ __('products.currency') }}</span>
                        </div>

                        <div class="stock-info">
                            <i class="fas fa-box-open ms-1"></i>
                            {{-- @if ($bedcover->quantity == 0)
                                <span class="text-bold"> اتمام موجودی در انبار </span>
                            @elseif($bedcover->quantity <= 5)
                            @elseif($bedcover->quantity > 5)
                            <span class="text-success text-bold"> موجود در انبار</span>
                            @endif --}}
                            <span class="text-bold">
                                {{ __('product.available_qty', ['count' => $bedcover->quantity]) }}
                            </span>
                        </div>
                        <div class="quantity-control">
                            <div class="quantity-controls gap-2">
                                <button class="minus-btn" data-model="{{ substr($bedcover->category->model, 4) }}"
                                    data-id="{{ $bedcover->id }}">-</button>
                                <span class="count item-quantity-product" id="item-quantity-product">1</span>
                                <button class="plus-btn" data-model="{{ substr($bedcover->category->model, 4) }}"
                                    data-id="{{ $bedcover->id }}">+</button>
                            </div>
                            <button class="btn btn-primary @if ($bedcover->quantity != 0) addToCart @endif"
                                data-image="{{ asset('/storage/' . $bedcover->images->first()->name) }}"
                                data-id="{{ $bedcover->id }}"
                                data-moddel="{{ substr($bedcover->category->model, 4) }}"
                                data-design="{{ $bedcover->color_design->design->title ?? '' }}"
                                data-color="{{ $bedcover->color_design->color->color ?? '' }}"
                                data-title="{{ $bedcover->category->title }}"
                                data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                data-off="{{ $off }}" data-offType="{{ $prices->offType }}"
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
                            {{ $bedcover->description }}
                        </p>
                    </div>
                    <div class="bg-white rounded-4 p-4 shadow-sm">
                        <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                            <i class="fa-regular fa-comments info-badge-icon"></i>
                            <h5 class="m-0">{{ __('product.comments_title') }}</h5>
                        </div>
                        <form action="/comment" method="POST" class="">
                            @csrf
                            <input type="hidden" name="product" value="{{ $bedcover->id }}">
                            <input type="hidden" name="model" value="Bedcover">
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
                                <button type="submit"
                                    class="btn btn-primary w-25 mb-3">{{ __('product.submit_comment') }}</button>
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
                                <span
                                    class="point-span">{{ $bedcover->dimensions }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.weight') }}</span>
                                <span
                                    class="point-span">{{ $bedcover->weight }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.material') }}</span>
                                <span
                                    class="point-span">{{ $bedcover->kind }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.sewing_type') }}</span>
                                <span
                                    class="point-span">{{ $bedcover->sewingType }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.lining') }}</span>
                                <span
                                    class="point-span">{{ $bedcover->haveEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.lining_material') }}</span>
                                <span
                                    class="point-span">{{ $bedcover->kindOfEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.washable') }}</span>
                                <span
                                    class="point-span">{{ $bedcover->washable }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ __('product.uses') }}</span>
                                <span
                                    class="point-span">{{ $bedcover->uses }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @if ($likeBedcovers->count() > 0)
                <div class="row mb-5 bg-white rounded-4 shadow-sm p-3">
                    {{-- <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                        <i class="fa-regular fa-comments info-badge-icon"></i>
                        <div>
                            <h5 class="m-0">محصولات مشابه</h5>
                        </div>
                    </div> --}}
                    <div class=" d-flex align-items-center justify-content-between w-100  p-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('shop/assets/svgs/cart-shopping-solid-full.svg') }}"
                                alt="{{ __('product.related_products') }}" width="30">
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
                                @foreach ($likeBedcovers as $key => $bedcover)
                                    @php
                                        $prices = $bedcover->prices->where('local', 'تومان')->first();
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
                                                    <a
                                                        href="
                                                        @switch($bedcover->category->model)
                                                                @case('App\Tablecloth')
                                                                  {{ route('tablecloth.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Pillow')
                                                                  {{ route('pillow.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Prayermat')
                                                                  {{ route('prayermat.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Bedcover')
                                                                  {{ route('bedcover.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Shoe')
                                                                  {{ route('shoe.show', [$bedcover->id]) }}
                                                                  @break
                                                            @endswitch
                                                    ">
                                                        <img src="{{ asset('/storage/' . $bedcover->images->first()->name) }}"
                                                            alt="{{ $bedcover->category->title }}"
                                                            class="hot-product-image">
                                                    </a>
                                                </div>
                                                <div class="overlay">
                                                    <h3 class="product-title">
                                                        {{ $bedcover->category->title }}
                                                        {{ __('products.design') }}
                                                        {{ $bedcover->color_design->design->title }}
                                                        {{ __('products.color') }}
                                                        {{ $bedcover->color_design->color->color }}
                                                    </h3>
                                                    <div
                                                        class="product-price w-100 d-flex justify-content-between align-items-center mb-2">
                                                        <div
                                                            class="d-flex align-items-center justify-content-center gap-2">
                                                            <a href="
                                                            @switch($bedcover->category->model)
                                                                @case('App\Tablecloth')
                                                                  {{ route('tablecloth.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Bedcover')
                                                                  {{ route('bedcover.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Prayermat')
                                                                  {{ route('prayermat.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Bedcover')
                                                                  {{ route('bedcover.show', [$bedcover->id]) }}
                                                                  @break
                                                                @case('App\Shoe')
                                                                  {{ route('shoe.show', [$bedcover->id]) }}
                                                                  @break
                                                            @endswitch
                                                            "
                                                                class="buy-button text-decoration-none h-100 px-3 py-1">{{ __('main.view') }}</a>
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
                                                                    @if (app()->getLocale() == 'en')
                                                                    <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                    @else
                                                                    <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                    @endif
                                                                </span>
                                                            @else
                                                                <span class="price">{{ number_format($prices->price) }}
                                                                    @if (app()->getLocale() == 'en')
                                                                    <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                    @else
                                                                    <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                    @endif
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="px-1 pt-2 hot-description border-top d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <span class="fs-10">28 {{ __('main.sell') }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                                        <button
                                                            class="buy-button shadow-none add-to-cart favorites-btn @if ($bedcover->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                            data-image="{{ asset('/storage/' . $bedcover->images->first()->name) }}"
                                                            data-moddel="{{ substr($bedcover->category->model, 4) }}"
                                                            data-design="{{ $bedcover->color_design->design->title ?? '' }}"
                                                            data-color="{{ $bedcover->color_design->color->color ?? '' }}"
                                                            data-title="{{ $bedcover->category->title }}"
                                                            data-price="{{ $prices->price }}"
                                                            data-pay="{{ $price }}"
                                                            data-off="{{ $off }}"
                                                            data-offType="{{ $prices->offType }}"
                                                            data-local="{{ $prices->local }}"
                                                            data-id="{{ $bedcover->id }}"
                                                            data-model="{{ substr($bedcover->category->model, 4) }}"
                                                            data-id="{{ $bedcover->id }}"
                                                            data-model="{{ substr($bedcover->category->model, 4) }}"
                                                            style="width:30px;height:30px"><i
                                                                class="@if ($bedcover->favorites->where('user_id', Auth::id())->count() > 0) fa-solid @else fa-regular @endif fa-heart text-danger"></i></button>
                                                        <button
                                                            class="buy-button shadow-none add-to-cart @if ($bedcover->quantity != 0) addToCart @endif"
                                                            style="width:30px;height:30px"
                                                            data-image="{{ asset('/storage/' . $bedcover->images->first()->name) }}"
                                                            data-id="{{ $bedcover->id }}"
                                                            data-moddel="{{ substr($bedcover->category->model, 4) }}"
                                                            data-design="{{ $bedcover->color_design->design->title ?? '' }}"
                                                            data-color="{{ $bedcover->color_design->color->color ?? '' }}"
                                                            data-title="{{ $bedcover->category->title }}"
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
                                        <img src="{{ asset('storage/' . $image['name']) }}" alt="{{ $image['name'] }}"
                                            class="product-image-show">
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
    @if (app()->getLocale() == 'en')
    <script src="{{ asset('shop/js/ltr/main-menu-full.js') }}"></script>
    @else
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
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
                            " {{ __('products.products') }}";
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
                                ${title} {{ __('products.design') }} ${design} {{ __('products.color') }} ${color}
                            </div>
                            <div class="cart-item-price">
                                ${Number(price).toLocaleString()} {{ __('products.currency') }}
                            </div>
                        </div>
                    </div>
                    `;

                            $compList.prepend(newItem);
                        }

                        Swal.fire({
                            icon: "success",
                            title: "{{ __('js.operation_success') }}",
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
                        title: "{{ $bedcover->title }}",
                        text: "مشترک عزیز، این محصول را ببینید: {{ $bedcover->title }}",
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
                const title =
                    `${$btn.data('title')} {{ __('products.design') }} ${$btn.data('design')} {{ __('products.color') }} ${$btn.data('color')}`;
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
                                    title: "{{ __('js.add_to_cart_success') }}",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "{{ __('js.add_to_cart_error') }}",
                                text: "{{ __('js.add_to_cart_error_text') }}"
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "{{ __('js.server_connection_error') }}",
                            text: "{{ __('js.server_connection_error_text') }}"
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
                    newQuantity = currentQuantity + 1;
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
                    <span class="cart-item-old-price">${priceBeforeDiscount.toLocaleString()} {{ __('products.currency') }}</span>
                    <span class="cart-item-new-price">${priceAfterDiscount.toLocaleString()} {{ __('products.currency') }}</span>
                `);
                    } else {
                        $priceElement.html(`
                    <span class="cart-item-new-price">${priceAfterDiscount.toLocaleString()} {{ __('products.currency') }}</span>
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
                        ${Number(item.price * item.quantity).toLocaleString()} {{ __('products.currency') }}
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

                        return; // ادامه اجرا متوقف شود
                    }

                    // سایر خطاها
                    Swal.fire({
                        icon: "error",
                        title: "خطا",
                        text: "{{ __('js.server_error_text') }}"
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
                $badge2.html(count > 0 ? count - 1 + ' {{ __('products.products') }} ' : 0 +
                    ' {{ __('products.products') }} ');

                return "removed";
            }
            if (exists.length === 0) {
                // افزایش عدد
                let count = parseInt($badge.text()) || 0;
                $badge.text(count + 1);
                $badge2.html(count + 1 + ' {{ __('products.products') }} ');

                const newItem = `
                <div class="favorites-item"
                    data-id="${item.id}"
                    data-model="${item.model}" >
                    <img src="${item.image}"
                        alt="product" class="cart-item-image">
                    <div class="cart-item-content">
                        <div class="cart-item-title">
                            ${item.title} {{ __('products.design') }} ${item.design} {{ __('products.color') }} ${item.color}
                        </div>
                        <div class="cart-item-price">
                            ${Number(item.price).toLocaleString()} {{ __('products.currency') }}
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
