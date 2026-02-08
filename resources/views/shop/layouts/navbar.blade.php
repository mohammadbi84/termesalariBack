<header>
    <!-- بوکمارک -->
    @php
        $bookmarks = App\Bookmark::active()->orderBy('sort', 'asc')->get();
    @endphp
    @if ($bookmarks->count() > 0)
        <div class="bookmark-container">
            <div class="bookmark expanded" id="bookmark">
                <div class="swiper" id="bookmarkSlider">
                    <div class="swiper-wrapper">
                        @foreach ($bookmarks as $bookmark)
                            <div class="swiper-slide bookmark-content px-0" style="height: {{ $bookmark->height }}px;"
                                data-height="{{ $bookmark->height }}" data-delay="{{ $bookmark->duration }}">
                                <div class="bookmark-item">
                                    <!-- محتوای body که می‌تواند شامل عکس یا بک‌گراند باشد -->
                                    <div class="bookmark-media">
                                        {!! app()->getLocale() == 'fa' ? $bookmark->body_fa : $bookmark->body_en !!}
                                    </div>

                                    <!-- عنوان روی محتوا -->
                                    {{-- @if ($bookmark->show_title)
                                        <div class="bookmark-title-overlay">
                                            {{ app()->getLocale() == 'fa' ? $bookmark->title_fa : $bookmark->title_en }}
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-close bg-light" id="bookmarkToggle"></button>
            </div>
        </div>

        @if ($bookmarks->count() ==1)
            @php
                $height = $bookmarks->first()->height;
            @endphp
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    fixedHeight = {{ $height }};
                    setCssVar("--bookmark-height",`${fixedHeight}px`,);
                });
            </script>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // تنظیم ارتفاع و موقعیت بر اساس محتوا
                const bookmarkMedia = document.querySelectorAll('.bookmark-media');

                bookmarkMedia.forEach(media => {
                    const content = media.innerHTML.trim();

                    // اگر محتوا عکس یا ویدیو است
                    if (content.startsWith('<img') || content.startsWith('<video')) {
                        media.style.position = 'relative';
                        media.style.overflow = 'hidden';
                    }

                    // اگر محتوا div با بک‌گراند است
                    if (content.includes('background:')) {
                        const div = media.querySelector('div');
                        if (div) {
                            div.style.width = '100%';
                            div.style.height = '100%';
                            div.style.backgroundSize = 'cover';
                            div.style.backgroundPosition = 'center';
                        }
                    }
                });
            });
            let swiper = new Swiper("#bookmarkSlider", {
                loop: true,
                speed: 600,
                effect: "fade",
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 3000, // مقدار اولیه دلخواه
                    disableOnInteraction: false,
                },
                pagination: false,
                watchOverflow: false,
                on: {
                    init: function() {
                        // وقتی swiper mount شد، delay اولین اسلاید رو اعمال کن
                        let firstSlide = this.slides[this.activeIndex];
                        let delay = firstSlide.dataset.delay;
                        let height = firstSlide.dataset.height;
                        setCssVar("--bookmark-height",`${height}px`,);
                        if (delay) {
                            this.params.autoplay.delay = parseInt(delay);
                            this.autoplay.start();
                        }
                    },
                    slideChangeTransitionEnd: function() {
                        let activeSlide = this.slides[this.activeIndex];
                        let delay = activeSlide.dataset.delay;
                        let height = activeSlide.dataset.height;
                        setCssVar("--bookmark-height",`${height}px`,);

                        if (delay) {
                            this.params.autoplay.delay = parseInt(delay);
                            this.autoplay.start();
                        }
                    }
                }
            });
        </script>
    @else
        <div class="bookmark-container">
            <div class="bookmark collapsed" style="height: 5px;background: var(--primary-color);" id="bookmark">
                <div class="bookmark-content">
                    <div class="bookmark-text d-flex align-items-center justify-content-start h-100 gap-3">
                        <button class="btn btn-close bg-light" id="bookmarkToggle"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- navbar -->
    <div class="main-menu rounded-3">
        <nav class="navbar navbar-expand-lg">
            <div class="container p-0 px-3 position-relative">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                    <img src="{{ asset('hometemplate/img/logo.png') }}" alt="website logo">
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
                                {{ __('menu.categories') }}
                            </button>
                            @php
                                $categories = App\Category::where('parent_id', 0)->get();
                                $chunks = $categories->chunk(ceil($categories->count() / 4)); // تقسیم به 4 قسمت
                            @endphp
                        </div>

                        <li class="nav-item">
                            <a class="nav-link" href="#specials">
                                {{-- <img src="{{ asset('shop/assets/svgs/badge-percent.svg') }}" alt="hots"
                                    width="18"> --}}
                                <svg width="18" viewBox="0 0 63 54" fill="none" class="badge-percent-svg"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_65_10)">
                                        <path
                                            d="M31.4693 53.2213C25.409 53.2213 19.5467 51.9921 14.0432 49.5683C8.72884 47.2285 4.00424 43.8921 0 39.6523L4.41844 35.48C11.5218 43.0021 21.1286 47.1444 31.4693 47.1444C41.81 47.1444 51.1152 43.1267 58.1856 35.8312L62.55 40.0605C54.3239 48.5477 43.2853 53.2213 31.4693 53.2213Z"
                                            fill="#424242" />
                                        <path
                                            d="M44.406 36.7736C40.9271 36.7736 37.6448 34.647 36.3481 31.2041C34.6776 26.7661 36.9289 21.7969 41.3653 20.1264C45.8033 18.456 50.7725 20.7073 52.4444 25.1452C54.1149 29.5832 51.8636 34.5524 47.4272 36.2228C46.4321 36.598 45.4116 36.7736 44.406 36.7736ZM43.507 25.8116C42.2058 26.3023 41.5439 27.7596 42.0347 29.0624C42.5255 30.3651 43.9828 31.0255 45.2855 30.5347C46.5867 30.0439 47.2486 28.5866 46.7578 27.2854C46.267 25.9827 44.8097 25.3208 43.507 25.8116Z"
                                            fill="#424242" />
                                        <path d="M40.7327 0L16.8237 35.0231L21.8425 38.4493L45.7516 3.4262L40.7327 0Z"
                                            fill="#424242" />
                                        <path
                                            d="M18.1758 18.881C16.9676 18.881 15.764 18.6228 14.6323 18.111C12.5402 17.1625 10.9418 15.4576 10.1329 13.3069C9.32389 11.1577 9.39899 8.82093 10.3475 6.72883C11.296 4.63663 13.0009 3.03823 15.1516 2.22933C17.3008 1.42033 19.6376 1.49543 21.7298 2.44393C23.8219 3.39243 25.4203 5.09743 26.2292 7.24803C27.8997 11.686 25.6484 16.6552 21.2105 18.3272C20.2244 18.6979 19.1994 18.884 18.1758 18.884V18.881ZM18.1818 7.75233C17.8816 7.75233 17.5815 7.80633 17.2918 7.91593C16.6615 8.15303 16.1602 8.62283 15.8825 9.23663C15.6049 9.85053 15.5824 10.5364 15.8195 11.1667C16.0566 11.797 16.5264 12.2983 17.1402 12.576C17.7541 12.8536 18.4399 12.8761 19.0703 12.639C20.373 12.1482 21.0334 10.6909 20.5426 9.38823C20.3055 8.75793 19.8357 8.25663 19.2219 7.97893C18.8902 7.82893 18.536 7.75233 18.1818 7.75233Z"
                                            fill="#424242" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_65_10">
                                            <rect width="63" height="54" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                {{ __('menu.amazing') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="http://www.termehsalari.com/store#newest">{{ __('menu.newest') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="http://www.termehsalari.com/store#products">{{ __('menu.bestSeller') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="http://www.termehsalari.com/store#branchs">{{ __('menu.branchs') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">{{ __('menu.aboutUs') }}</a>
                        </li>
                    </ul>
                    <!-- cart language, favorites and login ================================================================================================================== -->
                    <div class="d-flex gap-1 align-items-center justify-content-center position-relative">
                        <div class="language-selector" id="languageSelector">
                            <button class="language-btn border-0 text-muted" id="languageBtn"
                                data-lang="{{ app()->getLocale() == 'fa' ? 'en' : 'fa' }}">
                                <span class="current-language">{{ app()->getLocale() == 'fa' ? 'En' : 'Fa' }}</span>
                                <i class="bi bi-globe"></i>
                            </button>
                        </div>
                        {{-- favorites menu --}}
                        @php
                            if (Auth::check()) {
                                $favorites = App\Favorite::where('user_id', Auth::id())->get();
                            } else {
                                $favorites = collect();
                            }
                        @endphp
                        @if (Auth::check())
                            <div class="favorites-container">
                                <a href="#" class="cart-btn">
                                    <span class="cart-badge favorites-badge">{{ $favorites->count() }}</span>
                                    @if ($favorites->count() > 0)
                                        <img src="{{ asset('shop/assets/svgs/heart-solid-full (1).svg') }}"
                                            alt="favorites" width="24">
                                    @else
                                        <img src="{{ asset('shop/assets/svgs/heart-solid-full.svg') }}" alt="favorites"
                                            width="24">
                                    @endif
                                </a>
                            </div>
                        @endif
                        <div class="compare-container">
                            <a href="{{ route('compare.index') }}" class="cart-btn">
                                <span class="cart-badge compare-badge">
                                    @if (session()->has('compares') and count(session('compares')['product']) > 0)
                                        {{ count(session('compares')['product']) }}
                                    @else
                                        0
                                    @endif
                                </span>
                                <img src="{{ asset('shop/assets/svgs/shuffle-solid-full.svg') }}" alt="compare"
                                    width="24">
                            </a>
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
                        </div>
                        <!-- ورود و ثبت نام -->
                        <div class="flex justify-center items-center">
                            @if (!Auth::check())
                                <div class="button-container border border-secondary rounded p-2">
                                    <a href="{{ route('login') }}"
                                        class="text-muted text-decoration-none px-1 login-link">
                                        {{ __('menu.login') }}
                                    </a>
                                    |
                                    <a href="{{ route('register') }}"
                                        class="text-muted text-decoration-none px-1 login-link">
                                        {{ __('menu.register') }}
                                    </a>
                                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                                </div>
                            @else
                                <div class="dropdown">
                                    <button type="button"
                                        class="button-container border border-secondary text-muted bg-white rounded p-2"
                                        data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-user mx-1"></i>
                                        {{ Auth::user()->name }} {{ Auth::user()->family }}
                                    </button>
                                    <ul class="dropdown-menu text-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                                <i class="fa-solid fa-user ms-1 top-0"></i>
                                                <span>{{ __('menu.profile') }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#"
                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <i class="fa-solid fa-arrow-right-from-bracket ms-1 top-0"></i>
                                                <span>{{ __('menu.logout') }}</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- منوی سبد خرید --}}
                <div class="cart-dropdown">
                    <div class="cart-header">
                        <span class="mb-0">{{ __('menu.cart') }}</span>
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
                                                $price += ($p->price - $p->price * ($p->offPrice / 100)) * $quantity;
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
                                        data-base-off-price="{{ $baseOffPrice }}" data-off-type="{{ $offType }}">
                                        <img src="{{ $image }}" alt="{{ $title }}"
                                            class="cart-item-image">
                                        <div class="cart-item-content">
                                            <div class="cart-item-title">{{ Str::limit($title, 22) }}</div>
                                            <div class="cart-item-price">
                                                @if ($cartOff > 0)
                                                    <span class="cart-item-old-price">{{ $p->offPrice }}</span>
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
                                                <a href="#" class="delete-item me-3" data-id="{{ $productId }}"
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
                                <span class="text-muted fs-10">مبلغ قابل پرداخت</span><br>
                                {{ number_format($price ?? 0) }}
                                تومان</span>
                            <a href="{{ route('cart.index') }}" class="btn-checkout">مشاهده سبد خرید</a>
                        </div>
                    </div>
                </div>
                {{-- منوی علاقه مندی ها --}}
                <div class="compare-dropdown">
                    <div class="favorites-header">
                        <span class="mb-0">{{ __('menu.compare') }}</span>
                        <span class="text-muted compare-items-count" id="compare-items-count">
                            @if (session()->has('compares'))
                                {{ count(session('compares')['product']) }} کالا
                            @else
                                0 کالا
                            @endif
                        </span>
                    </div>

                    <div class="compare-items" id="navbarCompareList">
                        @if (session('compares') != null)
                            @foreach (session('compares')['product'] as $compare)
                                <div class="compare-item" data-id="{{ $compare->id }}"
                                    data-model="{{ substr($compare->category->model, 4) }}">
                                    @php $image = $compare->images->first(); @endphp
                                    <img src="{{ asset('storage/images/thumbnails/' . $image['name']) }}"
                                        alt="product" class="favorites-item-image">
                                    <div class="favorites-item-content">
                                        <div class="favorites-item-title">
                                            {{ $compare->category->title }} طرح
                                            {{ $compare->color_design->design->title }} رنگ
                                            {{ $compare->color_design->color->color }}
                                        </div>
                                        <div class="favorites-item-price">
                                            @if ($compare->quantity > 0)
                                                @php
                                                    $price = $compare->prices->where('local', 'تومان')->first();
                                                @endphp
                                                @if ($price->offPrice > 0)
                                                    @if ($price->offType == 'مبلغ')
                                                        <span
                                                            class="favorites-item-old-price">{{ number_format($price->price - $price->offPrice) }}</span>
                                                    @elseif($price->offType == 'درصد')
                                                        <span
                                                            class="favorites-item-old-price">{{ number_format($price->price - $price->price * ($price->offPrice / 100)) }}</span>
                                                    @endif
                                                    {{ number_format($price->price) }}
                                                    تومان
                                                @else
                                                    {{ number_format($price->price) }}
                                                    تومان
                                                @endif
                                            @else
                                                ناموجود
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="cart-footer">
                        <div class="cart-actions justify-content-end align-items-center">
                            <a href="{{ route('compare.index') }}" class="btn-checkout">مشاهده لیست</a>
                        </div>
                    </div>
                </div>
                {{-- منوی علاقه مندی ها --}}
                @if (Auth::check())
                    <div class="favorites-dropdown">
                        <div class="favorites-header">
                            <span class="mb-0">{{ __('menu.favorites') }}</span>
                            <span class="text-muted favorites-items-count"
                                id="favorites-items-count">{{ $favorites->count() }} کالا</span>
                        </div>

                        <div class="favorites-items" id="navbarFavoritesList">
                            @foreach ($favorites as $favorite)
                                <div class="favorites-item" data-id="{{ $favorite->favoriteable->id }}"
                                    data-model="{{ substr($favorite->favoriteable_type, 4) }}">
                                    @php $image = $favorite->favoriteable->images->first(); @endphp
                                    <img src="{{ asset('storage/images/thumbnails/' . $image['name']) }}"
                                        alt="product" class="favorites-item-image">
                                    <div class="favorites-item-content">
                                        <div class="favorites-item-title">
                                            {{ $favorite->favoriteable->category->title }} طرح
                                            {{ $favorite->favoriteable->color_design->design->title }} رنگ
                                            {{ $favorite->favoriteable->color_design->color->color }}
                                        </div>
                                        <div class="favorites-item-price">
                                            @if ($favorite->favoriteable->quantity > 0)
                                                @php
                                                    $price = $favorite->favoriteable->prices
                                                        ->where('local', 'تومان')
                                                        ->first();
                                                @endphp
                                                @php
                                                    $off = 0;
                                                    if ($price->offPrice > 0) {
                                                        if ($price->offType == 'مبلغ') {
                                                            $off = $price->offPrice;
                                                        } elseif ($price->offType == 'درصد') {
                                                            $off = $price->price * ($price->offPrice / 100);
                                                        }
                                                    }
                                                @endphp


                                                @if ($price->offPrice > 0)
                                                    @if ($price->offType == 'مبلغ')
                                                        <span
                                                            class="favorites-item-old-price">{{ number_format($price->price - $price->offPrice) }}</span>
                                                    @elseif($price->offType == 'درصد')
                                                        <span
                                                            class="favorites-item-old-price">{{ number_format($price->price - $price->price * ($price->offPrice / 100)) }}</span>
                                                    @endif
                                                    {{ number_format($price->price) }}
                                                    تومان
                                                @else
                                                    {{ number_format($price->price) }}
                                                    تومان
                                                @endif
                                            @else
                                                ناموجود
                                            @endif
                                        </div>
                                        <div
                                            class="d-flex justify-content-start gap-2 align-items-center w-100 bg-white">
                                            <button class="buy-button add-to-cart favorites-btn active"
                                                data-image="{{ asset('/storage/images/thumbnails/' . $favorite->favoriteable->images->first()->name) }}"
                                                data-moddel="{{ substr($favorite->favoriteable_type, 4) }}"
                                                data-design="{{ $favorite->favoriteable->color_design->design->title ?? '' }}"
                                                data-color="{{ $favorite->favoriteable->color_design->color->color ?? '' }}"
                                                data-title="{{ $favorite->favoriteable->title }}"
                                                data-price="{{ $price->price }}" data-pay="{{ $price }}"
                                                data-off="{{ $off }}" data-offType="{{ $price->offType }}"
                                                data-local="{{ $price->local }}"
                                                data-id="{{ $favorite->favoriteable->id }}"
                                                data-model="{{ substr($favorite->favoriteable_type, 4) }}"
                                                style="width: 30px;height:30px"><i
                                                    class="fa-solid fa-heart text-danger fa-lg"></i></button>
                                            <button class="buy-button add-to-cart addToCart favorites"
                                                data-image="{{ asset('/storage/images/thumbnails/' . $favorite->favoriteable->images->first()->name) }}"
                                                data-moddel="{{ substr($favorite->favoriteable_type, 4) }}"
                                                data-design="{{ $favorite->favoriteable->color_design->design->title ?? '' }}"
                                                data-color="{{ $favorite->favoriteable->color_design->color->color ?? '' }}"
                                                data-title="{{ $favorite->favoriteable->title }}"
                                                data-price="{{ $price->price }}" data-pay="{{ $price }}"
                                                data-off="{{ $off }}" data-offType="{{ $price->offType }}"
                                                data-local="{{ $price->local }}"
                                                data-id="{{ $favorite->favoriteable->id }}"
                                                data-model="{{ substr($favorite->favoriteable_type, 4) }}"
                                                style="width: 30px;height:30px"><i
                                                    class="fa-solid fa-cart-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="cart-footer">
                            <div class="cart-actions justify-content-end align-items-center">
                                <a href="{{ route('user.favorites') }}" class="btn-checkout">مشاهده
                                    لیست</a>
                            </div>
                        </div>
                    </div>
                @endif
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
                                                            href="{{ route($category->link) ?? '#' }}?categories[]={{ $cat->id }}">{{ $cat->title ?? '--' }}</a>
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
            <span>{{ __('main.title') }}</span>
            <button type="button" id="closeMobileMenu" class="btn-close"></button>
        </div>
        <div class="mobile-category-content">
            <!-- ورود و ثبت نام -->
            <div class="flex justify-center items-center mb-2">
                <div class="button-container border border-secondary rounded text-center p-2">
                    @if (!Auth::check())
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none px-1">
                            {{ __('menu.login') }}
                        </a>
                        |
                        <a href="{{ route('register') }}" class="text-muted text-decoration-none px-1">
                            {{ __('menu.register') }}
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
                    {{ __('menu.cart') }}
                </a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#specials">
                    <img src="{{ asset('shop/assets/svgs/badge-percent.svg') }}" alt="hots" width="18">
                    {{ __('menu.amazing') }}</a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold"
                    href="http://www.termehsalari.com/store#newest">{{ __('menu.newest') }}</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold"
                    href="http://www.termehsalari.com/store#products">{{ __('menu.bestSeller') }}</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold"
                    href="http://www.termehsalari.com/store#branchs">{{ __('menu.branchs') }}</a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="{{ route('about') }}">{{ __('menu.aboutUs') }}</a>
            </div>
            @foreach ($categories as $category)
                <div class="mobile-main-category">
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#{{ $category->id }}">
                        {{ $category->title ?? '--' }}
                    </button>
                    @if ($category->childs()->count() > 0)
                        <ul class="mobile-sub-categories collapse" id="{{ $category->id }}">
                            @foreach ($category->childs as $cat)
                                <li><a href="{{ route($category->link) ?? '#' }}">{{ $cat->title ?? '--' }}</a>
                                </li>
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
                if (response == "error") {
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
        $('.cart-total-price').html('<span class="text-muted fs-10">مبلغ قابل پرداخت</span><br>' + totalPayable
            .toLocaleString() + ' تومان');
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
            }, 200);
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
            }, 200);
        }
    );
    let compareTimeout;
    $('.compare-container').hover(
        function() {
            clearTimeout(compareTimeout);
            $('.compare-dropdown').css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'translateY(0)'
            });
        },
        function() {
            compareTimeout = setTimeout(function() {
                $('.compare-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    // جلوگیری از بستن وقتی هاور روی منو است
    $('.compare-dropdown').hover(
        function() {
            clearTimeout(compareTimeout);
        },
        function() {
            compareTimeout = setTimeout(function() {
                $('.compare-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    let favoritesTimeout;
    $('.favorites-container').hover(
        function() {
            clearTimeout(favoritesTimeout);
            $('.favorites-dropdown').css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'translateY(0)'
            });
        },
        function() {
            favoritesTimeout = setTimeout(function() {
                $('.favorites-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    // جلوگیری از بستن وقتی هاور روی منو است
    $('.favorites-dropdown').hover(
        function() {
            clearTimeout(favoritesTimeout);
        },
        function() {
            favoritesTimeout = setTimeout(function() {
                $('.favorites-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
</script>
