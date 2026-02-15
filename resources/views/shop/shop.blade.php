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
                                                        <img src="{{ asset($image->image) }}"
                                                            style="height:400px;object-fit:cover;width:100%;">
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
                    <div class="d-flex justify-content-between align-items-center p-4 px-5 pt-0">
                        <a href="#" class="btn btn-primary" id="popup-more-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                            اطلاعات بیشتر
                        </a>
                        <!-- 👇 pagination بیاد اینجا -->
                        <div id="popup-pagination-holder"></div>
                        <button class="btn btn-text-link" data-bs-dismiss="modal">
                            بعدا چک میکنم
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
                                <div class="item" data-duration="5000">
                                    @if ($slideshow->video)
                                        <div class="video-full-container video-full-container-slider mb-5 px-0">
                                            <video class="slider-video" poster="{{ asset('storage/images/' . $slideshow->image) }}">
                                                <!-- منبع ویدیو - میتوانید آدرس ویدیوی خود را جایگزین کنید -->
                                                <source src="{{ asset('storage/videos/' . $slideshow->video) }}" type="video/mp4">
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
        @if (isset($topRequests) and count($topRequests) > 0)
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
                                        <div class="flip-card">
                                            <div class="flip-card-inner">
                                                <!-- جلوی کارت -->
                                                <div class="flip-card-front d-flex flex-column justify-content-between">
                                                    <div class="position-relative image-badge pb-1">
                                                        <img src="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
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
                                                                        class="fa-solid fa-heart @if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) text-danger @else text-white @endif "></i>
                                                                </strong>
                                                            </span>
                                                        </div> --}}
                                                        <a href="#"
                                                            class="discount-squer discount-squer-front favorites-btn @if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                            data-id="{{ $topRequest->orderitemable->id }}"
                                                            data-model="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                            style="position: absolute;top: -4px;right: 20px;">
                                                            <img src="{{ asset('shop/assets/svgs/heart-back.svg') }}"
                                                                width="35" alt="discount"
                                                                style="height: 31px;object-fit: cover;">
                                                            <span class="d-flex"
                                                                style="font-size: 12px;font-weight: 800;position: absolute;right: 9px;top: 2px;">
                                                                <strong class="" style="font-size: 18px;">
                                                                    <i
                                                                        class="fa-solid fa-heart @if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) text-danger @else text-white @endif "></i>
                                                                </strong>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div
                                                        class="details h-100 d-flex flex-column justify-content-between text-start pt-2">
                                                        <div
                                                            class="d-flex align-items-center align-content-center justify-content-start mb-2">
                                                            <h5 class="product-title text-end">
                                                                {{ $topRequest->orderitemable->category->title }} طرح
                                                                {{ $topRequest->orderitemable->color_design->design->title }}
                                                                رنگ
                                                                {{ $topRequest->orderitemable->color_design->color->color }}
                                                            </h5>
                                                        </div>
                                                        <div
                                                            class="product-details d-flex align-items-center justify-content-between gap-2">
                                                            <div
                                                                class=" w-50 h-100 text-center d-flex justify-content-center align-items-center">
                                                                <div class="countdown-timer timer-short justify-content-between"
                                                                    id="countdown-1" data-end-date="2025-12-30">
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
                                                                    @if ($prices->offType == 'مبلغ')
                                                                        {{ number_format($prices->price - $prices->offPrice) }}
                                                                    @elseif($prices->offType == 'درصد')
                                                                        {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                                    @endif

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
                                                                                {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-3 fs-small"><svg
                                                                                viewBox="0 0 15 16" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="20" height="20">
                                                                                <path
                                                                                    d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                                    fill="#A3A3A3"></path>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="row g-0 ">
                                                                        <div class="col-9 product-price text-start ps-1">
                                                                            {{ number_format($prices->price) }}
                                                                        </div>
                                                                        <div class="col-3 fs-small"><svg
                                                                                viewBox="0 0 15 16" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="20" height="20">
                                                                                <path
                                                                                    d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                                    fill="#A3A3A3"></path>
                                                                            </svg></div>
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
                                                    <a href="#"
                                                        class="discount-squer favorites-btn @if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
                                                        data-moddel="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                        data-design="{{ $topRequest->orderitemable->color_design->design->title ?? '' }}"
                                                        data-color="{{ $topRequest->orderitemable->color_design->color->color ?? '' }}"
                                                        data-title="{{ $topRequest->orderitemable->title }}"
                                                        data-price="{{ $prices->price }}" data-pay="{{ $price }}"
                                                        data-off="{{ $off }}"
                                                        data-offType="{{ $prices->offType }}"
                                                        data-local="{{ $prices->local }}"
                                                        data-id="{{ $topRequest->orderitemable->id }}"
                                                        data-model="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                        style="position: absolute;top: 4px;right: 20px;">
                                                        <img src="{{ asset('shop/assets/svgs/heart-back.svg') }}"
                                                            width="35" alt="discount"
                                                            style="height: 31px;object-fit: cover;">
                                                        <span class="d-flex"
                                                            style="font-size: 12px;font-weight: 800;position: absolute;right: 9px;top: 2px;">
                                                            <strong class="" style="font-size: 18px;">
                                                                <i
                                                                    class="fa-solid fa-heart @if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) text-danger @else text-white @endif "></i>
                                                            </strong>
                                                        </span>
                                                    </a>
                                                    <div class="d-flex btn-row align-items-center align-content-center justify-content-center mb-2 h-100 w-100"
                                                        style="flex-direction: column;padding: 0 22px;">
                                                        <div class="text-center">
                                                            <h5 class="product-title text-center mb-4">
                                                                {{ $topRequest->orderitemable->category->title }} طرح
                                                                {{ $topRequest->orderitemable->color_design->design->title }}
                                                                رنگ
                                                                {{ $topRequest->orderitemable->color_design->color->color }}
                                                            </h5>
                                                            <div class="row g-0 w-100">
                                                                <div class="col-3 ps-2">
                                                                    <button
                                                                        class="buy-button add-to-cart @if ($topRequest->orderitemable->quantity != 0) addToCart @endif"
                                                                        data-image="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
                                                                        data-id="{{ $topRequest->orderitemable->id }}"
                                                                        data-moddel="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                                        data-design="{{ $topRequest->orderitemable->color_design->design->title ?? '' }}"
                                                                        data-color="{{ $topRequest->orderitemable->color_design->color->color ?? '' }}"
                                                                        data-title="{{ $topRequest->orderitemable->title }}"
                                                                        data-price="{{ $prices->price }}"
                                                                        data-pay="{{ $price }}"
                                                                        data-off="{{ $off }}"
                                                                        data-offType="{{ $prices->offType }}"
                                                                        data-local="{{ $prices->local }}"><i
                                                                            class="fa-solid fa-cart-plus"></i></button>
                                                                </div>
                                                                <div class="col-9 pe-2">
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
                                                                        class="buy-button text-decoration-none">مشاهده</a>
                                                                    <span class="fs-10 p-0">
                                                                        @if ($topRequest->orderitemable->quantity == 0)
                                                                            اتمام موجودی در انبار
                                                                        @elseif($topRequest->orderitemable->quantity <= 5)
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
                                                                id="countdown-1" data-end-date="2025-12-30">
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
                                                                @if ($prices->offType == 'مبلغ')
                                                                    {{ number_format($prices->price - $prices->offPrice) }}
                                                                @elseif($prices->offType == 'درصد')
                                                                    {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                                @endif

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
                                                                            {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-3 fs-small"><svg viewBox="0 0 15 16"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="20" height="20">
                                                                            <path
                                                                                d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                                fill="#A3A3A3"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="row g-0 ">
                                                                    <div class="col-9 product-price text-start ps-1">
                                                                        {{ number_format($prices->price) }}
                                                                    </div>
                                                                    <div class="col-3 fs-small"><svg viewBox="0 0 15 16"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="20" height="20">
                                                                            <path
                                                                                d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                                fill="#A3A3A3"></path>
                                                                        </svg></div>
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
            <div class="container mb-5 px-0">
                <div class=" d-flex align-items-center justify-content-between w-100 p-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('shop/assets/svgs/layer-group-solid-full.svg') }}"
                            alt="{{ __('main.categories') }}" width="30">
                        <h2 class="title m-0">{{ __('main.categories') }}</h2>
                    </div>
                    <div class="">
                        <!-- دکمه‌های کنترل جداگانه -->
                        <div class="custom-splide-controls">
                            <button class="splide-prev-btn splide-category-prev-btn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                            <span id="category-range" class="slide-range">1-5</span>
                            <button class="splide-next-btn splide-category-next-btn">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <section class="splide" id="categories" aria-label="دسته بندی‌ها">
                    <div class="splide__track py-3">
                        <ul class="splide__list justify-content-cecnter" style="justify-content: center;">
                            @foreach ($allCategories as $category)
                                <li class="splide__slide">
                                    <a href="{{ route($category->link) ?? '#' }}"
                                        class="text-decoration-none text-reset">
                                        <div class="category-card">
                                            <img src="{{ asset($category->image) }}" alt="تصاویر">
                                            <div class="title">{{ $category->title }}</div>
                                            <div class="count">{{ $category['productsCount'] }}</div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
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
                        <a href="#" class="btn btn-primary">
                            مشاهده بیشتر
                        </a>
                    </div>
                </div>
                <div class="row g-0 p-2">
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
                        <div class="col-md-4 col-lg-3 p-2">
                            <div class="product-card">
                                {{-- <div class="discount-badge">20% تخفیف</div> --}}
                                <div class="product-image">
                                    <img src="{{ asset('/storage/images/thumbnails/' . $product->orderitemable->images->first()->name) }}"
                                        alt="{{ $product->orderitemable->category->title }}">
                                </div>
                                <div class="product-body">
                                    <div class="product-info">
                                        <h3 class="product-title">{{ $product->orderitemable->category->title }} طرح
                                            {{ $product->orderitemable->color_design->design->title }}
                                            رنگ
                                            {{ $product->orderitemable->color_design->color->color }}</h3>
                                        <p class="product-description">دسته بندی
                                            {{ $product->orderitemable->category->title }}
                                        </p>
                                    </div>
                                    <div class="product-footer">
                                        <div class="price-container">
                                            <div
                                                class="product-price w-100 d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <div class="text-center">
                                                        <span class="sell-count d-block">{{ $product->sum }}</span>
                                                        <span class="sell-text">فروش</span>
                                                    </div>
                                                    <div class="text-center">
                                                        <span class="rate-count d-block">{{ $score }}</span>
                                                        <span class="rate-text">رضایت</span>
                                                    </div>
                                                    <div class="text-center">
                                                        <span class="rate-count d-block text-danger">
                                                            <a href="#"
                                                                class="text-decoration-none text-reset favorites-btn @if ($product->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                                data-image="{{ asset('/storage/images/thumbnails/' . $product->orderitemable->images->first()->name) }}"
                                                                data-moddel="{{ substr($product->orderitemable_type, 4) }}"
                                                                data-design="{{ $product->orderitemable->color_design->design->title ?? '' }}"
                                                                data-color="{{ $product->orderitemable->color_design->color->color ?? '' }}"
                                                                data-title="{{ $product->orderitemable->title }}"
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
                                                        <span class="rate-text">علاقه‌مندی</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    @if ($prices->offPrice > 0)
                                                        @if ($prices->offType == 'مبلغ')
                                                            {{ number_format($prices->price - $prices->offPrice) }}
                                                        @elseif($prices->offType == 'درصد')
                                                            {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                        @endif

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
                                                                    {{ $prices->price - $prices->price * ($prices->offPrice / 100) }}
                                                                @endif
                                                            </div>
                                                            <div class="col-3 fs-small"><svg viewBox="0 0 15 16"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20">
                                                                    <path
                                                                        d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                        fill="#A3A3A3"></path>
                                                                </svg>
                                                            </div>
                                                        </div>


                                                        <span
                                                            class="d-flex align-items-center justify-content-between mb-1"
                                                            dir="ltr"><del class="old-price">
                                                                {{ number_format($prices->price) }}
                                                            </del><span class="badge bg-danger">
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
                                            <div class="row g-0 w-100 product-footer-outrange">
                                                <div class="col-3 ps-2">
                                                    <button
                                                        class="buy-button add-to-cart @if ($product->orderitemable->quantity != 0) addToCart @endif"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $product->orderitemable->images->first()->name) }}"
                                                        data-id="{{ $product->orderitemable->id }}"
                                                        data-moddel="{{ substr($product->orderitemable_type, 4) }}"
                                                        data-design="{{ $product->orderitemable->color_design->design->title ?? '' }}"
                                                        data-color="{{ $product->orderitemable->color_design->color->color ?? '' }}"
                                                        data-title="{{ $product->orderitemable->title }}"
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
                                                        @endswitch">مشاهده
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

                        <div class="col-8">
                            <p class="text-white text-center mb-0 text-bold-3">{{ __('main.socialText') }}</p>
                        </div>

                        <div class="col-2">
                            <a class="btn btn-light w-100 text-blue"
                                href="https://www.instagram.com/termehsalari/">{{ __('main.socialClick') }}</a>
                        </div>
                    </div>

                    <img src="{{ asset('shop/assets/svgs/invite-instagram.png') }}" alt=""
                        style="height: 160px; margin-top: -120px">
                </div>
            </div>
        </section>
        <!-- end instagram -->
        <!-- start video -->
        <section>
            <div class="video-full-container video-full-container-main mb-5 px-0">
                <video id="fullscreen-video" poster="{{ asset('shop/assets/cover.png') }}">
                    <!-- منبع ویدیو - میتوانید آدرس ویدیوی خود را جایگزین کنید -->
                    <source src="{{ asset('shop/assets/termesalari.mp4') }}" type="video/mp4">
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
                                                    {{ $topRequest->orderitemable->category->title }} طرح
                                                    {{ $topRequest->orderitemable->color_design->design->title }}
                                                    رنگ
                                                    {{ $topRequest->orderitemable->color_design->color->color }}</h3>
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
                                                    <span class="fs-10">{{ $topRequest->sum }} عدد فروش رفته</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center gap-2">
                                                    <button
                                                        class="buy-button shadow-none add-to-cart favorites-btn @if ($topRequest->orderitemable->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                                        data-image="{{ asset('/storage/images/thumbnails/' . $topRequest->orderitemable->images->first()->name) }}"
                                                        data-moddel="{{ substr($topRequest->orderitemable_type, 4) }}"
                                                        data-design="{{ $topRequest->orderitemable->color_design->design->title ?? '' }}"
                                                        data-color="{{ $topRequest->orderitemable->color_design->color->color ?? '' }}"
                                                        data-title="{{ $topRequest->orderitemable->title }}"
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
                                                        data-design="{{ $topRequest->orderitemable->color_design->design->title ?? '' }}"
                                                        data-color="{{ $topRequest->orderitemable->color_design->color->color ?? '' }}"
                                                        data-title="{{ $topRequest->orderitemable->title }}"
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
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>تهران</h6>
                                    <span>آقای صفائی</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>تهران</h6>
                                    <span>آقای میرزایی</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>مشهد</h6>
                                    <span>آقای شفاجو</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>رفسنجان</h6>
                                    <span>آقای عربی</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>اصفهان</h6>
                                    <span>آقای شجائی</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>کرمان</h6>
                                    <span>آقای نیک نفس</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>قزوین</h6>
                                    <span>خانم حاتمی</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>یاسوج</h6>
                                    <span>خانم کیانوش</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
                            <div class="swiper-slide">
                                <div class="text-end w-100">
                                    <h6>نجف آباد اصفهان</h6>
                                    <span>خانم اکبری</span>
                                </div>
                                <img src="{{ asset('shop/assets/svgs/person.png') }}" alt="نمایندگی ترمه سالاری" />
                            </div>
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
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    <p class="flex-grow-1">بازار کفاش ها - خانه ترمه ایران
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 035-36260637
                                    </p>
                                    <div class="text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="تهران آقای صفائی بازار کفاش ها - خانه ترمه ایران 035-36260637"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">تهران</h3> --}}
                                    <p class="flex-grow-1">مینی سیتی - شهرک شهید محلاتی
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 035-36260637
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="تهران آقای میرزایی مینی سیتی - شهرک شهید محلاتی 035-36260637"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">مشهد</h3> --}}
                                    <p class="flex-grow-1">چهارراه خسروی - پاساژ جواد - طبقه اول
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 05132253572
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="مشهد آقای شفاجو چهارراه خسروی - پاساژ جواد - طبقه اول 05132253572"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">رفسنجان</h3> --}}
                                    <p class="flex-grow-1">خ شهدا پاساژ بزرگ شهر طبقه زیرین اولین مغازه سمت راست ترمه سرای
                                        عربی
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 03434265741
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="رفسنجان آقای عربی خ شهدا پاساژ بزرگ شهر طبقه زیرین اولین مغازه سمت راست ترمه سرای عربی 03434265741"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">اصفهان</h3> --}}
                                    <p class="flex-grow-1">میدان نقش جهان
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 035-36260637
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="اصفهان آقای شجائی میدان نقش جهان  035-36260637"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">کرمان</h3> --}}
                                    <p class="flex-grow-1">سه راهی شمال جنوبی - جنب مسجد شیخها - ترمه ابریشم
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 03432239460
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="کرمان آقای نیک نفس  سه راهی شمال جنوبی - جنب مسجد شیخها - ترمه ابریشم 03432239460"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">قزوین</h3> --}}
                                    <p class="flex-grow-1">خیابان فردوسی - بعد از چهارراه بوعلی - جنب تالار فرهنگیان - ترمه
                                        سیان
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 02833359101
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="قزوین خانم حاتمی خیابان فردوسی - بعد از چهارراه بوعلی - جنب تالار فرهنگیان - ترمه سیان 02833359101"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">یاسوج</h3> --}}
                                    <p class="flex-grow-1">خیابان30 متری معاد
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 035-36260637
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="یاسوج خانم کیانوش خیابان30 متری معاد 035-36260637"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="image-section">
                                    <div class="swiper inner-image-slider" data-slider-id="1">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('shop/assets/sliders/branch2.png') }}"
                                                    alt="نمایندگی ترمه سالاری" />
                                            </div>
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
                                    {{-- <h3 class="mb-3">نجف آباد اصفهان</h3> --}}
                                    <p class="flex-grow-1">مجتمع تجاری فردوسی - صنایع ترمه
                                        <br>
                                        <i class="bi bi-telephone ms-1"></i> 035-36260637
                                    </p>
                                    <div class=" text-start">
                                        <button data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#mapModal"
                                            data-location="نجف آباد اصفهان خانم اکبری  مجتمع تجاری فردوسی - صنایع ترمه 035-36260637"
                                            data-lat="31.89413819001718" data-lng="54.36943179325213">مشاهده روی
                                            نقشه</button>
                                    </div>
                                </div>
                            </div>
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
                const title = `${$btn.data('title')} طرح ${$btn.data('design')} رنگ ${$btn.data('color')}`;
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
                                    title: "محصول به سبد خرید اضافه شد!",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "خطا در افزودن محصول!",
                                text: "لطفاً دوباره تلاش کنید."
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
                                    <img src="{{ asset('hometemplate/img/logo.png') }}" width="30">
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
    </script>
@endsection
