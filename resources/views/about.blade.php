@extends('shop.layouts.master')
@section('title', 'درباره ما')
@section('head')
    <link rel="stylesheet" href="https://lib.arvancloud.ir/leaflet/1.9.3/leaflet.css" />
    {{-- <link rel="stylesheet" href="{{ asset('shop/css/leaflet.css') }}" /> --}}
    {{-- <script src="{{ asset('shop/js/leaflet.js') }}"></script> --}}
    <script src="https://lib.arvancloud.ir/leaflet/1.9.3/leaflet.js"></script>
    <script src="https://lib.arvancloud.ir/leaflet/1.9.3/leaflet.js.map"></script>
    {{-- <link rel="stylesheet" href="{{ asset('shop/css/footerNew.css') }}"> --}}
    @if (app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('shop/css/about.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('shop/css/ltr/about.css') }}">
    @endif
    <script src="{{ asset('shop/js/map/mapdata.js') }}"></script>
    <script src="{{ asset('shop/js/map/countrymap.js') }}"></script>
    @if (app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('shop/css/video.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('shop/css/ltr/video.css') }}">
    @endif
    <script src="{{ asset('shop/js/scripts.js') }}"></script>

    <!-- video -->

    <script src="{{ asset('shop/js/video.js') }}"></script>
    <style>
        #map a {
            display: none !important;
        }

        .leaflet-popup-content {
            font-family: 'Vazir FD', sans-serif;
        }

        .main-office-map {
            max-width: 1100px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .main-office-map h3 {
            margin-bottom: 20px;
            font-size: 22px;
        }

        #officeMap {
            height: 100%;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
        }
    </style>
@endsection
@section('content')
    <div class="container py-4" style="margin-top: 70px">
        {{-- family start --}}
        <div class="row p-3 mb-4">

            @foreach ($generations as $generation)
                <!-- نفر اول -->
                <div class="col-md-4 px-0 builder-col">
                    <div class="ps-3 h-100">
                        <div class="d-flex justify-content-between align-items-end">
                            <img src="{{ asset('storage/'.$generation->image) }}" alt="founder" class="builder-image">
                            <div class="flex-grow-1 d-flex justify-content-between align-items-center mb-2 px-3 ps-4">
                                <span class="builder-title">
                                    {{ app()->getLocale() == 'fa' ? $generation->name_fa : $generation->name_en }} <br>
                                    <small>{{ app()->getLocale() == 'fa' ? $generation->pretext_fa : $generation->pretext_en }}</small>
                                </span>
                                <img src="{{ asset('hometemplate/img/logo.png') }}" alt="logo" width="40">
                            </div>
                        </div>
                        <div class="pb-4 px-4 pt-5 builder-text">
                            {{ app()->getLocale() == 'fa' ? $generation->description_fa : $generation->description_en }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- family end --}}
        {{-- mission start --}}
        <div class="row p-3 py-5 mb-4 bg-white rounded-3 g-0 mx-1 gap-4">

            <div class="col-md-3">
                <div class="video-full-container video-full-container-main mb-5 px-0 shadow">
                    <video id="fullscreen-video" class="w-100 h-100" poster="{{ asset('shop/assets/cover2.png') }}">
                        <source src="{{ asset('shop/assets/yalda.mp4') }}" type="video/mp4">
                        {{ __('general.video_not_supported') ?? 'Your browser does not support the video tag.' }}
                    </video>

                    <div class="video-overlay video-overlay2"></div>

                    <div class="play-pause-btn" id="play-pause-btn">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
            </div>

            <div class="col">

                <header class="section-header">
                    <h3>{{ __('about.mission_title') }}</h3>
                </header>

                <p class="mission-text mb-4">
                    {{ __('about.mission_text') }}
                </p>

                <div class="row mission-row p-0 bg-white rounded-4 shadow-sm mx-3">

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="220">0</span>
                            <span>{{ __('about.counter_product') }}</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="160">0</span>
                            <span>{{ __('about.counter_design') }}</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="186">0</span>
                            <span>{{ __('about.counter_customer') }}</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="10">0</span>
                            <span>{{ __('about.counter_agency') }}</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="100">0</span>
                            <span>{{ __('about.counter_project') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- mission end --}}
        {{-- about us start --}}
        <section id="about" class="mb-5 mx-1"
            style="background: url({{ asset('/hometemplate/img/facts-bg.jpg') }}) center top no-repeat fixed;z-index: 1;">
            <div class="container">
                <header class="section-header">
                    <h3>{{ __('about.authenticity_title') }}</h3>
                    <p>{{ __('about.authenticity_text') }}</p>
                    <img src="{{ asset('/hometemplate/img/original.png') }}" alt="originality seal">
                </header>
            </div>
        </section>
        {{-- about us end --}}
        {{-- comments start --}}
        <section class="mb-5">
            <div class="row">

                <div class="col-md-6 px-4">
                    <h1 class="comment-title">
                        {{ __('about.trust_title_line_1') }}
                        <span class="etemad">{{ __('about.trust_title_highlight') }}</span>
                        {{ __('about.trust_title_line_2') }}
                    </h1>

                    <p class="commetn-text">
                        {{ __('about.trust_text') }}
                    </p>

                    <div class="row mission-row p-0 g-0 bg-white rounded-4 shadow-sm" style="margin-top: 28px;">
                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number" data-target="100">0</span>
                                <span>{{ __('about.trust_years') }}</span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number" data-target="186">0</span>
                                <span>{{ __('about.trust_users') }}</span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number" data-target="13">0</span>
                                <span>{{ __('about.trust_agencies') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 ps-0">
                    <div class="testimonial-slider">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">

                                <!-- Testimonial 1 -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="user">
                                                <img src="{{ asset('storetemplate/dist/img/user.png') }}" alt="user">
                                                <div>
                                                    <h4>{{ __('about.testimonial_1_name') }}</h4>
                                                    <span>{{ __('about.testimonial_role') }}</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>{{ __('about.testimonial_1_text') }}</p>
                                    </div>
                                </div>

                                <!-- Testimonial 2 -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="user">
                                                <img src="{{ asset('storetemplate/dist/img/user.png') }}" alt="user">
                                                <div>
                                                    <h4>{{ __('about.testimonial_2_name') }}</h4>
                                                    <span>{{ __('about.testimonial_role') }}</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>{{ __('about.testimonial_2_text') }}</p>
                                    </div>
                                </div>

                                <!-- Testimonial 3 -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="user">
                                                <img src="{{ asset('storetemplate/dist/img/user.png') }}" alt="user">
                                                <div>
                                                    <h4>{{ __('about.testimonial_3_name') }}</h4>
                                                    <span>{{ __('about.testimonial_role') }}</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>{{ __('about.testimonial_3_text') }}</p>
                                    </div>
                                </div>

                            </div>

                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        {{-- comments end --}}
        {{-- lisence start --}}
        <section class="mb-5">
            <div class="container">
                <div class="container mb-5 px-0">
                    <header class="section-header">
                        <h3>{{ __('about.ip_title') }}</h3>
                    </header>

                    <div class="d-flex align-items-center justify-content-between w-100 p-2">
                        <div>
                            <span>{{ __('about.ip_text') }}</span>
                        </div>

                        <div>
                            <div class="custom-splide-controls px-0">
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
                        <div class="splide__track py-4">
                            <ul class="splide__list py-4">
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/1.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/2.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/3.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/4.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/5.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/6.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/7.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/8.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/9.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/10.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('/hometemplate/img/certificate/11.jpg') }}"
                                        alt="حقوق مالکیت معنوی">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="imgModal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-transparent border-0">
                        <img id="modalImage" src="" class="w-100 rounded shadow">
                    </div>
                </div>
            </div>

        </section>
        {{-- lisence end --}}
        {{-- partners start --}}
        <div class="elementor-element elementor-element-4f43ad3 e-flex e-con-boxed e-con e-parent mb-5" data-id="4f43ad3"
            data-element_type="container">
            <div class="e-con-inner px-2">
                <div class="elementor-element elementor-element-d65e440 elementor-widget elementor-widget-luxina_customers"
                    data-id="d65e440" data-element_type="widget" data-widget_type="luxina_customers.default">
                    <div class="elementor-widget-container">
                        <div class="luxina_customers_container">
                            <div class="luxina_customers_title-wrap title-in-items">
                                <span class="luxina_customers_title-bg" aria-hidden="true"></span>
                                <i class="luxina-icon-user-star-fill luxina_customers_title-icon" aria-hidden="true"></i>
                                <span class="luxina_customers_title-text">
                                    {{ __('about.customers_fa') }}
                                </span>
                                <span class="luxina_customers_title-subtitle">
                                    {{ __('about.customers_en') }}
                                </span>
                            </div>
                            <div class="luxina_customers_items" style="--desktop-cols:5;--tablet-cols:4;--mobile-cols:2">
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('/hometemplate/img/clients/client-1.png') }}"
                                        class="luxina_customers_item-img" alt="">
                                    <span class="luxina_customers_item-square hide-desktop hide-tablet hide-mobile"
                                        aria-hidden="true"></span>
                                </div>
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('/hometemplate/img/clients/client-2.png') }}"
                                        class="luxina_customers_item-img" alt="">
                                    <span class="luxina_customers_item-square" aria-hidden="true"></span>
                                </div>
                                <span class="luxina_customers_item title-placeholder show-only-desktop desktop-first-row"
                                    aria-hidden="true">
                                    <span class="luxina_customers_item-square" aria-hidden="true"></span>
                                </span>
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('/hometemplate/img/clients/client-3.png') }}"
                                        class="luxina_customers_item-img" alt="">
                                    <span class="luxina_customers_item-square hide-mobile" aria-hidden="true"></span>
                                </div>
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('/hometemplate/img/clients/client-4.png') }}"
                                        class="luxina_customers_item-img" alt="">
                                    <span class="luxina_customers_item-square" aria-hidden="true"></span>
                                </div>
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('/hometemplate/img/clients/client-5.png') }}"
                                        class="luxina_customers_item-img" alt="">
                                    <span class="luxina_customers_item-square hide-desktop hide-tablet hide-mobile"
                                        aria-hidden="true"></span>
                                </div>
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('/hometemplate/img/clients/client-6.png') }}"
                                        class="luxina_customers_item-img" alt="">
                                    <span class="luxina_customers_item-square hide-desktop" aria-hidden="true"></span>
                                </div>
                                <div class="luxina_customers_item">
                                    <img decoding="async"
                                        src="{{ asset('shop/assets/logo/Tejarat bank logo Vector.png') }}"
                                        class="luxina_customers_item-img w-50" alt="">
                                    <span class="luxina_customers_item-square hide-desktop" aria-hidden="true"></span>
                                </div>
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('shop/assets/logo/sepah.png') }}"
                                        class="luxina_customers_item-img w-50" alt="">
                                    <span class="luxina_customers_item-square hide-desktop" aria-hidden="true"></span>
                                </div>
                                <div class="luxina_customers_item">
                                    <img decoding="async" src="{{ asset('shop/assets/logo/saman.png') }}"
                                        class="luxina_customers_item-img w-50" alt="">
                                    <span class="luxina_customers_item-square hide-desktop" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- partners end --}}
        {{-- branch map start --}}
        <section class="branch-map mb-5 mt-4 px-1">
            <div class="row mb-3">
                <header class="section-header">
                    <h3>{{ __('main.branchs') }}</h3>
                </header>
                <div class="col-md-3 col-3 d-flex flex-column justify-content-around align-items-center gap-3 labels-col"
                    id="branch-labels-left">
                </div>
                <div class="col-md-6 col-6">
                    <div class="map-wrapper">
                        <!-- نقشه -->
                        <div id="map"></div>
                    </div>
                </div>
                <div class="col-md-3 col-3 d-flex flex-column justify-content-around align-items-center gap-3 labels-col"
                    id="branch-labels-right">
                </div>
            </div>
            <div class="row">
                <div id="branchs-slider" class="splide">
                    <div class="splide__track py-3">
                        <ul class="splide__list py-3">
                            @foreach ($agencies as $agent)
                                <li class="splide__slide">
                                    <div class="horizontal-card">
                                        <div class="card-image">
                                            <img src="{{ asset('storage/' . $agent->image) }}" alt="نمایندگی">
                                        </div>
                                        <div class="card-info">
                                            <h3 class="card-title">نمایندگی استان {{ $agent->state->name }} - شهر
                                                {{ $agent->city->name }}</h3>
                                            <div class="card-detail">
                                                <i class="fa fa-map-marker"></i>
                                                {{ $agent->address_fa }}
                                            </div>
                                            <div class="card-detail">
                                                <i class="fa fa-phone"></i>
                                                {{ $agent->phone }}
                                            </div>
                                            <div class="card-detail">
                                                <i class="fa fa-mobile"></i>
                                                {{ $agent->mobile }}
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
        {{-- branch map end --}}
        {{-- contact start --}}
        <section>
            <div class="row bg-white rounded-4 mb-4 g-0  shadow-sm">
                <div class="col-md-5 p-4">
                    <header class="section-header">
                        <h3>{{ __('about.contact_title') }}</h3>
                    </header>
                    <form action="{{ route('message.store') }}" method="post">
                        @csrf
                        <div class="mb-3 mt-4">
                            <div class="autocomplete @error('name') filled @enderror" id="autocompleteBoxname">
                                <input type="text" id="searchInputname" value="{{ old('name') }}" class=""
                                    name="name" oninput="nameinput('name')">
                                <label for="searchInputname">{{ __('about.form_name') }}</label>
                                <span class="clear-btn" id="clearBtn_name" onclick="clearInput('name')"
                                    @if (old('name')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('name')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 mt-4">
                            <div class="autocomplete @error('mobile') filled @enderror" id="autocompleteBoxmobile">
                                <input type="text" class="only-number" id="searchInputmobile"
                                    value="{{ old('mobile') }}" class="" name="mobile"
                                    oninput="nameinput('mobile')">
                                <label for="searchInputmobile">{{ __('about.form_mobile') }}</label>
                                <span class="clear-btn" id="clearBtn_mobile" onclick="clearInput('mobile')"
                                    @if (old('mobile')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('mobile')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 mt-4">
                            <div class="autocomplete @error('text') filled @enderror" id="autocompleteBoxtext">
                                <textarea name="message" id="searchInputtext" rows="3" oninput="nameinput('text')">{{ old('text') }}</textarea>
                                <label for="searchInputtext">{{ __('about.form_message') }}</label>
                                <span class="clear-btn" id="clearBtn_text" onclick="clearInput('text')"
                                    @if (old('text')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('text')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary px-4 mb-3">
                                {{ __('about.form_submit') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 p-0">
                    <div id="officeMap" class="rounded-start-4" style="z-index: 1;"></div>
                </div>
            </div>
            <!-- بخش کارت‌ها -->
            <div class="row mb-4 g-0">
                <div class="col-md-4 px-0">
                    <div class="ps-3">
                        <div class="contact-card h-100 d-flex flex-wrap align-content-between w-100">
                            <div class="card-box d-flex align-items-center justify-content-end rounded-4">
                                <div class="icon-box bg-white bg-opacity-25 border rounded-3 p-2">
                                    <i class="bi bi-share fs-4 text-secondary info-icons"></i>
                                </div>
                                <div class="text-end me-3 mt-2">
                                    <h6 class="fw-bold text-dark">{{ __('about.social_title') }}</h6>
                                    <p class="text-dark text-justify">{{ __('about.social_text') }}</p>
                                </div>
                            </div>
                            <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                                style="background-color: #F8F9FA;">
                                <a href="#" class="fw-bold text-decoration-none text-success">
                                    {{ __('about.social_action') }}
                                </a>
                                <div class="d-flex align-items-center justify-content-end me-2">
                                    <div class="text-dark" dir="ltr"><a
                                            href="https://www.instagram.com/termehsalari"
                                            class="text-reset">termehsalari</a></div>
                                    {{-- <i class="bi bi-send text-primary"></i> --}}
                                    <span class="border border-3 rounded-circle me-2"
                                        style="width: 30px;height:30px;background: linear-gradient(336deg,rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 50%, rgba(252, 176, 69, 1) 100%);">
                                        <i class="bi bi-instagram text-white"
                                            style="font-size: 16px;position: relative;left: 0;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 px-0">
                    <div class="px-3">
                        <div class="contact-card h-100 d-flex flex-wrap align-content-between w-100">
                            <div class="card-box d-flex align-items-center justify-content-end rounded-4">
                                <div class="icon-box bg-white bg-opacity-25 border rounded-3 p-2">
                                    <i class="bi bi-telephone fs-4 text-secondary info-icons"></i>
                                </div>
                                <div class="text-end me-3 mt-2">
                                    <h6 class="fw-bold text-dark">{{ __('about.phone_title') }}</h6>
                                    <p class="text-dark text-justify">{{ __('about.phone_text') }}</p>
                                </div>
                            </div>
                            <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                                style="background-color: #F8F9FA;">
                                <a href="#" class="fw-bold text-decoration-none text-success">
                                    {{ __('about.phone_action') }}
                                </a>
                                <div class="d-flex align-items-center justify-content-end me-2">
                                    <div class="text-dark" dir="ltr"><a href="tel:09134577500"
                                            class="text-reset">0913 457 7500</a></div>
                                    <span class="border border-3 rounded-circle me-2"
                                        style="width: 30px;height:30px;background: #4FBA6C;border-color: #4FBA6C !important;">
                                        <i class="bi bi-telephone text-white"
                                            style="font-size: 16px;position: relative;top: 2px;left: 0;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 px-0">
                    <div class="pe-3">
                        <div class="contact-card h-100 d-flex flex-wrap align-content-between w-100">
                            <div class="card-box d-flex align-items-center justify-content-end rounded-4">
                                <div class="icon-box bg-white bg-opacity-25 border rounded-3 p-2">
                                    <i class="bi bi-chat-dots fs-4 text-secondary info-icons"></i>
                                </div>
                                <div class="text-end me-3 mt-2">
                                    <h6 class="fw-bold text-dark">{{ __('about.messenger_title') }}</h6>
                                    <p class="text-dark text-justify">{{ __('about.messenger_text') }}</p>
                                </div>
                            </div>
                            <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                                style="background-color: #F8F9FA;">
                                <a href="#" class="fw-bold text-decoration-none text-success">
                                    {{ __('about.messenger_action') }}
                                </a>
                                <div class="d-flex align-items-center justify-content-end me-2">
                                    <div class="text-dark" dir="ltr"><a href="https://telegram.me/termeh_salari"
                                            class="text-reset">termeh_salari</a></div>
                                    {{-- <i class="bi bi-whatsapp fs-4 text-success me-2"></i> --}}
                                    <span class="border border-3 rounded-circle me-2"
                                        style="width: 30px;height:30px;background: #37ABE1;border-color: #37ABE1 !important;">
                                        <i class="bi bi-telegram text-white"
                                            style="font-size: 16px;position: relative;top: 2px;left: 0;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- contact end --}}
    </div>
@endsection
@section('script')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    @else
        <script src="{{ asset('shop/js/ltr/main-menu-full.js') }}"></script>
    @endif
    {{-- <script src="https://unpkg.com/leader-line@1.0.7/leader-line.min.js"></script> --}}
    <script src="https://lib.arvancloud.ir/leader-line/1.0.7/leader-line.min.js"></script>

    @php
        $mapped = $grouped->map(function ($items, $mapCode) {
            return [
                'province' => $items->first()->state->name,
                'offices' => $items
                    ->map(function ($agency) {
                        return [
                            'manager' => $agency->name_fa,
                            'address' => $agency->address_fa,
                            'phone' => $agency->phone,
                            'city' => $agency->city->name,
                        ];
                    })
                    ->values(),
            ];
        });
    @endphp

    <script>
        const branchesData = @json($mapped);
    </script>
    <script src="{{ asset('shop/js/about.js') }}"></script>


    <script>
        const videoBtn = document.getElementById("video-btn");
        const video = document.getElementById("fullscreen-video");
        video.addEventListener("play", () => {
            // alert('hiii')
            if (videoBtn) {
                videoBtn.classList.add("d-none");
                videoBtn.classList.remove("d-flex");
            }
        });

        video.addEventListener("pause", () => {
            // alert('hiii')
            if (videoBtn) {
                videoBtn.classList.remove("d-none");
                videoBtn.classList.add("d-flex");
            }
        });

        video.addEventListener("ended", () => {
            // alert('hiii')
            if (videoBtn) {
                videoBtn.classList.remove("d-none");
                videoBtn.classList.add("d-flex");
            }
        });
        // JavaScript
        const backToTopButton = document.getElementById("backToTop");

        // نمایش/مخفی کردن دکمه هنگام اسکرول
        if (backToTopButton) {
            window.addEventListener("scroll", function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add("show");
                } else {
                    backToTopButton.classList.remove("show");
                }
            });

            // عملکرد کلیک دکمه
            backToTopButton.addEventListener("click", function() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth",
                });
            });
        }
        new Splide('#branchs-slider', {
            type: 'loop',
            perPage: 3,
            gap: '1.2rem',
            arrows: true,
            pagination: false,
            drag: true,
            direction: 'rtl',
            autoplay: true,
            breakpoints: {
                768: {
                    perPage: 1,
                },
                480: {
                    perPage: 1,
                }
            }
        }).mount();

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
