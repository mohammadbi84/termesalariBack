@extends('shop.layouts.master')
@section('title', 'محصولات رومیزی')
@section('head')
    <style>
        :root {
            --primary-color: #4FBA6C;
            --dark-green: #327942;
            --bg-light: #f8f9fa;
        }

        /* --- استایل‌های عمومی --- */
        .filter-card {
            background: white;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .filter-header {
            font-weight: bold;
            color: var(--dark-green);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        /* --- استایل کارت محصول (Grid View) --- */
        .product-card {
            border: 1px solid #eee;
            transition: all 0.3s ease;
            border-radius: 10px;
            background: white;
            height: 100%;
            position: relative;
            overflow: hidden;
            margin-bottom: 0 !important;
        }

        .product-card:hover {
            box-shadow: 0 5px 15px rgba(79, 186, 108, 0.2);
            border-color: var(--primary-color);
        }

        /* بخش تصویر */
        .product-img-wrapper {
            height: 220px;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .product-img-wrapper img {
            max-width: 100%;
            max-height: 100%;
        }

        /* لیبل ناموجود */
        .out-of-stock-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            z-index: 2;
        }

        /* تار کردن تصویر محصول ناموجود */
        .product-card.out-of-stock .product-img-wrapper img {
            opacity: 0.5;
            filter: grayscale(100%);
        }

        /* بدنه کارت */
        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }

        .stars {
            color: #ffc107;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .product-price {
            color: var(--dark-green);
            font-size: 1.1rem;
            font-weight: bold;
            margin-top: auto;
        }

        /* --- استایل لیست افقی (List View) --- */
        /* وقتی کلاس list-view به نگهدارنده اضافه شود */
        .products-container.list-view .col-item {
            width: 100%;
            /* تمام عرض */
            flex: 0 0 100%;
        }

        .products-container.list-view .product-card {
            display: flex;
            flex-direction: row;
            /* چیدمان افقی */
            height: auto;
            align-items: center;
        }

        .products-container.list-view .product-img-wrapper {
            width: 200px;
            height: 180px;
            flex-shrink: 0;
        }

        .products-container.list-view .card-body {
            align-items: flex-start;
            text-align: right;
            width: 100%;
        }

        .products-container.list-view .product-action {
            margin-top: 0;
            margin-right: auto;
            /* دکمه برود سمت چپ */
        }

        /* --- جستجوی دسته‌بندی --- */
        .cat-search-wrapper {
            position: relative;
            margin-bottom: 10px;
        }

        .cat-search-input {
            width: 100%;
            padding: 5px 30px 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .cat-search-clear {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            display: none;
            /* پیش‌فرض مخفی */
        }

        .cat-search-clear:hover {
            color: #dc3545;
        }

        /* --- مرتب‌سازی جدید --- */
        .sort-options {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .sort-item {
            cursor: pointer;
            color: #666;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 20px;
            transition: 0.3s;
            font-size: 0.95rem;
        }

        .sort-item:hover {
            color: var(--primary-color);
            background: #e9f7ec;
        }

        .sort-item.active {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
        }

        /* دکمه‌های ویو */
        .view-btn {
            border: 1px solid #ddd;
            background: white;
            color: #666;
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .view-btn.active {
            background-color: var(--dark-green);
            color: white;
            border-color: var(--dark-green);
        }

        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: var(--dark-green);
            color: white;
        }

        .btn-custom:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        @media (max-width: 576px) {
            .products-container.list-view .product-card {
                flex-direction: column;
            }

            .products-container.list-view .product-img-wrapper {
                width: 100%;
                height: 200px;
            }

            .sort-options {
                gap: 5px;
                font-size: 0.8rem;
            }
        }

        /* چک‌باکس و رنج */
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .active>.page-link,
        .page-link.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .page-link {
            color: var(--primary-color);
        }

        .page-link:hover {
            color: var(--primary-color);
        }

        .filter-list {
            padding-left: 10px;
            max-height: 300px;
            overflow-y: scroll;
        }

        .filter-list::-webkit-scrollbar {
            width: 5px;
        }

        .filter-list::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 5px;
        }

        .page-item:last-child .page-link {
            border-top-left-radius: var(--bs-pagination-border-radius) !important;
            border-bottom-left-radius: var(--bs-pagination-border-radius) !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .page-item:first-child .page-link {
            border-top-right-radius: var(--bs-pagination-border-radius);
            border-bottom-right-radius: var(--bs-pagination-border-radius);
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            margin-left: calc(var(--bs-border-width) * -1);
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
        }

        .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3),
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-control,
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-select,
        .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        .pagination {
            padding: 0 !important;
        }

        @media (max-width: 576px) {

            .pagination li a,
            .pagination li span {
                padding: .35rem .55rem;
                font-size: .8rem;
            }

            .pagination li:not(.active):not(:first-child):not(:last-child) {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container" style="margin-top:100px;">
        <div class="row">

            {{-- SIDEBAR FILTERS --}}
            <aside class="col-lg-3 mb-4">

                <form id="filterForm">

                    {{-- سرچ --}}
                    <div class="filter-card">
                        <div class="filter-header">جستجو در کالاها</div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="نام محصول...">
                            <button class="btn btn-custom" id="btnSearch" type="button"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>

                    {{-- دسته‌بندی --}}
                    <div class="filter-card">
                        <div class="filter-header">دسته‌بندی‌ها</div>

                        {{-- <div class="cat-search-wrapper">
                            <input type="text" class="cat-search-input" id="catSearchInput" placeholder="جستجوی دسته...">
                            <i class="fas fa-times cat-search-clear" id="catSearchClear"></i>
                        </div> --}}

                        <div id="categoryList" class="filter-list">
                            @foreach ($categories as $cat)
                                <div class="form-check mb-2 cat-item">
                                    <input class="form-check-input filter-check category-filter" type="checkbox"
                                        value="{{ $cat->id }}" id="cat{{ $cat->id }}"
                                        {{ in_array($cat->id, request()->categories ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat{{ $cat->id }}">{{ $cat->title }}</label>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    {{-- طرح --}}
                    <div class="filter-card">
                        <div class="filter-header">طرح</div>
                        <div class="filter-list">
                            @foreach ($designs as $design)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input filter-check design-filter"
                                        value="{{ $design->id }}" id="design{{ $design->id }}"
                                        {{ in_array($design->id, request()->designs ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="design{{ $design->id }}">{{ $design->title }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- رنگ --}}
                    <div class="filter-card">
                        <div class="filter-header">رنگ</div>
                        <div class="filter-list">
                            @foreach ($colors as $color)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input filter-check color-filter"
                                        value="{{ $color->id }}" id="color{{ $color->id }}"
                                        {{ in_array($color->id, request()->colors ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="color{{ $color->id }}">{{ $color->color }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- موجود بودن --}}
                    <div class="filter-card">
                        <div class="form-check form-switch">
                            <input class="form-check-input filter-check" type="checkbox" id="stockSwitch"
                                {{ request('stock') == 0 ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="stockSwitch">فقط کالاهای موجود</label>
                        </div>
                    </div>

                    {{-- قیمت --}}
                    <div class="filter-card">
                        <div class="filter-header">محدوده قیمت</div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <input type="number" id="minPrice" name="minPrice" class="form-control form-control-sm"
                                placeholder="از" value="{{ $minPrices }}">
                            <span>تا</span>
                            <input type="number" id="maxPrice" name="maxPrice" class="form-control form-control-sm"
                                placeholder="تا" value="{{ $maxPrices }}">
                        </div>
                        <button type="button" id="priceFilterBtn" class="btn btn-custom w-100 btn-sm mt-2">اعمال</button>
                    </div>

                </form>

            </aside>

            {{-- PRODUCTS SECTION --}}
            <main class="col-lg-9">

                {{-- sort & view --}}
                <div
                    class="filter-card d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 p-3">

                    <div class="d-flex align-items-center">
                        <span class="ms-2 fw-bold text-muted"><i class="fas fa-sort-amount-down"></i> مرتب‌سازی:</span>
                        <div class="sort-options" id="sortContainer">
                            <span class="sort-item active" data-val="newest">جدیدترین</span>
                            <span class="sort-item" data-val="cheapest">ارزان‌ترین</span>
                            <span class="sort-item" data-val="expensive">گران‌ترین</span>
                            <span class="sort-item" data-val="popular">محبوب‌ترین</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="view-btn active" id="btnGridView"><i class="fas fa-th"></i></button>
                        <button class="view-btn" id="btnListView"><i class="fas fa-list"></i></button>
                    </div>
                </div>

                {{-- AJAX PRODUCTS --}}
                <div id="productsWrapper" class="row g-3 products-container">
                    @include('tablecloth.partials.products')
                </div>

            </main>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>

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

                return {
                    designs: designs,
                    colors: colors,
                    categories: cats,
                    stock: $('#stockSwitch').is(':checked') ? 1 : 0,
                    sort: $('.sort-item.active').data('val'),
                    minPrice: $('input[name="minPrice"]').val(),
                    maxPrice: $('input[name="maxPrice"]').val(),
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
                    url: "{{ route('products.filter') }}",
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


            /** ==========================
             *  5) Event Listeners
             * ========================= */

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
            $('.filter-check').change(fetchProducts);

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

            // $('#catSearchInput').on('keyup', function() {
            // let value = $(this).val().toLowerCase();
            //
            // if (value.length > 0) $('#catSearchClear').show();
            // else $('#catSearchClear').hide();
            //
            // $('.cat-item').filter(function() {
            // $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            // });
            // });
            //
            // $('#catSearchClear').click(function() {
            // $('#catSearchInput').val('').trigger('keyup');
            // });

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
    </script>
@endsection
