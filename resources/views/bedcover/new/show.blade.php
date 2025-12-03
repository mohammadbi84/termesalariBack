@extends('shop.layouts.master')
@section('title', $title . ' طرح ' . $bedcover->color_design->design->title . ' رنگ ' .
    $bedcover->color_design->color->color)
@section('head')
    <link rel="stylesheet" href="{{ asset('shop/css/product.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
@endsection
@section('content')
    <main>
        <div class="container py-4 mb-5" style="padding: 0 2rem !important;margin-top:100px">
            <!-- Breadcrumb -->
            <div class="row rounded-4 shadow bg-white px-4 mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/store" class="text-decoration-none text-muted"><i
                                    class="fas fa-home"></i> خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bedcover.storeIndex') }}"
                                class="text-decoration-none text-muted">محصولات رومیزی</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $bedcover->category->title }} طرح {{ $bedcover->color_design->design->title }} رنگ
                            {{ $bedcover->color_design->color->color }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="row rounded-4 shadow bg-white p-4 mb-5">

                <!-- right Column - Product Info -->
                <div class="col order-lg-1 mb-5">
                    <h1 class="product-title">
                        {{ $bedcover->category->title }} طرح
                        {{ $bedcover->color_design->design->title }} رنگ
                        {{ $bedcover->color_design->color->color }}
                    </h1>

                    <div class="rating">
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-muted">(۴.۵ از ۵ - ۱۲ نظر)</span>
                    </div>

                    <ul class="product-specs ">
                        <li> کد محصول: {{ $bedcover->code }}</li>
                        <li> تعداد رنگ بافت ترمه: {{ $bedcover->color_design->design->countOfColor }} رنگ</li>
                        <li> مشتمل بر: {{ $bedcover->contains }}</li>
                    </ul>

                    <div class="price-section">
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
                        @if ($off > 0)
                            <span class="original-price">{{ number_format($prices->price) }} تومان</span>
                        @endif
                        <span class="discounted-price">{{ number_format($price) }} تومان</span>
                    </div>

                    <div class="stock-info">
                        <i class="fas fa-box-open ms-1"></i>
                        @if ($bedcover->quantity == 0)
                            <span class="text-bold"> اتمام موجودی در انبار </span>
                        @elseif($bedcover->quantity <= 5)
                            <span class="text-bold">کمتر از 5 عدد موجود می باشد .</span>
                        @elseif($bedcover->quantity > 5)
                            <span class="text-success text-bold"> موجود در انبار</span>
                        @endif
                    </div>

                    <div class="quantity-control">
                        <div class="d-flex border rounded-2 p-1">
                            <button class="quantity-btn minus-btn"><i class="fas fa-minus"></i></button>
                            <input type="text" class="quantity-input" value="1" readonly>
                            <button class="quantity-btn plus-btn"><i class="fas fa-plus"></i></button>
                        </div>
                        <button class="btn btn-primary">افزودن به سبد خرید</button>
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="d-block mb-1 compare-btn">
                            <i class="fa-solid fa-shuffle ms-1"></i>
                            برای مقایسه اضافه کنید
                        </a>
                        <a href="#" class="d-block wishlist-btn">
                            <i class="fas fa-heart ms-1"></i>
                            افزودن به علاقه‌مندی‌ها
                        </a>
                    </div>
                </div>

                <!-- Middle Column - Product Gallery -->
                <div class="col-lg-5 order-lg-2 mb-5" style="width:46% !important;">
                    <div class="product-gallery">
                        <!-- اسلایدر اصلی -->

                        <div class="swiper main-slider" id="mainSlider">
                            <div class="swiper-wrapper">
                                @foreach ($images as $key => $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/images/' . $image['name']) }}"
                                            alt="{{ $image['name'] }}" class="product-image-show"
                                            data-zoom-src="{{ asset('storage/images/' . $image['name']) }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                        <!-- لنز زوم -->
                        <div class="zoom-lens" id="zoomLens"></div>

                        <!-- دکمه مشاهده گالری -->
                        <div class="view-gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
                            <i class="fa-solid fa-expand" style="top: 0"></i>
                        </div>
                    </div>
                </div>

                <!-- left Column - Additional Info -->
                <div class="col order-lg-3 mb-5">
                    <div class="discount-alert">
                        <div class="d-flex align-items-center">
                            <div>
                                <strong>تخفیف ویژه!</strong>
                                <div class="countdown-timer timer-short justify-content-between gap-4" id="countdown-1"
                                    data-end-date="2025-12-30">
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
                        </div>
                    </div>

                    <div class="progress-container">
                        <div class="progress-label">
                            <div class="progress-text">
                                <span>سفارش داده شده: </span>
                                <strong>25</strong>
                            </div>
                            <div class="progress-text">
                                <span>باقی مانده: </span>
                                <strong>12</strong>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="categories-tags">
                        <h6 class="color-title">رنگ</h6>
                        <div class="mb-3">
                            <span class="tag">{{ $bedcover->color_design->color->color }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="color-title">دسته‌بندی :</h6>
                            <a href="{{ route('bedcover.storeIndex') }}"
                                class="tag">{{ $bedcover->category->title }}</a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="color-title">برچسب ها :</h6>
                            <span class="tag">{{ $bedcover->color_design->design->title }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <h6>اشتراک‌گذاری</h6>
                            <div class="share-buttons">
                                <a href="#" class="share-btn telegram"><i class="fab fa-telegram-plane"></i></a>
                                <a href="#" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
                                <a href="#" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="share-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row bg-white rounded-4 shadow mb-5">
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/24hours.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">پشتیبانی 24 ساعته</h5>
                            <span class="point-span">و هفت روز هفته</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/newest.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">به‌روز ترین محصولات</h5>
                            <span class="point-span">و بهترین کیفیت</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/offBadges.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">حراج های مختلف</h5>
                            <span class="point-span">تا 50 درصد تخفیف</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 text-center p-3">
                    <div class="d-flex justify-content-start align-items-center gap-3">
                        <img src="{{ asset('shop/assets/svgs/quality.svg') }}" alt="24 hours" width="50">
                        <div class="text-end">
                            <h5 class="m-0">تضمین بهترین قیمت</h5>
                            <span class="point-span">و بالاترین کیفیت</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gap-5">
                <div class="col p-0">
                    <div class="bg-white rounded-4 p-4 shadow mb-4">
                        <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                            <i class="fa-solid fa-info info-badge-icon"></i>
                            <h5 class="m-0">توضیحات</h5>
                        </div>
                        <p class="text-justify text-muted">
                            {{ $bedcover->description }}
                        </p>
                    </div>
                    <div class="bg-white rounded-4 p-4 shadow">
                        <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                            <i class="fa-regular fa-comments info-badge-icon"></i>
                            <h5 class="m-0">دیدگاه خود را بنویسید</h5>
                        </div>
                        <div class="">
                            <div class="mb-4">
                                <div class="autocomplete @error('text') filled @enderror" id="autocompleteBoxlogin">
                                    <input type="text" id="searchInputlogin" value="{{ old('text') }}"
                                        class="" name="text" oninput="nameinput('text')">
                                    <label for="searchInputlogin">نظر خود را بنویسید</label>
                                    <span class="clear-btn" id="clearBtn_login" onclick="clearInput('text')"
                                        @if (old('text')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('text')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-25 mb-3">ارسال دیدگاه</button>
                        </div>
                    </div>
                </div>
                <div class="col bg-white rounded-4 p-4 shadow">
                    <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                        <i class="fa-solid fa-info info-badge-icon"></i>
                        <h5 class="m-0">جزئیات محصول</h5>
                    </div>
                    <ul class="list-group list-group-flush p-0">
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>ابعاد محصول</span>
                                <span class="point-span">{{ $bedcover->dimensions }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>وزن تقریبی</span>
                                <span class="point-span">{{ $bedcover->weight }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>جنس محصول</span>
                                <span class="point-span">{{ $bedcover->kind }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>نوع دوخت</span>
                                <span class="point-span">{{ $bedcover->sewingType }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>آستر</span>
                                <span class="point-span">{{ $bedcover->haveEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>جنس آستر</span>
                                <span class="point-span">{{ $bedcover->kindOfEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>قابلیت شستشو</span>
                                <span class="point-span">{{ $bedcover->washable }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>موارد استفاده</span>
                                <span class="point-span">{{ $bedcover->uses }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Gallery Modal -->
        <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="galleryModalLabel">گالری تصاویر محصول</h5>
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
    <script>
        const menu = $(".main-menu");
        menu.addClass('small');
        const bookmarkFirst = $("#bookmark");
        bookmarkFirst.removeClass('expanded');
        bookmarkFirst.addClass('collapsed');
    </script>
    <script>
        $(document).ready(function() {
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
                var currentVal = parseInt($('.quantity-input').val());
                $('.quantity-input').val(currentVal + 1);
            });

            $('.minus-btn').click(function() {
                var currentVal = parseInt($('.quantity-input').val());
                if (currentVal > 1) {
                    $('.quantity-input').val(currentVal - 1);
                }
            });

            // Add to Cart
            $('.add-to-cart-show').click(function() {
                var quantity = $('.quantity-input').val();
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

            // Wishlist and Compare buttons
            $('.wishlist-btn').click(function() {
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).html('<i class="fas fa-heart text-danger"></i> حذف از علاقه‌مندی');
                } else {
                    $(this).html('<i class="fas fa-heart"></i> علاقه‌مندی');
                }
            });

            $('.compare-btn').click(function() {
                alert('این محصول به لیست مقایسه اضافه شد');
            });

            // مقدار زوم را اینجا تنظیم کن (1 = بدون زوم, 1.5 = یک ونیم برابر, 2 = دو برابر)
            let zoomLevel = 1.3;

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
@endsection
