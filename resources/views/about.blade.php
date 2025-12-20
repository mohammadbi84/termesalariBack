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
            height: 100%;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
        }
    </style>
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />

@endsection
@section('content')
    <div class="container py-4" style="margin-top: 70px">
        {{-- family start --}}
        <div class="row p-3 mb-4">
            <div class="col-md-4 px-0 builder-col">
                <div class="ps-3 h-100">
                    <div class=" d-flex justify-content-between align-items-end">
                        <img src="{{ asset('shop/assets/1.jpeg') }}" alt="test" class="builder-image">
                        <div class="flex-grow-1 d-flex justify-content-between align-items-center mb-2 px-3 ps-4">
                            <span class="builder-title">آسید علی سالاری <br>
                                <small>بنیان گذار</small>
                            </span>
                            <img src="{{ asset('hometemplate/img/logo.png') }}" alt="logo" width="40">
                        </div>
                    </div>
                    <div class="pb-4 px-4 pt-5 builder-text">
                        ترمه‌بافی در خاندان سالاری حدود یک قرن پیش به دست مرحوم آ سیدعلی سالاری، ملقب به آ سیدعلی سید حیدر،
                        آغاز شد. ترمه‌ای که در آن زمان بافته می‌شد نوعی بقچه و سوزنی حاشیه‌دار بود که نام خود بافنده در آن
                        بافت شده است. این هنر با گذشت زمان میان نسل‌های بعدی خانواده نیز ادامه پیدا کرد و به‌تدریج طرح‌ها و
                        نقش‌های متنوع‌تری به آن افزوده شد.
                    </div>
                </div>
            </div>
            <div class="col-md-4 px-0 builder-col">
                <div class="px-3 h-100">
                    <div class=" d-flex justify-content-between align-items-end">
                        <img src="{{ asset('shop/assets/2.jpeg') }}" alt="test" class="builder-image">
                        <div class="flex-grow-1 d-flex justify-content-between align-items-center mb-2 px-3 ps-4">
                            <span class="builder-title">آسید علی اکبر سالاری <br>
                                <small>رهرو</small>
                            </span>
                            <img src="{{ asset('hometemplate/img/logo.png') }}" alt="logo" width="40">
                        </div>
                    </div>
                    <div class="pb-4 px-4 pt-5 builder-text">
                        نسل دومی این خاندان آسیدعلی اکبر بود که در محله چهارمنار مشغول بکار شد و سپس تولید خود را با افزودن
                        دستگاهها تا 6 دستگاه دستباف و با 12 کارگر زن در محله سجادیه ادامه داد. این روند تا سال 1348 بصورت
                        ترمه
                        دستی باروش بافت سنتی ادامه داشت و پس از آن با زحمات بسیار زیاد بافت ترمه به صورت ماشینی درآمد ولی با
                        همان کیفیت ترمه دستی تولید و بافت انجام می گرفت.
                    </div>
                </div>
            </div>
            <div class="col-md-4 px-0 builder-col">
                <div class="pe-3 h-100">
                    <div class=" d-flex justify-content-between align-items-end">
                        <img src="{{ asset('shop/assets/3.jpeg') }}" alt="test" class="builder-image">
                        <div class="flex-grow-1 d-flex justify-content-between align-items-center mb-2 px-3 ps-4">
                            <span class="builder-title">آسید حیدر سالاری <br>
                                <small>رهرو</small>
                            </span>
                            <img src="{{ asset('hometemplate/img/logo.png') }}" alt="logo" width="40">
                        </div>
                    </div>
                    <div class="pb-4 px-4 pt-5 builder-text">
                        نسل سوم از سال 1361 فعالیت گذشتگان را ادامه داد با این تفاوت که روز به روز تولیداتی با طرحها و
                        رنگ
                        های متنوع و جدید به بازار عرضه نمود و با بهره گیری از تکنولوژی جدید و دستگاه های مدرن روز پیوسته به
                        تعداد
                        طرحها رنگها و جذابیت ترمه های تولیدی خود افزوده است، آنچنان که توانسته است علاوه بر مشتریان داخلی
                        نظر
                        گردشگران دیگر کشورها را به خود جلب و آنان را در زمره خریداران خود قرار دهد.
                    </div>
                </div>
            </div>
        </div>
        {{-- family end --}}
        {{-- mission start --}}
        <div class="row p-3 py-5 mb-4 bg-white rounded-3 g-0 mx-1 gap-4">
            <div class="col-md-3">
                {{-- <div class="reels-container">
                    <video id="my-video" class="video-js vjs-fill" controls preload="auto"
                        poster="{{ asset('shop/assets/cover2.png') }}" data-setup='{}'>
                        <source src="{{ asset('shop/assets/yalda.mp4') }}" type="video/mp4" />
                    </video>
                </div> --}}
                <div class="video-full-container mb-5 px-0 shadow">
                    <video id="fullscreen-video" class="w-100 h-100" poster="{{ asset('shop/assets/cover2.png') }}">
                        <!-- منبع ویدیو - میتوانید آدرس ویدیوی خود را جایگزین کنید -->
                        <source src="{{ asset('shop/assets/yalda.mp4') }}" type="video/mp4">
                        مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
                    </video>

                    <div class="video-overlay"></div>

                    <div class="play-pause-btn" id="video-btn">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                {{-- <div class="d-flex justify-content-start align-items-center mb-4">
                    <h5 class="mission-title m-0">رسالت ترمه سالاری</h5>
                </div> --}}
                <header class="section-header">
                    <h3>رسالت ترمه سالاری</h3>
                </header>
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
                <div class="row mission-row p-0 bg-white rounded-4 shadow-sm mx-3">
                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="220">0</span>
                            <span>محصول</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="160">0</span>
                            <span>طرح و نقش</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="186">0</span>
                            <span>مشتری</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="10">0</span>
                            <span>نمایندگی</span>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                            <span class="mission-number" data-target="100">0</span>
                            <span>پروژه</span>
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
                        آنچه کسب کرده‌ایم تنها یک نام نیست؛ اعتباری‌ست که از اعتماد شما ساخته شده است.
                    </p>
                    <div class="row mission-row p-0 g-0 bg-white rounded-4 shadow-sm" style="margin-top: 28px;">
                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number" data-target="100">0</span>
                                <span>سال سابقه</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number" data-target="186">0</span>
                                <span>کاربر فعال</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column justify-content-center align-items-center p-1 py-2">
                                <span class="mission-number" data-target="13">0</span>
                                <span>نمایندگی</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ps-0">
                    <div class="testimonial-slider">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="user">
                                                <img src="{{ asset('storetemplate/dist/img/user.png') }}" alt="">
                                                <div>
                                                    <h4>علی رسولی</h4>
                                                    <span>کاربر</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>
                                            رنگ‌های ترمه خیلی جذاب و ثابت هستن و بعد از استفاده و نگهداری هم تغییر نمی‌کنن.
                                            جنس پارچه لطیفه و دوخت‌ها محکم و تمیز انجام شده. نسبت به قیمتش ارزش خرید بالایی
                                            داره..
                                        </p>

                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="user">
                                                <img src="{{ asset('storetemplate/dist/img/user.png') }}" alt="">
                                                <div>
                                                    <h4>محمد بابایی</h4>
                                                    <span>کاربر</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>
                                            کیفیت بافت ترمه عالیه و کاملاً مشخصه که با دقت و مهارت بالا تولید شده. طرح‌ها
                                            اصیل و چشم‌نواز هستن و برای دکور یا هدیه انتخاب خیلی خوبیه. بسته‌بندی هم مرتب و
                                            شکیل بود..
                                        </p>

                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="user">
                                                <img src="{{ asset('storetemplate/dist/img/user.png') }}" alt="">
                                                <div>
                                                    <h4>علی رضایی</h4>
                                                    <span>کاربر</span>
                                                </div>
                                            </div>
                                            <div class="stars">★★★★★</div>
                                        </div>
                                        <p>
                                            این ترمه واقعاً محصولی سنتی و با اصالته و برای استفاده در مهمونی‌ها یا روی میز
                                            جلوه خاصی می‌ده. ظرافت نقش‌ها نشون‌دهنده هنر دست بافنده است. تحویل هم سریع و
                                            بدون مشکل انجام شد.
                                        </p>

                                    </div>
                                </div>
                            </div>

                            <!-- دکمه‌ها -->

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
                    <header class="section-header">
                        <h3 class="">حقوق مالکیت معنوی</h3>
                    </header>
                    <div class=" d-flex align-items-center justify-content-between w-100  p-2">
                        <div class="">
                            <span>
                                تمام طرح های تولیدی ترمه سالاری دارای گواهی نامه ثبت مالکیت معنوی بوده و هرگونه کپی
                                برداری از آن
                                پیگرد قانونی دارد
                            </span>
                        </div>
                        <div class="">
                            <!-- دکمه‌های کنترل جداگانه -->
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
                                <span class="luxina_customers_title-text">مشتریان ما</span>
                                <span class="luxina_customers_title-subtitle">Our customers</span>
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
                    <h3>نمایندگی های ما</h3>
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
                            <li class="splide__slide">
                                <div class="horizontal-card">
                                    <div class="card-image">
                                        <img src="{{ asset('shop/assets/products/product2.webp') }}" alt="نمایندگی">
                                    </div>
                                    <div class="card-info">
                                        <h3 class="card-title">نمایندگی ترمه ابریشم</h3>
                                        <div class="card-detail">
                                            <i class="fa fa-map-marker"></i>
                                            خیابان مثال، کوچه نمونه
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-phone"></i>
                                            021-12345678
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-envelope"></i>
                                            example@gmail.com
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="horizontal-card">
                                    <div class="card-image">
                                        <img src="{{ asset('shop/assets/products/product2.webp') }}" alt="نمایندگی">
                                    </div>
                                    <div class="card-info">
                                        <h3 class="card-title">نمایندگی ترمه ابریشم</h3>
                                        <div class="card-detail">
                                            <i class="fa fa-map-marker"></i>
                                            خیابان مثال، کوچه نمونه
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-phone"></i>
                                            021-12345678
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-envelope"></i>
                                            example@gmail.com
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="horizontal-card">
                                    <div class="card-image">
                                        <img src="{{ asset('shop/assets/products/product2.webp') }}" alt="نمایندگی">
                                    </div>
                                    <div class="card-info">
                                        <h3 class="card-title">نمایندگی ترمه ابریشم</h3>
                                        <div class="card-detail">
                                            <i class="fa fa-map-marker"></i>
                                            خیابان مثال، کوچه نمونه
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-phone"></i>
                                            021-12345678
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-envelope"></i>
                                            example@gmail.com
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="horizontal-card">
                                    <div class="card-image">
                                        <img src="{{ asset('shop/assets/products/product2.webp') }}" alt="نمایندگی">
                                    </div>
                                    <div class="card-info">
                                        <h3 class="card-title">نمایندگی ترمه ابریشم</h3>
                                        <div class="card-detail">
                                            <i class="fa fa-map-marker"></i>
                                            خیابان مثال، کوچه نمونه
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-phone"></i>
                                            021-12345678
                                        </div>
                                        <div class="card-detail">
                                            <i class="fa fa-envelope"></i>
                                            example@gmail.com
                                        </div>
                                    </div>
                                </div>
                            </li>
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
                        <h3 class="">ارتباط با ما</h3>
                    </header>
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
                                <label for="searchInputtext">متن پیام</label>
                                <span class="clear-btn" id="clearBtn_text" onclick="clearInput('text')"
                                    @if (old('text')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('text')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-primary px-4 mb-3">ارسال پیام</button>
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
                                    <h6 class="fw-bold text-dark">شبکه های اجتماعی</h6>
                                    <p class="text-dark text-justify">از آخرین اخبار و کمپین‌ها از طریق شبکه های اجتماعی
                                        مطلع شوید.</p>
                                </div>
                            </div>
                            <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                                style="background-color: #F8F9FA;">
                                <a href="#" class="fw-bold text-decoration-none text-success">اینستاگرام</a>
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
                                    <h6 class="fw-bold text-dark">تلفن تماس</h6>
                                    <p class="text-dark text-justify">همه‌روزه از ساعت 9:00 الی 17:00 پاسخگوی تماس شما
                                        هستیم.</p>
                                </div>
                            </div>
                            <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                                style="background-color: #F8F9FA;">
                                <a href="#" class="fw-bold text-decoration-none text-success">تماس</a>
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
                                    <h6 class="fw-bold text-dark">پیام رسان ها</h6>
                                    <p class="text-dark text-justify">در پیام رسان‌های زیر پاسخگوی سوالات شما هستیم.</p>
                                </div>
                            </div>
                            <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                                style="background-color: #F8F9FA;">
                                <a href="#" class="fw-bold text-decoration-none text-success">ارسال پیام</a>
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
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
    <script src="https://unpkg.com/leader-line@1.0.7/leader-line.min.js"></script>
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
