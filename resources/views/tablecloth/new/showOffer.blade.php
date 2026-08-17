@extends('shop.layouts.master')
@section('title', $title . ' طرح ' . $tablecloth->color_design->design->title . ' رنگ ' .
    $tablecloth->color_design->color->color)
@section('head')
    <link rel="stylesheet" href="{{ asset('shop/css/product.css') }}">
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
                                    class="fas fa-home"></i> خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tablecloth.storeIndex') }}"
                                class="text-decoration-none text-muted">محصولات رومیزی</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $tablecloth->category->title }} طرح {{ $tablecloth->color_design->design->title }} رنگ
                            {{ $tablecloth->color_design->color->color }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="row rounded-4 shadow-sm bg-white p-4 mb-5">
                @php
                    $images = $tablecloth->images()->get()->sortby('ordering');
                    $prices = $tablecloth->prices->where('local', 'تومان')->first();
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

                <!-- right Column - Product Info -->
                <div class="col order-lg-1 mb-2">
                    <h1 class="product-title">
                        {{ $tablecloth->category->title }} طرح
                        {{ $tablecloth->color_design->design->title }} رنگ
                        {{ $tablecloth->color_design->color->color }}
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
                        <li> کد محصول: {{ $tablecloth->code }}</li>
                        <li> تعداد رنگ بافت ترمه: {{ $tablecloth->color_design->design->countOfColor }} رنگ</li>
                        <li> مشتمل بر: {{ $tablecloth->contains }}</li>
                        <li> رنگ: {{ $tablecloth->color_design->color->color }}</li>
                    </ul>

                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="color-title">دسته‌بندی :</h6>
                        <a href="{{ route('tablecloth.storeIndex') }}"
                            class="tag">{{ $tablecloth->category->title }}</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="color-title">برچسب ها :</h6>
                        <span class="tag">{{ $tablecloth->color_design->design->title }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <h6>اشتراک‌گذاری</h6>
                        <div class="share-buttons">
                            <a href="#" id="share-btn" class="share-btn telegram">
                                <i class="fa-solid fa-share-nodes"></i>
                            </a>
                            {{-- <a href="#" class="share-btn telegram"><i class="fa-solid fa-share-nodes"></i></a>
                                <a href="#" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
                                <a href="#" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="share-btn linkedin"><i class="fab fa-linkedin-in"></i></a> --}}
                        </div>

                    </div>
                </div>

                <!-- Middle Column - Product Gallery -->
                <div class="col-lg-5 order-lg-2 mb-2 rounded-3 shadow-sm p-2">
                    <div class="product-gallery">
                        <!-- اسلایدر اصلی -->

                        <div class="swiper main-slider" id="mainSlider">
                            <div class="swiper-wrapper">
                                @foreach ($images as $key => $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $image['name']) }}"
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
                        <!-- دکمه مشاهده گالری -->
                        <div class="view-gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
                            <i class="fa-solid fa-expand" style="top: 0"></i>
                        </div>
                        <div class="w-100 d-flex justify-content-end align-items-center"
                            style="margin-top: 10px;position: relative;gap: 13px;">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>

                <!-- left Column - Additional Info -->
                <div class="col order-lg-3 mb-2">
                    <div class="discount-alert">
                        <div class="d-flex align-items-center">
                            <div class="w-100 d-flex justify-content-between align-items-center">
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
                        <div class="action-buttons">
                            <a href="#" id="compare" class="d-block mb-1 compare-btn"
                                data-image="{{ asset('/storage/' . $tablecloth->images->first()->name) }}"
                                data-moddel="{{ substr($tablecloth->category->model, 4) }}"
                                data-design="{{ $tablecloth->color_design->design->title ?? '' }}"
                                data-color="{{ $tablecloth->color_design->color->color ?? '' }}"
                                data-title="{{ $tablecloth->title }}" data-price="{{ $prices->price }}"
                                data-pay="{{ $price }}" data-off="{{ $off }}"
                                data-offType="{{ $prices->offType }}" data-local="{{ $prices->local }}"
                                data-id="{{ $tablecloth->id }}"
                                data-model="{{ substr($tablecloth->category->model, 4) }}">
                                <i class="fa-solid fa-shuffle ms-1"></i>
                                برای مقایسه اضافه کنید
                            </a>
                            <a href="#"
                                class="d-block wishlist-btn favorites-btn @if ($tablecloth->favorites->where('user_id', Auth::id())->count() > 0) active @endif"
                                data-image="{{ asset('/storage/' . $tablecloth->images->first()->name) }}"
                                data-moddel="{{ substr($tablecloth->category->model, 4) }}"
                                data-design="{{ $tablecloth->color_design->design->title ?? '' }}"
                                data-color="{{ $tablecloth->color_design->color->color ?? '' }}"
                                data-title="{{ $tablecloth->title }}" data-price="{{ $prices->price }}"
                                data-pay="{{ $price }}" data-off="{{ $off }}"
                                data-offType="{{ $prices->offType }}" data-local="{{ $prices->local }}"
                                data-id="{{ $tablecloth->id }}"
                                data-model="{{ substr($tablecloth->category->model, 4) }}">
                                <i class="fas fa-heart ms-1"></i>
                                افزودن به علاقه‌مندی‌ها
                            </a>
                        </div>

                        <hr>
                        <div class="price-section text-start">
                            @if ($off > 0)
                                <span class="original-price">{{ number_format($prices->price) }} تومان</span>
                            @endif
                            <span class="discounted-price">{{ number_format($price) }} تومان</span>
                        </div>

                        <div class="stock-info">
                            <i class="fas fa-box-open ms-1"></i>
                            {{-- @if ($tablecloth->quantity == 0)
                                <span class="text-bold"> اتمام موجودی در انبار </span>
                            @elseif($tablecloth->quantity <= 5)
                            @elseif($tablecloth->quantity > 5)
                            <span class="text-success text-bold"> موجود در انبار</span>
                            @endif --}}
                            <span class="text-bold">{{ $tablecloth->quantity }} عدد موجود می باشد .</span>
                        </div>

                        <div class="quantity-control">
                            {{-- <div class="d-flex border rounded-2 p-1">
                            <button class="quantity-btn minus-btn"><i class="fas fa-minus"></i></button>
                            <input type="text" class="quantity-input" id="quantity-input" value="1" readonly>
                            <button class="quantity-btn plus-btn"><i class="fas fa-plus"></i></button>
                            </div> --}}
                            <div class="quantity-controls gap-2">
                                <button class="minus-btn" data-model="{{ substr($tablecloth->category->model, 4) }}"
                                    data-id="{{ $tablecloth->id }}">-</button>
                                <span class="count item-quantity-product" id="item-quantity-product">1</span>
                                <button class="plus-btn" data-model="{{ substr($tablecloth->category->model, 4) }}"
                                    data-id="{{ $tablecloth->id }}">+</button>
                            </div>
                            <button class="btn btn-primary @if ($tablecloth->quantity != 0) addToCart @endif"
                                data-image="{{ asset('/storage/' . $tablecloth->images->first()->name) }}"
                                data-id="{{ $tablecloth->id }}"
                                data-moddel="{{ substr($tablecloth->category->model, 4) }}"
                                data-design="{{ $tablecloth->color_design->design->title ?? '' }}"
                                data-color="{{ $tablecloth->color_design->color->color ?? '' }}"
                                data-title="{{ $tablecloth->title }}" data-price="{{ $prices->price }}"
                                data-pay="{{ $price }}" data-off="{{ $off }}"
                                data-offType="{{ $prices->offType }}" data-local="{{ $prices->local }}">افزودن به سبد
                                خرید</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row bg-white rounded-4 shadow-sm mb-5">
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
            <div class="row gap-5 mb-5">
                <div class="col p-0">
                    <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                        <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                            {{-- <i class="fa-solid fa-info info-badge-icon"></i> --}}
                            <i class="fa-solid fa-circle-info info-badge-icon"></i>
                            <h5 class="m-0">توضیحات</h5>
                        </div>
                        <p class="text-justify text-muted">
                            {{ $tablecloth->description }}
                        </p>
                    </div>
                    <div class="bg-white rounded-4 p-4 shadow-sm">
                        <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                            <i class="fa-regular fa-comments info-badge-icon"></i>
                            <h5 class="m-0">نظر شما برای ما مهم است</h5>
                        </div>
                        <form action="/comment" method="POST" class="">
                            @csrf
                            <input type="hidden" name="product" value="{{ $tablecloth->id }}">
                            <input type="hidden" name="model" value="Tablecloth">
                            <div class="mb-4">
                                <div class="autocomplete @error('text') filled @enderror" id="autocompleteBoxtext">
                                    <input type="text" id="searchInputtext" value="{{ old('text') }}"
                                        class="" name="text" oninput="nameinput('text')">
                                    <label for="searchInputtext">دیدگاه خود را در مورد این محصول بنویسید ...</label>
                                    <span class="clear-btn" id="clearBtn_text" onclick="clearInput('text')"
                                        @if (old('text')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('text')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            @if (Auth::check())
                                <button type="submit" class="btn btn-primary w-25 mb-3">ثبت دیدگاه</button>
                            @else
                                <button type="button" id="comment_btn" class="btn btn-primary w-25 mb-3">ثبت
                                    دیدگاه</button>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col bg-white rounded-4 p-4 shadow-sm">
                    <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                        {{-- <i class="fa-solid fa-info info-badge-icon"></i> --}}
                        <i class="fa-solid fa-circle-info info-badge-icon"></i>
                        <h5 class="m-0">جزئیات محصول</h5>
                    </div>
                    <ul class="list-group list-group-flush p-0">
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>ابعاد محصول</span>
                                <span class="point-span">{{ $tablecloth->dimensions }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>وزن تقریبی</span>
                                <span class="point-span">{{ $tablecloth->weight }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>جنس محصول</span>
                                <span class="point-span">{{ $tablecloth->kind }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>نوع دوخت</span>
                                <span class="point-span">{{ $tablecloth->sewingType }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>آستر</span>
                                <span class="point-span">{{ $tablecloth->haveEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>جنس آستر</span>
                                <span class="point-span">{{ $tablecloth->kindOfEster }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>قابلیت شستشو</span>
                                <span class="point-span">{{ $tablecloth->washable }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>موارد استفاده</span>
                                <span class="point-span">{{ $tablecloth->uses }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row bg-white rounded-4 shadow-sm p-3">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-3">
                    {{-- <i class="fa-solid fa-info info-badge-icon top-0"></i> --}}
                    <i class="fa-regular fa-comments info-badge-icon"></i>
                    <div>
                        <h5 class="m-0">دیدگاه کاربران</h5>
                        <span class="point-span">{{ $comments->count() }} دیدگاه برای این محصول ثبت شده است</span>
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
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
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
                        <h5 class="modal-title" id="galleryModalLabel">گالری تصاویر محصول</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="swiper modal-swiper" id="modalSwiper">
                            <div class="swiper-wrapper">
                                @foreach ($images as $key => $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $image['name']) }}"
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
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    <script>
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
                        title: "{{ $tablecloth->title }}",
                        text: "مشترک عزیز، این محصول را ببینید: {{ $tablecloth->title }}",
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
            maxQuantity = {{ $tablecloth->quantity }};
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
                    $quantitySpan.text(currentQuantity + item.quantity);
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
    </script>
@endsection
