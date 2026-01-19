@extends('shop.layouts.master')
@section('title', 'محصولات پشتی و کوسن')
@section('head')
    @if (app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('shop/css/products.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('shop/css/ltr/products.css') }}">
    @endif
@endsection
@section('content')
    <div class="container" style="margin-top:100px;">
        <div class="row g-0 rounded-3 px-2 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="/store" class="text-decoration-none text-muted">
                            <i class="fas fa-home"></i> {{ __('products.home') }}
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        {{ __('products.pillow_products') }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">

            {{-- SIDEBAR FILTERS --}}
            <aside class="col-lg-3 mb-4">

                <form id="filterForm">

                    {{-- سرچ --}}
                    <div id="accordion1" class="mb-3">
                        <div class="card border">
                            <div class="card-header bg-white">
                                <a class="btn w-100 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapseOne">
                                    <span>{{ __('products.search_in_products') }}</span>
                                    <span><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" data-bs-parent="#accordion1">
                                <div class="card-body p-3">
                                    <div class="autocomplete" id="autocompleteBoxsearch">
                                        <input type="text" id="searchInputsearch" class="" name="search"
                                            oninput="nameinput('search')">
                                        <label for="searchInputsearch">
                                            {{ __('products.search_placeholder') }}
                                        </label>
                                        <span class="clear-btn" id="clearBtn_search" onclick="clearInput('search')">×</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- قیمت --}}
                    <div id="accordion2" class="mb-3">
                        <div class="card border">
                            <div class="card-header bg-white">
                                <a class="btn w-100 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapsePrice">
                                    <span>{{ __('products.price_range') }}</span>
                                    <span><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                            </div>
                            <div id="collapsePrice" class="collapse show" data-bs-parent="#accordion2">
                                <div class="card-body p-3">
                                    <div class="d-flex flex-column align-items-center gap-3 mb-2">
                                        <div class="autocomplete w-100" id="autocompleteBoxmin">
                                            <span class="text-muted input_label_toman">
                                                {{ __('products.toman') }}
                                            </span>
                                            <input type="text" id="searchInputmin" class="only-number pe-2"
                                                name="minPrice" style="padding-right: 66px !important;" data-fakename="min"
                                                oninput="nameinput('min')">
                                            <label for="searchInputmin">{{ __('products.from') }}</label>
                                            <span class="clear-btn" id="clearBtn_min" onclick="clearInput('min')">×</span>
                                        </div>
                                        <div class="autocomplete w-100" id="autocompleteBoxmax">
                                            <span class="text-muted input_label_toman">
                                                {{ __('products.toman') }}
                                            </span>
                                            <input type="text" id="searchInputmax" class="only-number pe-2"
                                                name="maxPrice" style="padding-right: 66px !important;" data-fakename="max"
                                                oninput="nameinput('max')">
                                            <label for="searchInputmax">{{ __('products.to') }}</label>
                                            <span class="clear-btn" id="clearBtn_max" onclick="clearInput('max')">×</span>
                                        </div>
                                    </div>
                                    <button type="button" id="priceFilterBtn" class="btn btn-custom w-100 mt-2">
                                        {{ __('products.apply') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- موجود بودن --}}
                    <div id="accordion3" class="mb-3">
                        <div class="card border">
                            <div class="card-header bg-white">
                                <a class="btn w-100 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapseStock">
                                    <span>{{ __('products.stock_discount_filter') }}</span>
                                    <span><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                            </div>
                            <div id="collapseStock" class="collapse show" data-bs-parent="#accordion3">
                                <div class="card-body p-3">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input filter-check" type="checkbox" id="stockSwitch">
                                        <label class="form-check-label fw-bold">
                                            {{ __('products.only_available') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input filter-check" type="checkbox" id="onlyOffer">
                                        <label class="form-check-label fw-bold">
                                            {{ __('products.only_discount') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- دسته‌بندی --}}
                    <div id="accordion4" class="mb-3">
                        <div class="card border">
                            <div class="card-header bg-white">
                                <a class="btn w-100 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapseCat">
                                    <span>{{ __('products.categories') }}</span>
                                    <span><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                            </div>
                            <div id="collapseCat" class="collapse show" data-bs-parent="#accordion4">
                                <div class="card-body p-3">
                                    <div class="cat-search-wrapper">
                                        <div class="autocomplete" id="autocompleteBoxcat">
                                            <input type="cat" id="searchInputcat" class="" name="cat"
                                                oninput="nameinput('cat')">
                                            <label for="searchInputcat">
                                                {{ __('products.search_category') }}
                                            </label>
                                            <span class="clear-btn" id="clearBtn_cat"
                                                onclick="clearInput('cat')">×</span>
                                        </div>
                                    </div>

                                    <div id="categoryList" class="filter-list">
                                        @foreach ($categories as $cat)
                                            <div class="form-check mb-2 cat-item custom-check-rtl">
                                                <input class="form-check-input filter-check category-filter"
                                                    type="checkbox" value="{{ $cat->id }}"
                                                    id="cat{{ $cat->id }}"
                                                    {{ in_array($cat->id, request()->categories ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="cat{{ $cat->id }}">{{ $cat->title }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- طرح --}}
                    <div id="accordion5" class="mb-3">
                        <div class="card border">
                            <div class="card-header bg-white">
                                <a class="btn w-100 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapseDesign">
                                    <span>{{ __('products.design') }}</span>
                                    <span><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                            </div>
                            <div id="collapseDesign" class="collapse show" data-bs-parent="#accordion5">
                                <div class="card-body p-3">
                                    <div class="cat-search-wrapper">
                                        <div class="autocomplete" id="autocompleteBoxdesign">
                                            <input type="text" id="searchInputdesign" class="" name="design"
                                                oninput="nameinput('design')">
                                            <label for="searchInputdesign">
                                                {{ __('products.search_design') }}
                                            </label>
                                            <span class="clear-btn" id="clearBtn_design"
                                                onclick="clearInput('design')">×</span>
                                        </div>
                                    </div>
                                    <div class="filter-list" id="designList">
                                        @foreach ($designs as $design)
                                            <div class="form-check design-item custom-check-rtl">
                                                <input type="checkbox" class="form-check-input filter-check design-filter"
                                                    value="{{ $design->id }}" id="design{{ $design->id }}"
                                                    {{ in_array($design->id, request()->designs ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="design{{ $design->id }}">{{ $design->title }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- رنگ --}}
                    <div id="accordion6" class="mb-3">
                        <div class="card border">
                            <div class="card-header bg-white">
                                <a class="btn w-100 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapseColor">
                                    <span>{{ __('products.color') }}</span>
                                    <span><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                            </div>
                            <div id="collapseColor" class="collapse show" data-bs-parent="#accordion6">
                                <div class="card-body p-3">
                                    <div class="cat-search-wrapper">
                                        <div class="autocomplete" id="autocompleteBoxcolor">
                                            <input type="text" id="searchInputcolor" class="" name="color"
                                                oninput="nameinput('color')">
                                            <label for="searchInputcolor">
                                                {{ __('products.search_color') }}
                                            </label>
                                            <span class="clear-btn" id="clearBtn_color"
                                                onclick="clearInput('color')">×</span>
                                        </div>
                                    </div>
                                    <div class="filter-list" id="colorList">
                                        @foreach ($colors as $color)
                                            <div class="form-check color-item custom-check-rtl">
                                                <input type="checkbox" class="form-check-input filter-check color-filter"
                                                    value="{{ $color->id }}" id="color{{ $color->id }}"
                                                    {{ in_array($color->id, request()->colors ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="color{{ $color->id }}">{{ $color->color }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </aside>

            {{-- PRODUCTS SECTION --}}
            <main class="col-lg-9">

                {{-- sort & view --}}
                <div
                    class="filter-card d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 p-3">

                    <div class="d-flex align-items-center">
                        <span class="ms-2 fw-bold text-muted">
                            <i class="fas fa-sort-amount-down"></i>
                            {{ __('products.sort_by') }}:
                        </span>
                        <div class="sort-options" id="sortContainer">
                            <span class="sort-item active" data-val="newest">
                                {{ __('products.newest') }}
                            </span>
                            <span class="sort-item" data-val="cheapest">
                                {{ __('products.cheapest') }}
                            </span>
                            <span class="sort-item" data-val="expensive">
                                {{ __('products.expensive') }}
                            </span>
                            <span class="sort-item" data-val="popular">
                                {{ __('products.popular') }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="view-btn active" id="btnGridView"><i class="fas fa-th"></i></button>
                        <button class="view-btn" id="btnListView"><i class="fas fa-list"></i></button>
                    </div>
                </div>

                {{-- AJAX PRODUCTS --}}
                <div id="productsWrapper" class="row g-3 products-container">
                    @include('pillow.partials.products')
                </div>

            </main>

        </div>
    </div>
@endsection
@section('script')
    @if (app()->getLocale() == 'fa')
        <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    @else
        <script src="{{ asset('shop/js/ltr/main-menu-full.js') }}"></script>
    @endif

    <script>
        $(document).ready(function() {
            /** ==========================
             *  1) مقداردهی اولیه از Route
             * ========================= */

            let selectedCategories = @json($selectedCategories ?? []);
            let selectedStock = @json($inStock ?? false);
            let selectedSort = @json($sort ?? 'newest');
            let selectedView = @json($view ?? 'grid');
            let minPrice = @json($minPrice ?? null);
            let maxPrice = @json($maxPrice ?? null);
            let searchTerm = @json($searchTerm ?? '');


            /** ==========================
             *  2) UI را بر اساس روت تنظیم کن
             * ========================= */

            // دسته‌بندی‌ها
            selectedCategories.forEach(cat => {
                $(`input.category-filter[value="${cat}"]`).prop("checked", true);
            });

            // فقط موجود
            if (selectedStock) {
                $('#stockSwitch').prop("checked", true);
            }

            // مرتب‌سازی
            $('.sort-item').removeClass('active');
            $(`.sort-item[data-val="${selectedSort}"]`).addClass('active');

            // حالت نمایش
            if (selectedView === 'list') {
                $('#productsWrapper').addClass('list-view');
                $('#btnGridView').removeClass('active');
                $('#btnListView').addClass('active');
            } else {
                $('#btnGridView').addClass('active');
            }

            // قیمت
            if (minPrice) $('input[name="minPrice"]').val(minPrice);
            if (maxPrice) $('input[name="maxPrice"]').val(maxPrice);

            // سرچ
            if (searchTerm) $('input[name="search"]').val(searchTerm);


            /** ==========================
             *  3) توابع جمع‌آوری فیلترها
             * ========================= */
            function collectFilters() {
                let cats = [];
                $('.category-filter[type="checkbox"]:checked').each(function() {
                    cats.push($(this).val());
                });
                let designs = [];
                $('.design-filter[type="checkbox"]:checked').each(function() {
                    designs.push($(this).val());
                });
                let colors = [];
                $('.color-filter[type="checkbox"]:checked').each(function() {
                    colors.push($(this).val());
                });
                let minPrice = $('#searchInputmin').val().replace(/,/g, '');
                let maxPrice = $('#searchInputmax').val().replace(/,/g, '');

                return {
                    designs: designs,
                    colors: colors,
                    categories: cats,
                    stock: $('#stockSwitch').is(':checked') ? 1 : 0,
                    onlyOffer: $('#onlyOffer').is(':checked') ? 1 : 0,
                    sort: $('.sort-item.active').data('val'),
                    minPrice: minPrice,
                    maxPrice: maxPrice,
                    search: $('input[name="search"]').val(),
                    view: $('#btnListView').hasClass('active') ? 'list' : 'grid'
                };
            }


            /** ==========================
             *  4) Ajax Filtering
             * ========================= */
            function fetchProducts() {
                let filters = collectFilters();

                $.ajax({
                    url: "{{ route('pillow.filter') }}",
                    method: "GET",
                    data: filters,
                    beforeSend: function() {
                        $("#productsWrapper").css("opacity", "0.4");
                    },
                    success: function(response) {
                        $("#productsWrapper").html(response.html);
                        $("#productsWrapper").css("opacity", "1");
                    }
                });
            }

            reorderAllFilterLists();

            /** ==========================
             *  5) Event Listeners
             * ========================= */

            function reorderAllFilterLists() {

                $('.filter-list').each(function() {

                    let container = $(this);

                    // گرفتن همه آیتم ها
                    let checkedItems = container.find('.filter-check:checked')
                        .closest('.form-check')
                        .sort((a, b) => {
                            return $(a).find('label').text().localeCompare($(b).find('label').text());
                        });

                    let uncheckedItems = container.find('.filter-check:not(:checked)')
                        .closest('.form-check')
                        .sort((a, b) => {
                            return $(a).find('label').text().localeCompare($(b).find('label').text());
                        });

                    container.append(checkedItems);
                    container.append(uncheckedItems);
                });
            }

            // مرتب‌سازی
            $('.sort-item').click(function() {
                $('.sort-item').removeClass('active');
                $(this).addClass('active');
                fetchProducts();
            });

            // حالت نمایش
            $('#btnListView').click(function() {
                $('#productsWrapper').addClass('list-view');
                $(this).addClass('active');
                $('#btnGridView').removeClass('active');
                fetchProducts();
            });

            $('#btnGridView').click(function() {
                $('#productsWrapper').removeClass('list-view');
                $(this).addClass('active');
                $('#btnListView').removeClass('active');
                fetchProducts();
            });

            // دسته‌بندی‌ها
            // $('.filter-check').change(fetchProducts, reorderAllFilterLists);
            $(document).on('change', '.filter-check', function() {
                reorderAllFilterLists();
                fetchProducts();
            });


            // موجود
            $('#stockSwitch').change(fetchProducts);

            // سرچ
            $('input[name="search"]').keyup(function() {
                fetchProducts();
            });

            // قیمت
            $('#priceFilterBtn').click(fetchProducts);


            /** ==========================
             *  6) جستجو در دسته‌بندی (UI)
             * ========================= */

            $('#searchInputcat').on('keyup', function() {
                let value = $(this).val().toLowerCase();

                $('.cat-item').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });


            $('#searchInputdesign').on('keyup', function() {
                let value = $(this).val().toLowerCase();

                $('.design-item').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $('#searchInputcolor').on('keyup', function() {
                let value = $(this).val().toLowerCase();

                $('.color-item').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
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
                    $quantitySpan.text(currentQuantity + 1);
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
            const card = $btn.closest('.product-card');
            if (card) {
                card.removeClass('hovered'); // حذف کلاس
            }

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

        $(document).on("input", ".only-number", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
            let name = $(this).data('fakename');
            const box = document.getElementById("autocompleteBox" + name);
            const clearBtn = document.getElementById("clearBtn_" + name);
            let value2 = $(this).val();
            if (value2.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = "block";
                // تبدیل به عدد و فرمت سه‌تا سه‌تا
                this.value = Number(value2).toLocaleString('en-US');
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
