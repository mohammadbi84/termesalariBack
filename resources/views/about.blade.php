@extends('shop.layouts.master')
@section('title', 'درباره ما')
@section('head')
    <link rel="stylesheet" href="{{ asset('shop/css/leaflet.css') }}" />
    <script src="{{ asset('shop/js/leaflet.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('shop/css/footerNew.css') }}">
    <link rel="stylesheet" href="{{ asset('shop/css/about.css') }}">
    <script src="{{ asset('shop/js/map/mapdata.js') }}"></script>
    <script src="{{ asset('shop/js/map/countrymap.js') }}"></script>
    <link href="https://v1.fontapi.ir/css/VazirFD" rel="stylesheet">
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
            height: 420px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
        }
    </style>
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
@endsection
@section('content')
    <div class="container py-4" style="margin-top: 100px">
        {{-- family start --}}
        <div class="row p-3 mb-4">
            <div class="col-md-4 ">
                <div class=" d-flex justify-content-between align-items-end">
                    <img src="{{ asset('/hometemplate/img/about-mission.jpg') }}" alt="test" class="builder-image">
                    <div class="flex-grow-1 d-flex justify-content-between align-items-center mb-2 px-3 ps-4">
                        <span class="builder-title">آسید علی سالاری</span>
                        <img src="{{ asset('hometemplate/img/logo.png') }}" alt="logo" width="40">
                    </div>
                </div>
                <div class="pb-4 px-4 pt-5 builder-text">
                    ترمه بافی در خاندان سالاری حدود 90 سال پیش بدست مرحوم آسیدعلی سالاری ملقب به آسیدعلی سید حیدر آغاز شد.
                    ترمه ای که در آن زمان بافته می شد نوعی بقچه و سوزنی حاشیه دار بود که نام خود بافنده در آن بافت شده است
                </div>
            </div>
            <div class="col-md-4 ">
                <div class=" d-flex justify-content-between align-items-end">
                    <img src="{{ asset('/hometemplate/img/about-plan.jpg') }}" alt="test" class="builder-image">
                    <div class="flex-grow-1 d-flex justify-content-between align-items-center mb-2 px-3 ps-4">
                        <span class="builder-title">آسید علی اکبر سالاری</span>
                        <img src="{{ asset('hometemplate/img/logo.png') }}" alt="logo" width="40">
                    </div>
                </div>
                <div class="pb-4 px-4 pt-5 builder-text">
                    نسل دومی این خاندان آسیدعلی اکبر بود که در محله چهارمنار مشغول بکار شد و سپس تولید خود را با افزودن
                    دستگاهها تا 6 دستگاه دستباف و با 12 کارگر زن در محله سجادیه ادامه داد. این روند تا سال 1348 بصورت ترمه
                    دستی باروش بافت سنتی ادامه داشت و پس از آن با زحمات بسیار زیاد بافت ترمه به صورت ماشینی درآمد ولی با
                    همان کیفیت ترمه دستی تولید و بافت انجام می گرفت.
                </div>
            </div>
            <div class="col-md-4 ">
                <div class=" d-flex justify-content-between align-items-end">
                    <img src="{{ asset('/hometemplate/img/about-vision.jpg') }}" alt="test" class="builder-image">
                    <div class="flex-grow-1 d-flex justify-content-between align-items-center mb-2 px-3 ps-4">
                        <span class="builder-title">آسید حیدر سالاری</span>
                        <img src="{{ asset('hometemplate/img/logo.png') }}" alt="logo" width="40">
                    </div>
                </div>
                <div class="pb-4 px-4 pt-5 builder-text">
                    نسل سوم از سال 1361 فعالیت گذشتگان را ادامه داد ولی با این تفاوت که روز به روز تولیداتی با طرحها و رنگ
                    های متنوع و جدید به بازار عرضه نمود و با بهره گیری از تکنولوژی جدید و دستگا های مدرن روز پیوسته به تعداد
                    طرحها رنگها و جذابیت ترمه های تولیدی خود افزوده است آنچنان که توانسته است علاوه بر مشتریان داخلی نظر
                    گردشگران دیگر کشورها را نیز به خود جلب و آنان را در زمره خریداران خود قرار دهد
                </div>
            </div>
        </div>
        {{-- family end --}}
        {{-- mission start --}}
        <div class="row p-3 mb-4 bg-white rounded-3 g-0 gap-4">
            <div class="col-md-3">
                <div class="reels-container">
                    <video id="my-video" class="video-js vjs-fill" controls preload="auto"
                        poster="{{ asset('shop/assets/cover.png') }}" data-setup='{}'>
                        <source src="{{ asset('shop/assets/termesalari.mp4') }}" type="video/mp4" />
                    </video>
                </div>
            </div>
            <div class="col">
                <div class="d-flex justify-content-start align-items-center mb-4">
                    <h5 class="mission-title m-0">رسالت ترمه سالاری</h5>
                </div>
                <p class="mission-text mb-4">
                    ترمه نوعی از منسوجات سنتی ایران است که از گذشته های بسیار دور در ایران تولید می شده است. ترمه همانند
                    فرش دست بافت دارای تار و پود است که پود در پشت پارچه ترمه به صورت آزاد قرار می گیرد. ترمه اصیل ایران
                    لاکی یا عنابی رنگ است و طرح بته جقه یا سرو خمیده جزء لاینفک آن است. امروزه پارچه ترمه در طرح ها و
                    رنگ های متنوع بافته می شود. رومیزی ترمه (مربع، رانر و سری رانر)، کوسن، سجاده و جانماز ترمه، تابلو
                    ترمه، روتختی ترمه، پشتی ترمه، لحاف ترمه، پرده ترمه، رومبلی ترمه، کتاب های نفیس ترمه، صندوقچه ترمه،
                    جعبه جواهرات ترمه، کیسه شاباش ترمه، لباس، کیف و کفش ترمه، کراوات ترمه و رومیزی های ترمه سرمه دوزی
                    شده از جمله مهم ترین محصولات تولید شده با پارچه ترمه می باشند. در سال های اخیر با توجه به ظرافت بافت
                    ترمه، پارچه ترمه و رومیزی های ترمه تنها در استان یزد بافته و تولید می شوند. ترمه سالاری یزد با بیش
                    از یک قرن تجربه و سیصد طرح متنوع، ارائه دهنده ی معروف ترین و مرغوب ترین ترمه ها در ایران می باشد.
                    رسالت اصلی ترمه سالاری پاسداری از میراث نسل های گذشته خویش و ادامه راه ایشان جهت تکمیل و هر چه بهتر
                    شدن کیفیت این پارچه سنتی بوده تا بتواند افتخاری برای آیندگان خود باشد. شعار ما "ترمه سالاری برای هر
                    ایرانی با کیفیتی عالی و قیمتی مناسب" می باشد تا همه اقشار ملت بتوانند از آن بهره مند شوند. طرح های
                    بی نظیر و رنگ آمیزی خاص ترمه های تولیدی ما تنها با مقایسه و لمس دیگر ترمه ها مشهود خواهد شد که به
                    کیفیت و لطافت و رنگ آمیزی کم نظیر می باشد.
                </p>
                <div class="row mission-row p-0 bg-white rounded-4 shadow mx-3">
                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number">+250</span>
                            <span>ماه سابقه</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number">+600</span>
                            <span>محصول</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number">+450</span>
                            <span>عضو فعال</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number">+10</span>
                            <span>نمایندگی</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number">+100</span>
                            <span>پروژه</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- mission end --}}
        {{-- about us start --}}
        <section id="about" class="mb-5"
            style="background: url({{ asset('shop/assets/products/product2.webp') }}) center top no-repeat fixed;">
            <div class="container">
                <header class="section-header">
                    <h3>نشان اصالت محصول</h3>
                    <p>جهت اطمینان از اصل بودن کالای خریداری شده و اصالت ترمه و ضمانت محصولات ضمن خرید از فروشگاه های
                        معتبر به نشان ترمه سالاری بر روی محصولات توجه فرمایید.</p>
                    <img src="{{ asset('/hometemplate/img/original.png') }}" alt="">
                </header>
            </div>
        </section>
        {{-- about us end --}}
        {{-- comments start --}}
        <section class="mb-5">
            <div class="row">
                <div class="col-md-6 px-4">
                    <h1 class="comment-title">
                        اعتبـــــــــــاری کـــــه داریـــــــم از
                        <span class="etemad">اعتـمـــــــاد</span>
                        شماســــــــت...
                    </h1>
                    <p class="commetn-text">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز
                        و
                        کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
                    </p>
                    <div class="row mission-row p-0 g-0 bg-white rounded-4 shadow">
                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number">+250</span>
                                <span>ماه سابقه</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number">+600</span>
                                <span>محصول</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number">+450</span>
                                <span>عضو فعال</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="testimonial-slider">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="user">
                                                <img src="https://i.pravatar.cc/80?img=12" alt="">
                                                <div>
                                                    <h4>علی رسولی</h4>
                                                    <span>مدیر مارکتینگ</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                            طراحان گرافیک است.
                                            چاپگرها
                                            و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                                            تکنولوژی مورد نیاز
                                            و
                                            کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
                                        </p>

                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="user">
                                                <img src="https://i.pravatar.cc/80?img=12" alt="">
                                                <div>
                                                    <h4>علی رسولی</h4>
                                                    <span>مدیر مارکتینگ</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                            طراحان گرافیک است.
                                            چاپگرها
                                            و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                                            تکنولوژی مورد نیاز
                                            و
                                            کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
                                        </p>

                                    </div>
                                </div>
                            </div>

                            <!-- دکمه‌ها -->
                            <!-- <div class="swiper-button-next"></div>
                                                                        <div class="swiper-button-prev"></div> -->

                            <!-- دات‌های زیر -->
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
                    <div class=" d-flex align-items-center justify-content-between w-100  p-2">
                        <div class="">
                            {{-- <h2 class="title m-0">حقوق مالکیت معنوی</h2> --}}
                            <header class="section-header text-end d-flex">
                                <h3 class="text-end">حقوق مالکیت معنوی</h3>
                            </header>
                            <span>
                                تمام طرح های تولیدی ترمه سالاری دارای گواهی نامه ثبت مالکیت معنوی بوده و هرگونه کپی
                                برداری از آن
                                پیگرد قانونی دارد
                            </span>
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
        </section>
        {{-- lisence end --}}
        {{-- partners start --}}
        <div class="elementor-element elementor-element-4f43ad3 e-flex e-con-boxed e-con e-parent mb-5" data-id="4f43ad3"
            data-element_type="container">
            <div class="e-con-inner">
                <div class="elementor-element elementor-element-d65e440 elementor-widget elementor-widget-luxina_customers"
                    data-id="d65e440" data-element_type="widget" data-widget_type="luxina_customers.default">
                    <div class="elementor-widget-container">
                        <div class="luxina_customers_container">
                            <div class="luxina_customers_title-wrap title-in-items">
                                <span class="luxina_customers_title-bg" aria-hidden="true"></span>
                                <i class="luxina-icon-user-star-fill luxina_customers_title-icon" aria-hidden="true"></i>
                                <span class="luxina_customers_title-text">افتخارات
                                    همکاری</span>
                                <span class="luxina_customers_title-subtitle">Partnership
                                    honors</span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- partners end --}}
        {{-- branch map start --}}
        <section class="branch-map mb-5">
            <div class="row">
                <header class="section-header">
                    <h3>نمایندگی های ما</h3>
                </header>
                <div class="col-md-3 col-3 d-flex flex-column justify-content-around align-items-center gap-3 labels-col"
                    id="branch-labels-left">
                    <!-- لیبل‌ها -->
                    {{-- <div id="label-mashhad" class="map-label label-mashhad">
                        نمایندگی مشهد
                    </div>
                    <div id="label-tehran" class="map-label label-tehran">
                        نمایندگی تهران
                    </div>
                    <div id="label-isfahan" class="map-label label-isfahan">
                        نمایندگی اصفهان
                    </div>
                    <div id="label-kerman" class="map-label label-kerman">
                        نمایندگی کرمان
                    </div> --}}
                </div>
                <div class="col-md-6 col-6">
                    <div class="map-wrapper">
                        <!-- نقشه -->
                        <div id="map"></div>
                    </div>
                </div>
                <div class="col-md-3 col-3 d-flex flex-column justify-content-around align-items-center gap-3 labels-col"
                    id="branch-labels-right">
                    {{-- <div id="label-ghazvin" class="map-label label-ghazvin">
                        نمایندگی قزوین
                    </div>
                    <div id="label-yasoj" class="map-label label-yasoj">
                        نمایندگی یاسوج
                    </div> --}}
                </div>
            </div>
        </section>
        {{-- branch map end --}}
        {{-- contact start --}}
        <section>
            <div class="row bg-white rounded-4 shadow">
                <div class="col-md-5 p-4">
                    <h5 class="border-end border-4 border-success pe-2">با ما در ارتباط باشید</h5>
                    <form action="{{ route('message.store') }}" method="post">
                        @csrf
                        <div class="mb-3 mt-4">
                            <div class="autocomplete @error('name') filled @enderror" id="autocompleteBoxname">
                                <input type="text" id="searchInputname" value="{{ old('name') }}" class=""
                                    name="name" oninput="nameinput('name')">
                                <label for="searchInputname">نام و نام خانوادگی</label>
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
                                <label for="searchInputmobile">شماره موبایل</label>
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
                                <label for="searchInputtext">نظرات، پیشنهادات و انتقادات خود را با ما در میان
                                    بگذارید</label>
                                <span class="clear-btn" id="clearBtn_text" onclick="clearInput('text')"
                                    @if (old('text')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('text')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary px-4 mb-3">ثبت درخواست</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 p-0">
                    <div id="officeMap" class="rounded-start-4"></div>
                </div>
            </div>
        </section>
        {{-- contact end --}}
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    <script src="https://unpkg.com/leader-line@1.0.7/leader-line.min.js"></script>
    <script src="{{ asset('shop/js/about.js') }}"></script>

    <script>
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
