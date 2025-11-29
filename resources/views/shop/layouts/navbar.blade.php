<header>
    <!-- بوکمارک -->
    <div class="bookmark-container">
        <div class="bookmark expanded" id="bookmark">
            <div class="bookmark-content">
                <div class="bookmark-text d-flex align-items-center justify-content-start h-100 gap-3">
                    <h6 class="m-0">توجه!</h6>
                    <p class="m-0">رنگ تصاویر با رنگ واقعی محصولات 20% تفاوت دارد.</p>
                    <button class="btn btn-close bg-light" id="bookmarkToggle"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- navbar -->
    <div class="main-menu rounded-3">
        <nav class="navbar navbar-expand-lg">
            <div class="container p-0 px-3 position-relative">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                    <img src="{{ asset('/hometemplate/img/logo.png') }}" alt="website logo">
                </a>
                <button class="navbar-toggler" type="button" id="mobileMenuToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 px-0">
                        <!-- دکمه دسته‌بندی‌ها -->
                        <div class="categories-dropdown d-flex" id="categoryTrigger">
                            <button class="categories-btn">
                                <i class="fas fa-bars"></i>
                                دسته‌بندی‌ها
                            </button>
                            @php
                                $categories = App\Category::where('parent_id', 0)->get();
                                $chunks = $categories->chunk(ceil($categories->count() / 4)); // تقسیم به 4 قسمت
                            @endphp
                        </div>

                        <li class="nav-item">
                            <a class="nav-link" href="#specials">
                                <img src="{{ asset('shop/assets/svgs/badge-percent.svg') }}" alt="hots"
                                    width="18">
                                شگفت انگیزها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#newest">جدیدترین ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#products">پرفروش ترین‌ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#branchs">نمایندگی های فروش</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">درباره ما</a>
                        </li>
                    </ul>
                    <!-- cart language, favorites and login ================================================================================================================== -->
                    <div class="d-flex gap-2 align-items-center justify-content-center position-relative">
                        <div class="language-selector" id="languageSelector">
                            <button class="language-btn border-0 text-muted" id="languageBtn">
                                <span class="current-language">En</span>
                                <i class="bi bi-globe"></i>
                            </button>
                        </div>
                        {{-- favorites menu --}}
                        <div class="favorites-container">
                            <a href="#" class="cart-btn">
                                <span class="cart-badge shopping-cart-badge">2</span>
                                <img src="{{ asset('shop/assets/svgs/heart-solid-full.svg') }}" alt="favorites"
                                    width="24">
                            </a>

                            <div class="favorites-dropdown">
                                <div class="cart-header">
                                    <span class="mb-0">لیست علاقه‌مندی ها</span>
                                    <span class="text-muted cart-items-count">2 کالا</span>
                                </div>

                                <div class="cart-items" id="navbarFavoritesList">
                                    <div class="cart-item">
                                        <img src="{{ asset('shop/assets/sliders/l2.jpg') }}" alt="test"
                                            class="cart-item-image">
                                        <div class="cart-item-content">
                                            <div class="cart-item-title">نام محصول</div>
                                            <div class="cart-item-price">
                                                <span class="cart-item-old-price">200,000,000</span>
                                                <small class="fs-10 text-muted">جمع جزء : </small>
                                                200,000,000 تومان
                                            </div>
                                            <div class="d-flex justify-content-start gap-2 align-items-center w-100 bg-white">
                                                <button class="buy-button add-to-cart" style="width: 30px;height:30px"><i class="fa-solid fa-heart text-danger fa-lg"></i></button>
                                                <button class="buy-button add-to-cart" style="width: 30px;height:30px"><i class="fa-solid fa-cart-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="cart-footer">
                                    <div class="cart-actions justify-content-between align-items-center">
                                        <a href="#" class="btn-checkout">مشاهده لیست علاقه‌مندی‌ها</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            if (session()->has('cart')) {
                                $cart = session('cart');
                                $sum = 0;
                                $list = ['products' => [], 'models' => [], 'quantities' => []];
                                foreach ($cart as $productID => $value) {
                                    foreach ($value as $model => $data) {
                                        $class = 'App\\' . $model;
                                        $product = $class::find($productID);
                                        // if ($product->visibility == 1) {
                                        array_push($list['products'], $product);
                                        array_push($list['models'], $model);
                                        array_push($list['quantities'], $data['quantity']);
                                        $sum = $sum + $data['quantity'];
                                        // }
                                    }
                                }
                            }
                        @endphp
                        <!-- منوی دراپ‌داون با انیمیشن -->
                        <div class="cart-container">
                            <a href="{{ route('cart.index') }}" class="cart-btn">
                                <span class="cart-badge shopping-cart-badge">{{ $sum ?? 0 }}</span>
                                <img src="{{ asset('shop/assets/svgs/cart-shopping-solid-full (1).svg') }}"
                                    alt="cart" width="24">
                            </a>

                            <div class="cart-dropdown">
                                <div class="cart-header">
                                    <span class="mb-0">سبد خرید</span>
                                    <span class="text-muted cart-items-count">{{ $sum ?? 0 }} کالا</span>
                                </div>

                                <div class="cart-items" id="navbarCartList">
                                    @php
                                        $price = 0;
                                        $off = 0;
                                        $totalQuantity = 0;
                                    @endphp
                                    @isset($cart)

                                        @foreach ($cart as $productId => $productData)
                                            @foreach ($productData as $model => $item)
                                                @php
                                                    $class = 'App\\' . $model;
                                                    $product = $class::find($productId);

                                                    if (!$product) {
                                                        continue;
                                                    }

                                                    $quantity = $item['quantity'];
                                                    $totalQuantity += $quantity;

                                                    // محاسبه قیمت
                                                    $p = $product->prices->where('local', 'تومان')->first();
                                                    $cartPrice = 0;
                                                    $cartOff = 0;

                                                    if ($p->offPrice > 0) {
                                                        if ($p->offType == 'مبلغ') {
                                                            $cartPrice = $p->price - $p->offPrice;
                                                            $cartOff = $p->offPrice;
                                                            $price += ($p->price - $p->offPrice) * $quantity;
                                                            $off += $cartOff * $quantity;
                                                        } elseif ($p->offType == 'درصد') {
                                                            $cartPrice = $p->price - $p->price * ($p->offPrice / 100);
                                                            $cartOff = $p->price * ($p->offPrice / 100);
                                                            $price +=
                                                                ($p->price - $p->price * ($p->offPrice / 100)) *
                                                                $quantity;
                                                            $off += $cartOff * $quantity;
                                                        }
                                                    } else {
                                                        $cartPrice = $p->price;
                                                        $price += $p->price * $quantity;
                                                    }

                                                    // تولید عنوان محصول
                                                    $title = $product->title;
                                                    if (isset($product->color_design->design->title)) {
                                                        $title .= ' طرح ' . $product->color_design->design->title;
                                                    }
                                                    if (isset($product->color_design->color->color)) {
                                                        $title .= ' رنگ ' . $product->color_design->color->color;
                                                    }

                                                    // آدرس تصویر
                                                    $image = $product->images->first()
                                                        ? asset('storage/images/' . $product->images->first()->name)
                                                        : '/images/no-image.png';

                                                    // لینک محصول
                                                    $productUrl = '#';
                                                    switch ($model) {
                                                        case 'Tablecloth':
                                                            $productUrl = route('tablecloth.show', [$product->id]);
                                                            break;
                                                    }

                                                    $basePrice = $p->price;
                                                    $baseOffPrice = $p->offPrice;
                                                    $offType = $p->offType;

                                                    if ($p->offPrice > 0) {
                                                        if ($p->offType == 'مبلغ') {
                                                            $cartPrice = $p->price - $p->offPrice;
                                                        } elseif ($p->offType == 'درصد') {
                                                            $cartPrice = $p->price - $p->price * ($p->offPrice / 100);
                                                        }
                                                    } else {
                                                        $cartPrice = $p->price;
                                                    }
                                                @endphp

                                                <div class="cart-item" data-id="{{ $productId }}"
                                                    data-model="{{ $model }}" data-base-price="{{ $basePrice }}"
                                                    data-base-off-price="{{ $baseOffPrice }}"
                                                    data-off-type="{{ $offType }}">
                                                    <img src="{{ $image }}" alt="{{ $title }}"
                                                        class="cart-item-image">
                                                    <div class="cart-item-content">
                                                        <div class="cart-item-title">{{ Str::limit($title, 22) }}</div>
                                                        <div class="cart-item-price">
                                                            @if ($cartOff > 0)
                                                                <span
                                                                    class="cart-item-old-price">{{ $p->offPrice }}</span>
                                                            @endif <small class="fs-10 text-muted">جمع
                                                                جزء : </small>
                                                            {{ number_format($cartPrice * $quantity) }} تومان
                                                        </div>
                                                        <div class="quantity-controls">
                                                            <button class="decrease" data-model="{{ $model }}"
                                                                data-id="{{ $productId }}">-</button>
                                                            <span class="count item-quantity">{{ $quantity }}</span>
                                                            <button class="increase" data-model="{{ $model }}"
                                                                data-id="{{ $productId }}">+</button>
                                                            <a href="#" class="delete-item me-3"
                                                                data-id="{{ $productId }}"
                                                                data-model="{{ $model }}">
                                                                <i class="far fa-trash-alt text-danger"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endisset
                                </div>

                                <div class="cart-footer">
                                    <div class="cart-actions justify-content-between align-items-center">
                                        <span class="cart-total-price">
                                            <span class="text-mute fs-10">مبلغ قابل پرداخت</span><br>
                                            {{ number_format($price ?? 0) }}
                                            تومان</span>
                                        <a href="{{ route('cart.index') }}" class="btn-checkout">مشاهده سبد خرید</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ورود و ثبت نام -->
                        <div class="flex justify-center items-center">
                            <div class="button-container border border-secondary rounded p-2">
                                @if (!Auth::check())
                                    <a href="{{ route('login') }}"
                                        class="text-muted text-decoration-none px-1 login-link">
                                        ورود
                                    </a>
                                    |
                                    <a href="{{ route('register') }}"
                                        class="text-muted text-decoration-none px-1 login-link">
                                        ثبت نام
                                    </a>
                                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                                @else
                                    <a href="{{ route('user.profile') }}"
                                        class="text-muted text-decoration-none px-1">
                                        <i class="fa-solid fa-user me-1"></i>
                                        {{ Auth::user()->name }} {{ Auth::user()->family }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- منوی دسته‌بندی برای دسکتاپ -->
                <div class="category-menu" id="categoryMenu">
                    <div class="category-content">
                        <div class="row">
                            @foreach ($chunks as $chunk)
                                <!-- ستون 1 -->
                                <div class="col-lg-3 col-md-6 category-column">
                                    @foreach ($chunk as $category)
                                        <a href="{{ route($category->link) ?? '#' }}"
                                            class="main-categories">{{ $category->title ?? '--' }}</a>
                                        @if ($category->childs()->count() > 0)
                                            <ul class="sub-categories">
                                                @foreach ($category->childs as $cat)
                                                    <li><a
                                                            href="{{ route($category->link) ?? '#' }}">{{ $cat->title ?? '--' }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- آکاردئون موبایل -->
    <div class="mobile-category-menu" id="mobileCategoryMenu">
        <div class="mobile-category-header">
            <span>فروشگاه ترمه سالاری</span>
            <button type="button" id="closeMobileMenu" class="btn-close"></button>
        </div>
        <div class="mobile-category-content">
            <!-- ورود و ثبت نام -->
            <div class="flex justify-center items-center mb-2">
                <div class="button-container border border-secondary rounded text-center p-2">
                    @if (!Auth::check())
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none px-1">
                            ورود
                        </a>
                        |
                        <a href="{{ route('register') }}" class="text-muted text-decoration-none px-1">
                            ثبت نام
                        </a>
                        <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                    @else
                        <a href="{{ route('user.profile') }}" class="text-muted text-decoration-none px-1">
                            <i class="fa-solid fa-user me-1"></i>
                            {{ Auth::user()->name }} {{ Auth::user()->family }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="mobile-main-category py-3">
                <a href="{{ route('cart.index') }}" class="text-reset text-decoration-none fw-bold">
                    <img src="{{ asset('shop/assets/svgs/cart.svg') }}" alt="cart" width="24">
                    سبد خرید
                </a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#specials">
                    <img src="{{ asset('shop/assets/svgs/badge-percent.svg') }}" alt="hots" width="18">
                    شگفت انگیزها</a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#newest">جدیدترین ها</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#products">پرفروش ترین‌ها</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#branchs">نمایندگی های فروش</a>

            </div>
            @foreach ($categories as $category)
                <div class="mobile-main-category">
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#{{ $category->id }}">
                        {{ $category->title ?? '--' }}
                    </button>
                    @if ($category->childs()->count() > 0)
                        <ul class="mobile-sub-categories collapse" id="{{ $category->id }}">
                            @foreach ($category->childs as $cat)
                                <li><a href="{{ route($category->link) ?? '#' }}">{{ $cat->title ?? '--' }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <!-- overlay برای بستن منوی موبایل -->
    <div class="overlay" id="overlay"></div>
</header>


<script>
    $(document).on('click', '.increase, .decrease', function(event) {
        event.stopPropagation();

        const $btn = $(this);
        const action = $btn.hasClass('increase') ? 'increase' : 'decrease';
        const id = $btn.data('id');
        const model = $btn.data('model');
        const $cartItem = $btn.closest('.cart-item');
        const $quantitySpan = $btn.siblings('.count');

        // گرفتن قیمت اصلی
        const basePrice = $cartItem.data('base-price');
        const baseOffPrice = $cartItem.data('base-off-price') || 0;
        const offType = $cartItem.data('off-type');

        const url = `${document.location.origin}/cart/change`;

        $.ajax({
            url: url,
            method: "POST",
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'action': action,
                'product': id,
                'model': model
            },
            success: function(response) {
                if (response == "finish") {

                    $cartItem.fadeOut(300, function() {
                        $(this).remove();
                        updateCartBadge();
                        updateCartTotal();
                    });

                    return;
                }

                const newQuantity = response.quantity;
                $quantitySpan.text(newQuantity);

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
                const $priceElement = $cartItem.find('.cart-item-price');

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

                updateCartBadge();
                updateCartTotal();
            }
        });
    });


    $(document).on('click', '.delete-item', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        const id = $btn.data('id');
        const model = $btn.data('model');
        const $cartItem = $btn.closest('.cart-item');
        const quantity = parseInt($cartItem.find('.item-quantity').text());
        $.ajax({
            url: "{{ route('cart.deleteItem') }}",
            method: "POST",
            data: {
                _token: '<?php echo csrf_token(); ?>',
                id: id,
                model: model
            },
            success: function(response) {

                if (response.status === "success") {

                    // حذف آیتم از DOM
                    $cartItem.fadeOut(300, function() {
                        $(this).remove();
                        updateCartBadge();
                        updateCartTotal();
                    });
                } else {
                    Swal.fire("خطا!", "عملیات انجام نشد.", "error");
                }
            },

            error: function() {
                Swal.fire("خطای سرور!", "اتصال اینترنت یا سرور بررسی شود.", "error");
            }
        });
    });

    // تابع به‌روزرسانی badge
    function updateCartBadge() {
        let totalItems = 0;
        $('.item-quantity').each(function() {
            totalItems += parseInt($(this).text());
        });
        $('.shopping-cart-badge').text(totalItems);
        $('.cart-items-count').text(totalItems + ' کالا');
    }

    // ------------------------- جمع کل سبد خرید ------------------------
    function updateCartTotal() {
        let totalPriceBefore = 0;
        let totalDiscount = 0;
        let totalPayable = 0;

        $('.cart-item').each(function() {
            const $item = $(this);
            const quantity = parseInt($item.find('.item-quantity').text());
            const basePrice = $item.data('base-price');
            const baseOffPrice = $item.data('base-off-price') || 0;
            const offType = $item.data('off-type');

            let before = basePrice * quantity;
            let discount = 0;

            if (baseOffPrice > 0) {
                if (offType === 'مبلغ') {
                    discount = baseOffPrice * quantity;
                } else if (offType === 'درصد') {
                    discount = (basePrice * (baseOffPrice / 100)) * quantity;
                }
            }

            totalPriceBefore += before;
            totalDiscount += discount;
            totalPayable += before - discount;
        });

        // تزریق در HTML
        $('.cart-total-price').text(totalPayable.toLocaleString() + ' تومان');
    }

    // مدیریت هاور روی سبد خرید
    let cartTimeout;
    $('.cart-container').hover(
        function() {
            clearTimeout(cartTimeout);
            $('.cart-dropdown').css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'translateY(0)'
            });
        },
        function() {
            cartTimeout = setTimeout(function() {
                $('.cart-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 300);
        }
    );

    // جلوگیری از بستن وقتی هاور روی منو است
    $('.cart-dropdown').hover(
        function() {
            clearTimeout(cartTimeout);
        },
        function() {
            cartTimeout = setTimeout(function() {
                $('.cart-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 300);
        }
    );
</script>
