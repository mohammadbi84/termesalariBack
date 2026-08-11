@extends('shop.layouts.master')
@section('title', 'فروشگاه ترمه سالاری')
@section('head')
    @if (app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('shop/css/video.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('shop/css/ltr/video.css') }}">
    @endif
    <script src="{{ asset('shop/js/scripts.js') }}"></script>

    <!-- video -->

    <script src="{{ asset('shop/js/video.js') }}"></script>
@endsection
@section('content')
    <!-- start popup -->
    @if ($popups->count() > 0)
        <div class="modal fade" id="customModal" tabindex="-1" aria-hidden="true" dir="rtl">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <button type="button" class="btn btn-light position-absolute top-0 start-0 modal-close-btn"
                        data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    {{-- 🔥 POPUP SLIDER --}}
                    <div class="splide" id="popup-slider" style="direction: ltr;">
                        <div class="splide__track">
                            <ul class="splide__list">

                                @foreach ($popups as $popup)
                                    <li class="splide__slide"
                                        data-link="{{ $popup->link ? route('article.show', [$popup->link]) : '#' }}">

                                        {{-- IMAGE SLIDER (قدیمی – دست نخورده) --}}
                                        <div class="swiper popup-image-slider">
                                            <div class="swiper-wrapper">
                                                @foreach ($popup->images as $image)
                                                    <div class="swiper-slide" data-delay="{{ $image->duration }}">
                                                        <img src="{{ asset($image->image) }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- pagination -->
                                            <div class="swiper-pagination popup-pagination"></div>
                                        </div>


                                        {{-- CONTENT --}}
                                        <div class="p-4 px-5 pb-0">
                                            <h2 class="fw-bold text-center">
                                                {{ app()->getLocale() == 'fa' ? $popup->title_fa : $popup->title_en }}
                                            </h2>

                                            <p class="text-muted text-center mb-4">
                                                {{ app()->getLocale() == 'fa' ? $popup->description_fa : $popup->description_en }}
                                            </p>

                                        </div>

                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-4 px-5 pt-0 popup-footer">
                        <a href="#" class="btn btn-primary" id="popup-more-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                            {{ __('main.moreInfo') }}
                        </a>
                        <!-- 👇 pagination بیاد اینجا -->
                        <div id="popup-pagination-holder"></div>
                        <button class="btn btn-text-link" data-bs-dismiss="modal">
                            {{ __('main.checkLater') }}
                        </button>

                    </div>
                </div>
            </div>
        </div>

    @endif
    @if ($popups->count() > 0)
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const modal = new bootstrap.Modal(document.getElementById("customModal"));
                modal.show();

                // 🔥 Popup Slider
                const popupSplide = new Splide("#popup-slider", {
                    type: "slide",
                    perPage: 1,
                    direction: "ltr",
                    arrows: false,
                    pagination: true,
                    rewind: true,
                    classes: {
                        page: 'splide__pagination__page popup-page-btn'
                    },
                });

                popupSplide.on('pagination:mounted', function(data) {
                    data.list.classList.add('popup-pagination-numbers');

                    data.items.forEach(function(item, index) {
                        item.button.textContent = index + 1; // ← عددی کردن
                    });
                    // 👇 انتقال به جای دلخواه
                    document
                        .getElementById('popup-pagination-holder')
                        .appendChild(data.list);
                });

                function updatePopupButton(index) {
                    let slide = popupSplide.Components.Elements.slides[index];
                    let link = slide.dataset.link || "#";
                    document.getElementById('popup-more-btn').setAttribute('href', link);
                }

                popupSplide.on('mounted', function() {
                    updatePopupButton(0);
                });

                popupSplide.on('moved', function(newIndex) {
                    updatePopupButton(newIndex);
                });


                popupSplide.on("mounted", function() {

                    document.querySelectorAll('.popup-image-slider').forEach(function(el) {

                        let swiper = new Swiper(el, {
                            loop: true,
                            speed: 600,
                            autoplay: {
                                delay: 3000, // مقدار اولیه دلخواه
                                disableOnInteraction: false,
                            },
                            pagination: {
                                el: el.querySelector('.swiper-pagination'),
                                clickable: true,
                                renderBullet: function(index, className) {
                                    return `<span class="${className}"></span>`;
                                }
                            },
                            watchOverflow: false,
                            on: {
                                init: function() {
                                    // وقتی swiper mount شد، delay اولین اسلاید رو اعمال کن
                                    let firstSlide = this.slides[this.activeIndex];
                                    let delay = firstSlide.dataset.delay;
                                    if (delay) {
                                        this.params.autoplay.delay = parseInt(delay);
                                        this.autoplay.start();
                                    }
                                },
                                slideChangeTransitionEnd: function() {
                                    let activeSlide = this.slides[this.activeIndex];
                                    let delay = activeSlide.dataset.delay;

                                    if (delay) {
                                        this.params.autoplay.delay = parseInt(delay);
                                        this.autoplay.start();
                                    }
                                }
                            }
                        });

                    });




                });

                popupSplide.mount();
            });
        </script>
    @endif
    <!-- end popup -->
    <main>
        <!-- slider -->
        <section>
            <div class="top-slider-wrapper d-flex gap-3 mb-5">
                <!-- Main Slider -->
                <div class="top-slider-container flex-grow-1 position-relative">
                    <div class="top-slider">
                        @if (isset($slideshows) and count($slideshows) > 0)
                            @foreach ($slideshows as $key => $slideshow)
                                <div class="item" data-duration="{{ $slideshow->duration * 1000 }}">
                                    @if ($slideshow->video)
                                        <div class="video-full-container video-full-container-slider mb-5 px-0">
                                            <video class="slider-video"
                                                poster="{{ asset('storage/images/' . $slideshow->image) }}" preload="none">
                                                <!-- منبع ویدیو - میتوانید آدرس ویدیوی خود را جایگزین کنید -->
                                                <source src="{{ asset('storage/videos/' . $slideshow->video) }}"
                                                    type="video/mp4">
                                                مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
                                            </video>

                                            <div class="video-overlay"></div>

                                            <div class="play-pause-btn d-flex">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/images/' . $slideshow->image) }}"
                                            class="img-fluid w-100 h-100" style="object-fit: cover;"
                                            alt="{{ $slideshow->title }}">
                                    @endif

                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- Vertical Pagination - اضافه کردن این بخش -->
                    <div class="vertical-pagination position-absolute d-flex flex-column gap-2">
                        @foreach ($slideshows as $key => $slideshow)
                            <button class="pagination-item {{ $key === 0 ? 'active' : '' }}"
                                data-index="{{ $key }}">
                                <div class="pagination-inner"></div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- end slider -->
        <!-- special offers -->
        @if (isset($amazings) and count($amazings) > 0)
            <section id="specials">
                <div class="container mb-5 px-0">
                    <div class=" d-flex align-items-center justify-content-between w-100  p-2 offer-header">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('shop/assets/svgs/badge-percent-title.svg') }}"
                                alt="{{ __('menu.amazing') }}" width="30">
                            <h2 class="title m-0">{{ __('menu.amazing') }}</h2>
                        </div>
                        <div class="">
                            <!-- دکمه‌های کنترل جداگانه -->
                            <div class="custom-splide-controls">
                                <button class="splide-prev-btn splide-offer-prev-btn">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                                <span id="events-range" class="slide-range">1-4</span>
                                <button class="splide-next-btn splide-offer-next-btn">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="events-slider" class="splide" style="padding: 0 5px !important;">
                        <div class="splide__track fix-shadow-margin py-3">
                            <ul class="splide__list">
                                @foreach ($amazings as $key => $amazing)
                                    @php
                                        $prices = $amazing->productable->prices->where('local', 'تومان')->first();
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
                                        <div class="flip-card">
                                            <div class="flip-card-inner">
                                                <!-- جلوی کارت -->
                                                <div class="flip-card-front d-flex flex-column justify-content-between">
                                                    <div class="position-relative image-badge pb-1">
                                                        <img src="{{ asset('/storage/images/thumbnails/' . $amazing->productable->images->first()->name) }}"
                                                            class="card-img-top" alt="event image">

                                                        @if ($prices->offPrice > 0)
                                                            <div class="discount-squer discount-squer-front"
                                                                style="position: absolute;top: -4px;left: 20px;">
                                                                <img src="{{ asset('shop/assets/svgs/off-background.svg') }}"
                                                                    width="90" alt="discount">
                                                                <span class="d-flex"
                                                                    style="font-size: 12px;font-weight: 800;position: absolute;right: 16px;top: 7px;">
                                                                    <strong class="" style="font-size: 12px;">
                                                                        @if ($prices->offType == 'مبلغ')
                                                                            {{ round(($prices->offPrice * 100) / $prices->price, 0) }}%
                                                                        @elseif($prices->offType == 'درصد')
                                                                            {{ $prices->offPrice }}%
                                                                        @endif
                                                                    </strong>
                                                                    <span class="me-1"
                                                                        style="font-size: 13px;">تخفیف</span>
                                                                </span>
                                                            </div>
                                                        @endif
                                                        {{-- <div class="discount-squer discount-squer-front"
                                                            style="position: absolute;top: -4px;right: 20px;">
                                                            <img src="{{ asset('shop/assets/svgs/heart-back.svg') }}"
                                                                width="35" alt="discount">
                                                            <span class="d-flex"
                                                                style="font-size: 12px;font-weight: 800;position: absolute;right: 9px;top: 2px;">
                                                                <strong class="" style="font-size: 18px;">
                                                                    <i
                                                                        class="fa-solid fa-heart @if ($amazing->productable->favorites->where('user_id', Auth::id())->count() > 0) text-danger @else text-white @endif "></i>
                                                                </strong>
                                                            </span>
                                                        </div> --}}
                                                        <a href="#"
                                                            class="discount-squer discount-squer-front favorites-btn @if ($amazing->productable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                            data-id="{{ $amazing->productable->id }}"
                                                            data-model="{{ substr($amazing->productable, 4) }}"
                                                            style="position: absolute;top: -4px;right: 20px;">
                                                            <img src="{{ asset('shop/assets/svgs/heart-back.svg') }}"
                                                                width="35" alt="discount"
                                                                style="height: 31px;object-fit: cover;">
                                                            <span class="d-flex"
                                                                style="font-size: 12px;font-weight: 800;position: absolute;right: 9px;top: 2px;">
                                                                <strong class="" style="font-size: 18px;">
                                                                    <i
                                                                        class="fa-solid fa-heart @if ($amazing->productable->favorites->where('user_id', Auth::id())->count() > 0) text-danger @else text-white @endif "></i>
                                                                </strong>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div
                                                        class="details h-100 d-flex flex-column justify-content-between text-start pt-2">
                                                        <div
                                                            class="d-flex align-items-center align-content-center justify-content-start mb-2">
                                                            <h5 class="product-title text-end">
                                                                {{ app()->getLocale() == 'fa' ? $amazing->productable->category->title : $amazing->productable->category->e_title }}
                                                                {{ __('products.design') }}
                                                                {{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->design->title : $amazing->productable->color_design->design->e_title }}
                                                                {{ __('products.color') }}
                                                                {{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->color->color : $amazing->productable->color_design->color->e_color }}
                                                            </h5>
                                                        </div>
                                                        <div
                                                            class="product-details d-flex align-items-center justify-content-between gap-2">
                                                            <div
                                                                class=" w-50 h-100 text-center d-flex justify-content-center align-items-center">
                                                                <div class="countdown-timer timer-short justify-content-between"
                                                                    id="countdown-1"
                                                                    data-end-date="{{ $amazing->end_date }}"
                                                                    style="gap:{{ app()->getLocale() == 'fa' ? '' : '20px; !important' }}">
                                                                    <div class="timer-col">
                                                                        <span class="timer-number days">12
                                                                        </span>
                                                                    </div>
                                                                    <div class="timer-col">
                                                                        <span class="timer-number hours">20
                                                                        </span>
                                                                    </div>
                                                                    <div class="timer-col">
                                                                        <span class="timer-number minutes">20
                                                                        </span>
                                                                    </div>
                                                                    <div class="timer-col">
                                                                        <span class="timer-number seconds">20
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" w-100 text-start">
                                                                @if ($prices->offPrice > 0)
                                                                    <div class="row g-0 ">
                                                                        <div class="col-8 text-primary text-start ps-1">
                                                                            <del
                                                                                class="product-price-off">{{ number_format($prices->price) }}</del>
                                                                        </div>
                                                                        <div class="col-4"><span
                                                                                class="badge bg-primary product-off">
                                                                                @if ($prices->offType == 'مبلغ')
                                                                                    {{ round(($prices->offPrice * 100) / $prices->price, 0) }}%
                                                                                @elseif($prices->offType == 'درصد')
                                                                                    {{ $prices->offPrice }}%
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row g-0 ">
                                                                        <div class="col-9 product-price text-start ps-1">
                                                                            @if ($prices->offType == 'مبلغ')
                                                                                {{ number_format($prices->price - $prices->offPrice) }}
                                                                            @elseif($prices->offType == 'درصد')
                                                                                {{ number_format($prices->price - $prices->price * ($prices->offPrice / 100)) }}
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-3 fs-small">
                                                                            @if (app()->getLocale() == 'fa')
                                                                                <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                                    alt="Price" width="20px"
                                                                                    height="20px">
                                                                            @else
                                                                                <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                                    alt="Price" width="20px"
                                                                                    height="20px">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="row g-0 ">
                                                                        <div class="col-9 product-price text-start ps-1">
                                                                            {{ number_format($prices->price) }}
                                                                        </div>
                                                                        <div class="col-3 fs-small">
                                                                            @if (app()->getLocale() == 'fa')
                                                                                <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                                    alt="Price" width="20px"
                                                                                    height="20px">
                                                                            @else
                                                                                <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                                    alt="Price" width="20px"
                                                                                    height="20px">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- پشت کارت -->
                                                <div
                                                    class="flip-card-back border d-flex flex-column justify-content-between">
                                                    @if ($prices->offPrice > 0)
                                                        <div class="discount-squer"
                                                            style="position: absolute;top: 2px;left: 19px;">
                                                            <img src="{{ asset('shop/assets/svgs/off-background.svg') }}"
                                                                width="90" alt="discount">
                                                            <span class="d-flex"
                                                                style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;">
                                                                <strong class="" style="font-size: 12px;">
                                                                    @if ($prices->offType == 'مبلغ')
                                                                        {{ round(($prices->offPrice * 100) / $prices->price, 0) }}%
                                                                    @elseif($prices->offType == 'درصد')
                                                                        {{ $prices->offPrice }}%
                                                                    @endif
                                                                </strong>
                                                                <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <button class="buy-button shadow-none add-to-cart compare"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $amazing->productable->images->first()->name) }}"
                                                        data-moddel="{{ substr($amazing->productable->category->model, 4) }}"
                                                        data-design="{{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->design->title : $amazing->productable->color_design->design->e_title ?? '' }}"
                                                        data-color="{{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->color->color : $amazing->productable->color_design->color->e_color ?? '' }}"
                                                        data-title="{{ app()->getLocale() == 'fa' ? $amazing->productable->category->title : $amazing->productable->category->e_title }}"
                                                        data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                                        data-off="{{ $off }}"
                                                        data-offType="{{ $prices->offType }}"
                                                        data-local="{{ $prices->local }}"
                                                        data-id="{{ $amazing->productable->id }}"
                                                        data-model="{{ substr($amazing->productable->category->model, 4) }}"
                                                        style="width: 35px;height: 32px;position: absolute;left: 40px;top: 3px;transform: translateZ(51px);"><i
                                                            class="fa-solid fa-shuffle"></i></button>
                                                    <a href="#"
                                                        class="discount-squer favorites-btn @if ($amazing->productable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $amazing->productable->images->first()->name) }}"
                                                        data-moddel="{{ substr($amazing->productable, 4) }}"
                                                        data-design="{{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->design->title : $amazing->productable->color_design->design->e_title ?? '' }}"
                                                        data-color="{{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->color->color : $amazing->productable->color_design->color->e_color ?? '' }}"
                                                        data-title="{{ app()->getLocale() == 'fa' ? $amazing->productable->category->title : $amazing->productable->category->e_title }}"
                                                        data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                                        data-off="{{ $off }}"
                                                        data-offType="{{ $prices->offType }}"
                                                        data-local="{{ $prices->local }}"
                                                        data-id="{{ $amazing->productable->id }}"
                                                        data-model="{{ substr($amazing->productable, 4) }}"
                                                        style="position: absolute;top: 4px;right: 20px;">
                                                        <img src="{{ asset('shop/assets/svgs/heart-back.svg') }}"
                                                            width="35" alt="discount"
                                                            style="height: 31px;object-fit: cover;">
                                                        <span class="d-flex"
                                                            style="font-size: 12px;font-weight: 800;position: absolute;right: 9px;top: 2px;">
                                                            <strong class="" style="font-size: 18px;">
                                                                <i
                                                                    class="fa-solid fa-heart @if ($amazing->productable->favorites->where('user_id', Auth::id())->count() > 0) text-danger @else text-white @endif "></i>
                                                            </strong>
                                                        </span>
                                                    </a>
                                                    <div class="d-flex btn-row align-items-center align-content-center justify-content-center mb-2 h-100 w-100"
                                                        style="flex-direction: column;padding: 0 22px;">
                                                        <div class="text-center">
                                                            <h5 class="product-title text-center mb-4">
                                                                {{ app()->getLocale() == 'fa' ? $amazing->productable->category->title : $amazing->productable->category->e_title }}
                                                                {{ __('products.design') }}
                                                                {{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->design->title : $amazing->productable->color_design->design->e_title }}
                                                                {{ __('products.color') }}
                                                                {{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->color->color : $amazing->productable->color_design->color->e_color }}
                                                            </h5>
                                                            <div class="row g-0 w-100">
                                                                <div class="col-3 ps-2">
                                                                    <button
                                                                        class="buy-button add-to-cart @if ($amazing->productable->quantity != 0) addToCart @endif"
                                                                        data-image="{{ asset('/storage/images/thumbnails/' . $amazing->productable->images->first()->name) }}"
                                                                        data-id="{{ $amazing->productable->id }}"
                                                                        data-moddel="{{ substr($amazing->productable, 4) }}"
                                                                        data-design="{{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->design->title : $amazing->productable->color_design->design->e_title ?? '' }}"
                                                                        data-color="{{ app()->getLocale() == 'fa' ? $amazing->productable->color_design->color->color : $amazing->productable->color_design->color->e_color ?? '' }}"
                                                                        data-title="{{ app()->getLocale() == 'fa' ? $amazing->productable->category->title : $amazing->productable->category->e_title }}"
                                                                        data-price="{{ $prices->price }}"
                                                                        data-pay="{{ $price }}"
                                                                        data-off="{{ $off }}"
                                                                        data-offType="{{ $prices->offType }}"
                                                                        data-local="{{ $prices->local }}"><i
                                                                            class="fa-solid fa-cart-plus"></i></button>
                                                                </div>
                                                                <div class="col-9 pe-2">
                                                                    <a href="
                                                                        @switch($amazing->productable_type)
                                                                            @case('App\Tablecloth')
                                                                              {{ route('tablecloth.show', [$amazing->productable->id]) }}
                                                                              @break
                                                                            @case('App\Pillow')
                                                                              {{ route('pillow.show', [$amazing->productable->id]) }}
                                                                              @break
                                                                            @case('App\Prayermat')
                                                                              {{ route('prayermat.show', [$amazing->productable->id]) }}
                                                                              @break
                                                                            @case('App\Bedcover')
                                                                              {{ route('bedcover.show', [$amazing->productable->id]) }}
                                                                              @break
                                                                            @case('App\Shoe')
                                                                              {{ route('shoe.show', [$amazing->productable->id]) }}
                                                                              @break
                                                                        @endswitch
                                                                        "
                                                                        class="buy-button text-decoration-none">{{ __('main.view') }}</a>
                                                                    <span class="fs-10 p-0">
                                                                        @if ($amazing->productable->quantity == 0)
                                                                            اتمام موجودی در انبار
                                                                        @elseif($amazing->productable->quantity <= 5)
                                                                            کمتر از 5 عدد موجود می باشد .
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="product-details d-flex align-items-center justify-content-between gap-2">
                                                        <div
                                                            class=" w-50 h-100 text-center d-flex justify-content-center align-items-center">
                                                            <div class="countdown-timer timer-short justify-content-between"
                                                                id="countdown-1" data-end-date="{{ $amazing->end_date }}"
                                                                style="gap:{{ app()->getLocale() == 'fa' ? '' : '20px; !important' }}">
                                                                <div class="timer-col">
                                                                    <span class="timer-number days">12
                                                                    </span>
                                                                </div>
                                                                <div class="timer-col">
                                                                    <span class="timer-number hours">20
                                                                    </span>
                                                                </div>
                                                                <div class="timer-col">
                                                                    <span class="timer-number minutes">20
                                                                    </span>
                                                                </div>
                                                                <div class="timer-col">
                                                                    <span class="timer-number seconds">20
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" w-100 text-start">
                                                            @if ($prices->offPrice > 0)
                                                                <div class="row g-0 ">
                                                                    <div class="col-8 text-primary text-start ps-1">
                                                                        <del
                                                                            class="product-price-off">{{ number_format($prices->price) }}</del>
                                                                    </div>
                                                                    <div class="col-4"><span
                                                                            class="badge bg-primary product-off">
                                                                            @if ($prices->offType == 'مبلغ')
                                                                                {{ round(($prices->offPrice * 100) / $prices->price, 0) }}%
                                                                            @elseif($prices->offType == 'درصد')
                                                                                {{ $prices->offPrice }}%
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row g-0 ">
                                                                    <div class="col-9 product-price text-start ps-1">
                                                                        @if ($prices->offType == 'مبلغ')
                                                                            {{ number_format($prices->price - $prices->offPrice) }}
                                                                        @elseif($prices->offType == 'درصد')
                                                                            {{ number_format($prices->price - $prices->price * ($prices->offPrice / 100)) }}
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-3 fs-small">
                                                                        @if (app()->getLocale() == 'fa')
                                                                            <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                                alt="Price" width="20px"
                                                                                height="20px">
                                                                        @else
                                                                            <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                                alt="Price" width="20px"
                                                                                height="20px">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="row g-0 ">
                                                                    <div class="col-9 product-price text-start ps-1">
                                                                        {{ number_format($prices->price) }}
                                                                    </div>
                                                                    <div class="col-3 fs-small">
                                                                        @if (app()->getLocale() == 'fa')
                                                                            <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                                alt="Price" width="20px"
                                                                                height="20px">
                                                                        @else
                                                                            <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                                alt="Price" width="20px"
                                                                                height="20px">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
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
            </section>
        @endif
        <!-- end special offers -->
        <!-- start categories -->
        <section>
            <div class="container mb-5 px-0" id="navbar_container">
                <div class=" d-flex align-items-center justify-content-between w-100 p-2 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('shop/assets/svgs/layer-group-solid-full.svg') }}"
                            alt="{{ __('main.categories') }}" width="30">
                        <h2 class="title m-0">{{ __('main.categories') }}</h2>
                    </div>
                </div>
                <div class="row row-cols-2 row-cols-md-6 justify-content-center g-0">
                    @foreach ($allCategories as $category)
                        <div class="col mb-3 d-flex justify-content-center align-items-center">
                            <a href="{{ route($category->link) ?? '#' }}" class="text-decoration-none text-reset">
                                <div class="category-card">
                                    <img src="{{ asset($category->image) }}" alt="تصاویر">
                                    <div class="title">
                                        {{ app()->getLocale() == 'fa' ? $category->title : $category->e_title }}</div>
                                    <div class="count">{{ $category['productsCount'] }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- end categories -->
        <!-- start newest products -->
        <section id="newest">
            <div class="container mb-5 px-0">
                <div class=" d-flex justify-content-between align-items-center p-2 w-100">
                    <div class=" d-flex align-items-center gap-2">
                        <img src="{{ asset('shop/assets/svgs/cup.svg') }}" alt="{{ __('main.newest') }}"
                            width="30">
                        <h2 class="title m-0">{{ __('main.newest') }}</h2>
                    </div>
                    <div class="">
                        <a href="/store/tablecloths" class="btn btn-primary">
                            {{ __('main.viewMore') }}
                        </a>
                    </div>
                </div>
                <div class="row g-0 p-0 p-md-2">
                    @foreach ($newestProducts as $key => $product)
                        @php
                            $prices = $product->orderitemable->prices->where('local', 'تومان')->first();
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
                        @php
                            $score =
                                $product->orderitemable->comments->sum('score') /
                                ($product->orderitemable->comments->count() > 0
                                    ? $product->orderitemable->comments->count()
                                    : 1);
                        @endphp

                        <!-- محصول 1 -->
                        <div class="col-6 col-md-4 col-lg-3 p-1 p-md-2">
                            <div class="product-card">
                                {{-- <div class="discount-badge">20% تخفیف</div> --}}
                                <div class="product-image">
                                    <img src="{{ asset('/storage/images/thumbnails/' . $product->orderitemable->images->first()->name) }}"
                                        alt="{{ $product->orderitemable->category->title }}">
                                </div>
                                <div class="product-body">
                                    <div class="product-info">
                                        <h3 class="product-title">
                                            {{ app()->getLocale() == 'fa' ? $product->orderitemable->category->title : $product->orderitemable->category->e_title }}
                                            {{ __('products.design') }}
                                            {{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->design->title : $product->orderitemable->color_design->design->e_title }}
                                            {{ __('products.color') }}
                                            {{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->color->color : $product->orderitemable->color_design->color->e_color }}
                                        </h3>
                                        <p class="product-description m-0">{{ __('product.category') }}
                                            {{ app()->getLocale() == 'fa' ? $product->orderitemable->category->title : $product->orderitemable->category->e_title }}
                                        </p>
                                    </div>
                                    <div class="product-footer">
                                        <div class="price-container">
                                            <div
                                                class="product-price w-100 d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <div class="text-center">
                                                        <span class="sell-count d-block">{{ $product->sum }}</span>
                                                        <span class="sell-text">{{ __('main.sell') }}</span>
                                                    </div>
                                                    <div class="text-center">
                                                        <span class="rate-count d-block">{{ $score }}</span>
                                                        <span class="rate-text">{{ __('main.Satisfaction') }}</span>
                                                    </div>
                                                    <div class="text-center">
                                                        <span class="rate-count d-block text-danger">
                                                            <a href="#"
                                                                class="text-decoration-none text-reset favorites-btn @if ($product->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                                data-image="{{ asset('/storage/images/thumbnails/' . $product->orderitemable->images->first()->name) }}"
                                                                data-moddel="{{ substr($product->orderitemable_type, 4) }}"
                                                                data-design="{{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->design->title : $product->orderitemable->color_design->design->e_title ?? '' }}"
                                                                data-color="{{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->color->color : $product->orderitemable->color_design->color->e_color ?? '' }}"
                                                                data-title="{{ app()->getLocale() == 'fa' ? $product->orderitemable->category->title : $product->orderitemable->category->e_title }}"
                                                                data-price="{{ $prices->price }}"
                                                                data-pay="{{ $price }}"
                                                                data-off="{{ $off }}"
                                                                data-offType="{{ $prices->offType }}"
                                                                data-local="{{ $prices->local }}"
                                                                data-id="{{ $product->orderitemable->id }}"
                                                                data-model="{{ substr($product->orderitemable_type, 4) }}"
                                                                data-id="{{ $product->orderitemable->id }}"
                                                                data-model="{{ substr($product->orderitemable_type, 4) }}">
                                                                <i class="@if ($product->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) fa-solid text-danger @else fa-regular @endif fa-heart"
                                                                    style="font-size: 18px;"></i>
                                                            </a>
                                                        </span>
                                                        <span class="rate-text">{{ __('main.intrests') }}</span>
                                                    </div>
                                                    <div class="text-center">
                                                        <span class="sell-count d-block">
                                                            <a name="" id=""
                                                                class="text-decoration-none text-reset compare"
                                                                href="#" role="button"
                                                                data-image="{{ asset('/storage/images/thumbnails/' . $product->orderitemable->images->first()->name) }}"
                                                                data-moddel="{{ substr($product->orderitemable->category->model, 4) }}"
                                                                data-design="{{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->design->title : $product->orderitemable->color_design->design->e_title ?? '' }}"
                                                                data-color="{{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->color->color : $product->orderitemable->color_design->color->e_color ?? '' }}"
                                                                data-title="{{ app()->getLocale() == 'fa' ? $product->orderitemable->category->title : $product->orderitemable->category->e_title }}"
                                                                data-price="{{ $prices->price }}"
                                                                data-pay="{{ $price }}"
                                                                data-off="{{ $off }}"
                                                                data-offType="{{ $prices->offType }}"
                                                                data-local="{{ $prices->local }}"
                                                                data-id="{{ $product->orderitemable->id }}"
                                                                data-model="{{ substr($product->orderitemable->category->model, 4) }}"><i
                                                                    class="fa-solid fa-shuffle"></i></a>
                                                        </span>
                                                        <span class="rate-text">{{ __('main.compareWord') }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    @if ($prices->offPrice > 0)
                                                        <div class="row g-0 ">
                                                            <div class="col-8 text-primary text-start ps-1">
                                                                <del
                                                                    class="product-price-off">{{ number_format($prices->price) }}</del>
                                                            </div>
                                                            <div class="col-4"><span
                                                                    class="badge bg-primary product-off">
                                                                    @if ($prices->offType == 'مبلغ')
                                                                        {{ round(($prices->offPrice * 100) / $prices->price, 0) }}%
                                                                    @elseif($prices->offType == 'درصد')
                                                                        {{ $prices->offPrice }}%
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row g-0 ">
                                                            <div class="col-9 product-price text-start ps-1">
                                                                @if ($prices->offType == 'مبلغ')
                                                                    {{ number_format($prices->price - $prices->offPrice) }}
                                                                @elseif($prices->offType == 'درصد')
                                                                    {{ number_format($prices->price - $prices->price * ($prices->offPrice / 100)) }}
                                                                @endif
                                                            </div>
                                                            <div class="col-3 fs-small">
                                                                @if (app()->getLocale() == 'fa')
                                                                    <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                @else
                                                                    <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="price">{{ number_format($prices->price) }}
                                                            @if (app()->getLocale() == 'fa')
                                                                <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                    alt="Price" width="20px" height="20px">
                                                            @else
                                                                <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                    alt="Price" width="20px" height="20px">
                                                            @endif
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="row g-0 w-100 product-footer-outrange">
                                                <div class="col-3 ps-2">
                                                    <button
                                                        class="buy-button add-to-cart @if ($product->orderitemable->quantity != 0) addToCart @endif"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $product->orderitemable->images->first()->name) }}"
                                                        data-id="{{ $product->orderitemable->id }}"
                                                        data-moddel="{{ substr($product->orderitemable_type, 4) }}"
                                                        data-design="{{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->design->title : $product->orderitemable->color_design->design->e_title ?? '' }}"
                                                        data-color="{{ app()->getLocale() == 'fa' ? $product->orderitemable->color_design->color->color : $product->orderitemable->color_design->color->e_color ?? '' }}"
                                                        data-title="{{ app()->getLocale() == 'fa' ? $product->orderitemable->category->title : $product->orderitemable->category->e_title }}"
                                                        data-price="{{ $prices->price }}"
                                                        data-pay="{{ $price }}" data-off="{{ $off }}"
                                                        data-offType="{{ $prices->offType }}"
                                                        data-local="{{ $prices->local }}"><i
                                                            class="fa-solid fa-cart-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-9 pe-2">
                                                    <a class="buy-button text-decoration-none"
                                                        href="
                                                        @switch($product->orderitemable_type)
                                                              @case('App\Tablecloth')
                                                                {{ route('tablecloth.show', [$product->orderitemable->id]) }}
                                                                @break
                                                              @case('App\Pillow')
                                                                {{ route('pillow.show', [$product->orderitemable->id]) }}
                                                                @break
                                                              @case('App\Prayermat')
                                                                {{ route('prayermat.show', [$product->orderitemable->id]) }}
                                                                @break
                                                              @case('App\Bedcover')
                                                                {{ route('bedcover.show', [$product->orderitemable->id]) }}
                                                                @break
                                                              @case('App\Shoe')
                                                                {{ route('shoe.show', [$product->orderitemable->id]) }}
                                                                @break
                                                        @endswitch">{{ __('main.view') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- end newest products -->
        <!-- start instagram -->
        <section>
            <div class="container mb-5 px-0">
                <div id="invite-instagram" class="">
                    <div class="row m-0"
                        style="background: linear-gradient(270deg, #EE295F 0%, #9033C2 100%);
                         border-radius: var(--raduis); height: 80px;
                         align-items: center">
                        <div class="col-2">
                            <!-- empty for image place -->
                        </div>

                        <div class="col-7 col-md-8">
                            <p class="text-white text-center mb-0 text-bold-3">{{ __('main.socialText') }}</p>
                        </div>

                        <div class="col-3 col-md-2">
                            <a class="btn btn-light w-100 text-blue"
                                href="https://www.instagram.com/termehsalari/">{{ __('main.socialClick') }}</a>
                        </div>
                    </div>

                    <img src="{{ asset('shop/assets/svgs/invite-instagram.png') }}" alt="" class="insta-image">
                </div>
            </div>
        </section>
        <!-- end instagram -->
        <!-- start video -->
        <section>
            <div class="video-full-container video-full-container-main mb-5 px-0">
                <video id="fullscreen-video" poster="{{ asset('storage/' . $mainVideo->cover) }}">
                    <!-- منبع ویدیو - میتوانید آدرس ویدیوی خود را جایگزین کنید -->
                    <source src="{{ asset('storage/' . $mainVideo->video) }}" type="video/mp4">
                    مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
                </video>

                <div class="video-overlay video-overlay2"></div>

                <div class="play-pause-btn" id="play-pause-btn">
                    <i class="fas fa-play"></i>
                </div>
            </div>
        </section>
        <!-- end video -->
        <!-- start products -->
        <section id="products">
            <div class="container mb-5 px-0">
                <div class=" d-flex align-items-center justify-content-between w-100  p-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('shop/assets/svgs/cart-shopping-solid-full.svg') }}"
                            alt="{{ __('main.bestSeller') }}" width="30">
                        <h2 class="title m-0">{{ __('main.bestSeller') }}</h2>
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
                            @foreach ($topRequests as $key => $topRequest)
                                @php
                                    $prices = $topRequest->orderitemable->prices->where('local', 'تومان')->first();
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
                                                <img src="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
                                                    alt="{{ $topRequest->orderitemable->category->title }}"
                                                    class="hot-product-image">
                                            </div>
                                            <div class="overlay">
                                                <h3 class="product-title">
                                                    {{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->category->title : $topRequest->orderitemable->category->e_title }}
                                                    {{ __('products.design') }}
                                                    {{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->design->title : $topRequest->orderitemable->color_design->design->e_title }}
                                                    {{ __('products.color') }}
                                                    {{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->color->color : $topRequest->orderitemable->color_design->color->e_color }}
                                                </h3>
                                                <div
                                                    class="product-price w-100 d-flex justify-content-between align-items-center mb-2">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <a href="
                                                            @switch($topRequest->orderitemable_type)
                                                                @case('App\Tablecloth')
                                                                  {{ route('tablecloth.show', [$topRequest->orderitemable->id]) }}
                                                                  @break
                                                                @case('App\Pillow')
                                                                  {{ route('pillow.show', [$topRequest->orderitemable->id]) }}
                                                                  @break
                                                                @case('App\Prayermat')
                                                                  {{ route('prayermat.show', [$topRequest->orderitemable->id]) }}
                                                                  @break
                                                                @case('App\Bedcover')
                                                                  {{ route('bedcover.show', [$topRequest->orderitemable->id]) }}
                                                                  @break
                                                                @case('App\Shoe')
                                                                  {{ route('shoe.show', [$topRequest->orderitemable->id]) }}
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
                                                                @if (app()->getLocale() == 'fa')
                                                                    <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                @else
                                                                    <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="price">{{ number_format($prices->price) }}
                                                                @if (app()->getLocale() == 'fa')
                                                                    <img src="{{ asset('shop/assets/svgs/price.svg') }}"
                                                                        alt="Price" width="20px" height="20px">
                                                                @else
                                                                    <img src="{{ asset('shop/assets/svgs/price_e.svg') }}"
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
                                                    <span class="fs-10">{{ $topRequest->sum }}
                                                        {{ __('main.sellsCount') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center gap-2">
                                                    <button class="buy-button shadow-none add-to-cart compare"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
                                                        data-moddel="{{ substr($topRequest->orderitemable->category->model, 4) }}"
                                                        data-design="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->design->title : $topRequest->orderitemable->color_design->design->e_title ?? '' }}"
                                                        data-color="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->color->color : $topRequest->orderitemable->color_design->color->e_color ?? '' }}"
                                                        data-title="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->category->title : $topRequest->orderitemable->category->e_title }}"
                                                        data-price="{{ $prices->price }}"
                                                        data-pay="{{ $price }}" data-off="{{ $off }}"
                                                        data-offType="{{ $prices->offType }}"
                                                        data-local="{{ $prices->local }}"
                                                        data-id="{{ $topRequest->orderitemable->id }}"
                                                        data-model="{{ substr($topRequest->orderitemable->category->model, 4) }}"
                                                        style="width:30px;height:30px"><i
                                                            class="fa-solid fa-shuffle"></i></button>
                                                    <button
                                                        class="buy-button shadow-none add-to-cart favorites-btn @if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
                                                        data-moddel="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                        data-design="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->design->title : $topRequest->orderitemable->color_design->design->e_title ?? '' }}"
                                                        data-color="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->color->color : $topRequest->orderitemable->color_design->color->e_color ?? '' }}"
                                                        data-title="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->category->title : $topRequest->orderitemable->category->e_title }}"
                                                        data-price="{{ $prices->price }}"
                                                        data-pay="{{ $price }}" data-off="{{ $off }}"
                                                        data-offType="{{ $prices->offType }}"
                                                        data-local="{{ $prices->local }}"
                                                        data-id="{{ $topRequest->orderitemable->id }}"
                                                        data-model="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                        data-id="{{ $topRequest->orderitemable->id }}"
                                                        data-model="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                        style="width:30px;height:30px"><i
                                                            class="@if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) fa-solid @else fa-regular @endif fa-heart text-danger"></i></button>
                                                    <button
                                                        class="buy-button shadow-none add-to-cart @if ($topRequest->orderitemable->quantity != 0) addToCart @endif"
                                                        style="width:30px;height:30px"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
                                                        data-id="{{ $topRequest->orderitemable->id }}"
                                                        data-moddel="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                        data-design="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->design->title : $topRequest->orderitemable->color_design->design->e_title ?? '' }}"
                                                        data-color="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->color_design->color->color : $topRequest->orderitemable->color_design->color->e_color ?? '' }}"
                                                        data-title="{{ app()->getLocale() == 'fa' ? $topRequest->orderitemable->category->title : $topRequest->orderitemable->category->e_title }}"
                                                        data-price="{{ $prices->price }}"
                                                        data-pay="{{ $price }}" data-off="{{ $off }}"
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
        </section>
        <!-- end products -->
        <!-- start Branchs -->
        <section id="branchs">
            <div class="container mb-5 px-0">
                <div class=" d-flex align-items-center gap-2 p-2 pb-0">
                    <img src="{{ asset('shop/assets/svgs/shop-solid-full.svg') }}" alt="{{ __('main.branchs') }}"
                        width="32">
                    <h2 class="title m-0">{{ __('main.branchs') }}</h2>
                </div>

                <div class="slider-container">
                    <!-- اسلایدر کوچک (سمت راست) -->
                    <div class="swiper right-slider">
                        <div class="swiper-wrapper">
                            @foreach ($agencies as $agent)
                                <div class="swiper-slide">
                                    <div class="{{ app()->getLocale() == 'fa' ? 'text-end' : 'text-start' }} w-100">
                                        <h6>{{ app()->getLocale() == 'fa' ? $agent->name_fa : $agent->name_en }}</h6>
                                        <span>{{ __('main.state') }}
                                            {{ app()->getLocale() == 'fa' ? $agent->state->name : $agent->state->e_name }}
                                            -
                                            {{ __('main.city') }}
                                            {{ app()->getLocale() == 'fa' ? $agent->city->name ?? '' : $agent->city->name ?? '' }}</span>
                                    </div>
                                    <img src="{{ asset('storage/' . $agent->image) }}" alt="نمایندگی ترمه سالاری" />
                                </div>
                            @endforeach
                        </div>

                        <!-- کنترل‌های اسلایدر کوچک -->
                        <div class="right-slider-controls">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <!-- اسلایدر اصلی (سمت چپ) -->
                    <div class="swiper left-slider">
                        <div class="swiper-wrapper">
                            <!-- اسلاید 1 با اسلایدر داخلی -->
                            @foreach ($agencies as $agent)
                                <div class="swiper-slide">
                                    <div class="image-section">
                                        <div class="swiper inner-image-slider" data-slider-id="1">
                                            <div class="swiper-wrapper">
                                                @foreach ($agent->images as $image)
                                                    <div class="swiper-slide">
                                                        <img src="{{ asset('storage/images/' . $image->name) }}"
                                                            alt="نمایندگی ترمه سالاری" />
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- کنترل‌های اسلایدر داخلی -->
                                            <div class="inner-slider-controls">
                                                <div class="swiper-button-prev"></div>
                                                <div class="swiper-pagination"></div>
                                                <div class="swiper-button-next"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info d-flex justify-content-between align-items-center">
                                        <p class="flex-grow-1">
                                            {{ app()->getLocale() == 'fa' ? $agent->address_fa : $agent->address_en }}
                                            <br>
                                            <i class="bi bi-telephone ms-1"></i> {{ $agent->phone }}
                                        </p>
                                        <div class="text-start">
                                            <button data-bs-toggle="modal" class="btn btn-primary"
                                                data-bs-target="#mapModal"
                                                data-location="{{ app()->getLocale() == 'fa' ? $agent->address_fa : $agent->address_en }} {{ $agent->phone }}"
                                                data-lat="{{ $agent->latitude }}"
                                                data-lng="{{ $agent->longitude }}">{{ __('main.viewOnMap') }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- کنترل‌های اسلایدر اصلی -->
                        <div class="left-slider-controls">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- مدال نقشه -->
        <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mapModalLabel">موقعیت روی نقشه</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Branchs -->
    </main>
@endsection
@section('script')
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
                const url = `${document.location.origin}/cart/add/${id}/${model}`;

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
                                quantity: 1,
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
                        ${Number(item.price).toLocaleString()} تومان
                    </div>

                    <div class="quantity-controls">
                        <button class="decrease" data-model="${item.model}" data-id="${item.id}">-</button>
                        <span class="count item-quantity">${item.quantity}</span>
                        <button class="increase" data-model="${item.model}" data-id="${item.id}">+</button>
                        <a href="#" class="delete-item me-3"
                            data-id="${item.id}"
                            data-model="${item.model}">
                            <i class="fa-solid fa-close text-danger"></i>
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
                        "{{ __('js.operation_error') }}" :
                        "{{ __('js.operation_success') }}";

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
                            ${item.title} {{ __('products.design') }} ${item.design} {{ __('products.color') }} ${item.color}
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

        $(document).on("click", ".compare", function(event) {
            event.preventDefault();
            var id = $(this).data("id");
            var model = $(this).data("model");
            var $btn = $(this);
            const image = $btn.data('image');
            const title = $btn.data('title');
            const design = $btn.data('design');
            const color = $btn.data('color');
            const price = $btn.data('price');

            const card = $btn.closest('.product-card');
            if (card) {
                $btn.removeClass('hovered'); // حذف کلاس
                card.removeClass('hovered'); // حذف کلاس
            }
            // برداشتن فوکوس از روی دکمه (مهم!)
            if (document.activeElement && document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }

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
                                ${title} {{ __('products.design') }} ${design} {{ __('products.color') }} ${color}
                            </div>
                            <div class="cart-item-price">
                                ${Number(price).toLocaleString()} تومان
                            </div>
                            <div
                                class="d-flex justify-content-start gap-2 align-items-center w-100 bg-white">
                                <button class="buy-button add-to-cart close"
                                    data-id="${id}" style="width: 30px;height:30px"><i
                                        class="fa-solid fa-close text-danger fa-lg"></i></button>
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









        function updateCountdown() {
            $(".countdown-timer").each(function() {
                // برای هر تایمر شمارش معکوس
                const endDateStr = $(this).data("end-date"); // تاریخ پایان
                const endDate = new Date(endDateStr);
                const now = new Date();
                const timeLeft = endDate - now;
                // alert(endDateStr);
                // alert(endDate);
                // alert(now);

                if (timeLeft > 0) {
                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor(
                        (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
                    );
                    const minutes = Math.floor(
                        (timeLeft % (1000 * 60 * 60)) / (1000 * 60),
                    );
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    $(this)
                        .find(".days")
                        .html(
                            pad(days) +
                            '<span class="d-block text-dark timer-label">{{ __('main.day') }}</span>',
                        );
                    $(this)
                        .find(".hours")
                        .html(
                            pad(hours) +
                            '<span class="d-block text-dark timer-label">{{ __('main.hour') }}</span>',
                        );
                    $(this)
                        .find(".minutes")
                        .html(
                            pad(minutes) +
                            '<span class="d-block text-dark timer-label">{{ __('main.minutes') }}</span>',
                        );
                    $(this)
                        .find(".seconds")
                        .html(
                            pad(seconds) +
                            '<span class="d-block text-dark timer-label">{{ __('main.seconds') }}</span>',
                        );
                } else {
                    $(this)
                        .find(".days")
                        .html(
                            0 +
                            '<span class="d-block text-dark timer-label">{{ __('main.day') }}</span>',
                        );
                    $(this)
                        .find(".hours")
                        .html(
                            0 +
                            '<span class="d-block text-dark timer-label">{{ __('main.hour') }}</span>',
                        );
                    $(this)
                        .find(".minutes")
                        .html(
                            0 +
                            '<span class="d-block text-dark timer-label">{{ __('main.minutes') }}</span>',
                        );
                    $(this)
                        .find(".seconds")
                        .html(
                            0 +
                            '<span class="d-block text-dark timer-label">{{ __('main.seconds') }}</span>',
                        );
                }
            });

            function pad(num) {
                return num < 10 ? "0" + num : num;
            }
        }

        updateCountdown(); // اجرای اولیه
        setInterval(updateCountdown, 1000); // بروزرسانی هر ثانیه
    </script>
@endsection
