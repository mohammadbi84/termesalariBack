@extends('shop.layouts.master')
@section('title', 'سبد خرید')
@section('head')
    <style>
        /* استایل نوار مراحل */
        .checkout-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .checkout-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            right: 0;
            left: 0;
            height: 2px;
            background-color: #dee2e6;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        /* خط پیشرفت */
        .progress-line {
            width: 0%;
            position: absolute;
            top: 20px;
            right: 0;
            height: 2px;
            background-color: var(--primary-color);
            z-index: 2;
            transition: all 0.3s ease;
        }

        .step.active .step-icon {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .step.completed .step-icon {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .step.completed .step-icon::after {
            content: '✓';
            font-weight: bold;
        }

        .step-text {
            font-size: 14px;
            text-align: center;
            color: #6c757d;
        }

        .step.active .step-text {
            color: var(--primary-color);
            font-weight: bold;
        }

        .step.completed .step-text {
            color: var(--primary-color);
        }

        .step-icon i {
            top: auto !important;
        }

        .cart-container-new {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            position: unset;
            display: block;
        }

        .cart-header {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .cart-product {
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .cart-product:hover {
            background-color: rgba(79, 186, 108, 0.05);
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: none !important;
        }

        .quantity-control {
            justify-content: start;
            margin-top: 10px;
            width: fit-content;
            background: #f8f9fa;
            border-radius: 5px;
            padding: 0 3px;
        }

        .quantity-btn {
            width: 25px;
            height: 25px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            color: var(--primary-color);
            font-weight: bold;
            border: 1px solid var(--primary-color);
            cursor: pointer;
        }

        .quantity-btn:hover {
            background: #146c43;
            color: white
        }

        .quantity-input {
            width: 25px;
            text-align: center;
            margin: 0 8px;
            background: transparent;
            border-radius: 5px;
            padding: 5px;
            border: none;
        }

        .form-control:focus {
            box-shadow: none !important;
            border: 1px solid var(--primary-color) !important;
        }

        .delete-btn {
            color: var(--danger-color);
            background: #f9e4e5;
            border-radius: 5px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 25px;
            width: 25px;
            text-decoration: none;
        }

        .delete-btn i {
            top: 1px;
        }

        .delete-btn:hover {
            background: #f8d7da;
        }

        .discount-section,
        .order-summary,
        .payment-section {
            background-color: var(--secondary-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--primary-color);
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 10px;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #146c43;
            border-color: #146c43;
        }

        .price-highlight {
            font-size: 18px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .discount-price {
            color: var(--danger-color);
            font-size: 14px;
        }

        .empty-cart {
            text-align: center;
            padding: 40px 0;
        }

        .empty-cart img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .cart-container-new {
                padding: 10px;
            }

            .product-image {
                width: 80px;
                height: 80px;
            }
        }
    </style>
@endsection
@section('content')
    @php
        $discountCardPrice = session()->get('discountCardPrice', 0);
    @endphp

    <div class="container my-4 px-3" style="margin-top: 120px !important;">
        <!-- نوار مراحل خرید -->
        <div class="checkout-steps">
            <div class="progress-line" id="progressLine"></div>

            <div class="step active" data-step="1">
                <div class="step-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="step-text">سبد خرید</div>
            </div>

            <div class="step" data-step="2">
                <div class="step-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="step-text">تکمیل اطلاعات پستی</div>
            </div>

            <div class="step" data-step="3">
                <div class="step-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="step-text">پرداخت</div>
            </div>

            <div class="step" data-step="4">
                <div class="step-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="step-text">تکمیل سفارش</div>
            </div>
        </div>
        <div class="row">
            <!-- سمت راست: لیست محصولات -->
            <div class="col-lg-8 mb-4">
                <div class="cart-container-new">
                    <div class="cart-header p-0 pb-2 d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h4 mb-0">سبد خرید شما</h2>
                        @if (isset($sum))
                            <span class="badge" style="background:#4FBA6C;color:#fff; padding:0.5rem 0.7rem;">
                                <span class="header-total-quantity">{{ $sum }}</span> کالا
                            </span>
                        @else
                            <span class="badge" style="background:#4FBA6C;color:#fff; padding:0.5rem 0.7rem;">0 کالا</span>
                        @endif
                    </div>

                    <div id="cart-products">
                        @if (isset($list) && count($list) > 0)
                            @php
                                $price = 0;
                                $off = 0;
                            @endphp

                            @foreach ($list['products'] as $key => $product)
                                @php
                                    $cartItemPrice = 0;
                                    $cartItemOff = 0;
                                    $p = $product->prices->where('local', 'تومان')->first();
                                    if ($p->offPrice > 0) {
                                        if ($p->offType == 'مبلغ') {
                                            $cartItemPrice = $p->price - $p->offPrice;
                                            $cartItemOff = $p->offPrice;
                                            $price += ($p->price - $p->offPrice) * $list['quantities'][$key];
                                            $off += $cartItemOff * $list['quantities'][$key];
                                        } else {
                                            $cartItemPrice = $p->price - $p->price * ($p->offPrice / 100);
                                            $cartItemOff = $p->price * ($p->offPrice / 100);
                                            $price += ($p->price - $cartItemOff) * $list['quantities'][$key];
                                            $off += $cartItemOff * $list['quantities'][$key];
                                        }
                                    } else {
                                        $cartItemPrice = $p->price;
                                        $price += $p->price * $list['quantities'][$key];
                                    }
                                @endphp

                                <div class="cart-product row align-items-center mb-3" data-product-id="{{ $product->id }}"
                                    data-product-model="{{ $list['models'][$key] }}">
                                    <div class="col-1 text-center">
                                        <button class="delete-btn btn btn-link text-danger delete"
                                            data-id="{{ $product->id }}" data-model="{{ $list['models'][$key] }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        @if ($product->images->first())
                                            <img src="{{ asset('storage/images/thumbnails/' . $product->images->first()->name) }}"
                                                alt="{{ $product->title }}" class="product-image img-fluid rounded">
                                        @else
                                            <img src="/mnt/data/26810264-030e-4f38-bdcf-3f7e1e5f9184.jpg" alt="محصول"
                                                class="product-image img-fluid rounded">
                                        @endif
                                    </div>
                                    <div class="col-8 col-md-5">
                                        <h5 class="mb-1">
                                            {{ $product->title ?? $product->category->title . ' طرح ' . optional($product->color_design->design)->title }}
                                            <small class="me-1 text-success" style="font-size: 15px;">(
                                                {{ number_format($cartItemPrice) }} تومان )</small>
                                        </h5>
                                        <p class="text-muted small mb-2">دسته بندی: {{ $product->category->title ?? '—' }}
                                        </p>
                                        <div class="ml-3 small">
                                            <div>کد محصول: <span class="text-muted">{{ $product->code }}</span></div>
                                            <div class="text-success small">گارانتی اصالت و سلامت فیزیکی کالا</div>
                                        </div>
                                        <div class="quantity-control d-flex align-items-center">
                                            <button class="quantity-btn btn btn-sm btn-outline-secondary decrease"
                                                data-id="{{ $product->id }}"
                                                data-model="{{ $list['models'][$key] }}">-</button>
                                            <input type="text"
                                                class="quantity-input form-control form-control-sm mx-2 text-center count"
                                                value="{{ $list['quantities'][$key] }}" data-id="{{ $product->id }}"
                                                readonly>
                                            <button class="quantity-btn btn btn-sm btn-outline-secondary increase"
                                                data-id="{{ $product->id }}"
                                                data-model="{{ $list['models'][$key] }}">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 mt-md-0 text-start text-md-end">
                                        <div class="price-highlight d-flex justify-content-around align-items-center">
                                            <small class="text-muted" style="font-size:14px;">جمع جزء : </small>
                                            <span
                                                class="item-price">{{ number_format($cartItemPrice * $list['quantities'][$key]) }}</span>
                                            <small> تومان</small>
                                        </div>
                                        @if ($cartItemOff > 0)
                                            <div class="discount-price"><del><span
                                                        class="original-price">{{ number_format($p->price) }}</span>
                                                    <small>تومان</small></del></div>
                                            <div class="text-danger small">تخفیف: <span
                                                    class="item-off">{{ number_format($cartItemOff) }}</span> تومان</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @php
                                $price = 0;
                                $off = 0;
                            @endphp
                            {{-- empty cart fallback --}}
                            <div id="empty-cart" class="empty-cart text-center">
                                <img src="{{ asset('/storetemplate/dist/img/empty-cart-icon.png') }}" alt="سبد خرید خالی"
                                    style="max-width:200px">
                                <h4 class="mt-3">سبد خرید شما خالی است!</h4>
                                <p class="text-muted">می‌توانید برای مشاهده محصولات به صفحه فروشگاه بروید.</p>
                                <a href="{{ url('/shop') }}" class="btn btn-primary-custom mt-2"
                                    style="background:#4FBA6C;color:#fff;">مشاهده محصولات</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- سمت چپ: بخش‌های مختلف -->
            <div class="col-lg-4">
                <!-- بخش کد تخفیف -->
                <div class="discount-section mb-4 p-0 shadow-sm">
                    <div id="accordion">
                        <div class="card border">
                            <div class="card-header bg-white">
                                <a class="btn w-100 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapseOne">
                                    <span>آیا کد تخفیف دارید؟</span>
                                    <span><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                                <div class="card-body">
                                    @if (!session()->has('discountCardPrice'))
                                        <div class="row mt-4 mb-4" id="discountCardRow">
                                            <div class="col-12">
                                                <div class="input-group input-group-md">
                                                    <input type="text" name="code" id="code"
                                                        style="border-top-left-radius: 0;border-bottom-left-radius: 0;border-top-right-radius: 5px;border-bottom-right-radius: 5px;"
                                                        placeholder="کد تخفیف..." class="form-control"
                                                        style="font-size: 0.95rem;">
                                                    <button type="button border" id="saveDiscountCard"
                                                        class="btn btn-primary btn-md"
                                                        style="background:#4FBA6C;color:#fff;font-size:0.95rem;border-top-right-radius: 0;border-bottom-right-radius: 0;border-top-left-radius: 5px;border-bottom-left-radius: 5px;">اعمال</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بخش جزئیات سفارش -->
                <div class="order-summary mb-4 p-3 shadow-sm"
                    style="border:1px solid #f1f1f1;border-radius:6px;background:#fff;">
                    <h3 class="section-title mb-3">جزئیات سفارش</h3>

                    <div class="d-flex justify-content-between mb-2">
                        <span>قیمت کالاها (<span id="cart_info-quantity">{{ $sum ?? 0 }}</span> عدد)</span>
                        <span><span id="cart-info-price"
                                data-value="{{ $price + $off }}">{{ number_format($price + $off) }}</span> تومان</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-danger">
                        <span>تخفیف کالاها</span>
                        <span><span id="cart-info-off">{{ number_format($off) }}</span> تومان</span>
                    </div>
                    @if (session()->has('discountCardPrice'))
                        <div class="d-flex justify-content-between mb-2">
                            <span>کد تخفیف</span>
                            <span>{{ number_format(session('discountCardPrice')) }} تومان</span>
                        </div>
                    @else
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-danger">کد تخفیف</span>
                            <span class="text-danger"><span id="cart-info-discount-special">0</span> تومان</span>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mb-2">
                        <span>هزینه ارسال</span>
                        <span class="text-success">محاسبه در مرحله بعد</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>جمع کل</span>
                        <span><span id="cart-info-total"
                                data-value="{{ $price - $discountCardPrice }}">{{ number_format($price - $discountCardPrice) }}</span>
                            تومان</span>
                    </div>
                </div>

                <!-- بخش مبلغ قابل پرداخت -->
                <div class="payment-section p-3 shadow-sm"
                    style="border:1px solid #f1f1f1;border-radius:6px;background:#fff;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">مبلغ قابل پرداخت:</span>
                        <span class="price-highlight"><span
                                id="total">{{ number_format($price - $discountCardPrice) }}</span> تومان</span>
                    </div>
                    <a href="{{ route('cart.cartlevel2') }}" class="btn btn-primary w-100 py-2 mb-2">ادامه فرایند
                        خرید</a>
                    <a href="/store" class="btn btn-secondary w-100 py-2">افزودن دیگر محصولات</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    <script src="{{ asset('/storetemplate/dist/js/jquery.number.min.js') }}"></script>
    <script>
        $(function() {
            // format initial numbers
            $('#cart-info-price, #cart-info-off, #cart-info-total, #total').each(function() {
                var v = $(this).data('value') ?? $(this).text();
                var n = parseInt(String(v).replace(/,/g, '')) || 0;
                $(this).text($.number(n));
            });

            // helper to update totals in UI (best-effort)
            function updateTotalsFromResponse(totals) {
                if (!totals) return;
                if (typeof totals.price !== 'undefined') {
                    $('#cart-info-price').attr('data-value', totals.price).text($.number(totals.price));
                }
                if (typeof totals.off !== 'undefined') {
                    $('#cart-info-off').text($.number(totals.off));
                }
                if (typeof totals.sum !== 'undefined') {
                    $('#cart-info-sum').attr('data-value', totals.sum).text($.number(totals.sum));
                }
                if (typeof totals.total !== 'undefined') {
                    $('#cart-info-total').attr('data-value', totals.total).text($.number(totals.total));
                    $('#total').text($.number(totals.total));
                }
                if (typeof totals.qty !== 'undefined') {
                    $('.header-total-quantity, #cart_info-quantity').text(totals.qty);
                }

            }

            // Increase / Decrease
            $(document).off('click', '.increase, .decrease');
            $(document).on('click', '.increase, .decrease', function(e) {
                e.preventDefault();
                $('.loader').show ? $('.loader').show() : null;
                var $btn = $(this);
                var action = $btn.hasClass('increase') ? 'increase' : 'decrease';
                var id = $btn.data('id');
                var model = $btn.data('model');

                var $productRow = $btn.closest('.cart-product');
                var $countInput = $productRow.find('.quantity-input');
                var $itemPrice = $productRow.find('.item-price'); // عنصر قیمت محصول
                var $itemOff = $productRow.find('.item-off'); // عنصر تخفیف محصول

                // دریافت قیمت پایه هر محصول از data attribute
                var basePrice = $productRow.data('base-price');
                if (!basePrice) {
                    // اگر data attribute وجود نداشت، از متن فعلی خوانده شود
                    basePrice = parseInt($itemPrice.text().replace(/,/g, '')/$countInput.val()) || 0;
                    // ذخیره قیمت پایه برای استفاده بعدی
                    $productRow.data('base-price', basePrice);
                }

                // دریافت تخفیف پایه هر محصول
                var baseOff = $productRow.data('base-off');
                if (!baseOff) {
                    baseOff = parseInt($itemOff.text().replace(/,/g, '')) || 0;
                    $productRow.data('base-off', baseOff);
                }

                $.post("{{ url('/cart/change/') }}", {
                    _token: '{{ csrf_token() }}',
                    action: action,
                    product: id,
                    model: model
                }, function(data) {
                    if (data == "error") {
                        Swal.fire("خطا در اجرای عملیات", "اتمام موجودی در انبار", "error");
                    } else {
                        if (data == "finish") {
                            $productRow.fadeOut(function() {
                                $(this).remove();
                                calculateTotals(); // محاسبه مجدد کل‌ها بعد از حذف محصول
                            });
                        } else {
                            var newQuantity;

                            // آپدیت تعداد
                            if (data.quantity !== undefined) {
                                newQuantity = data.quantity;
                                $countInput.val(newQuantity);
                                if ($countInput.text) {
                                    $countInput.text(newQuantity);
                                }
                            } else {
                                // fallback toggling +/- by 1
                                var cur = parseInt($countInput.val()) || 0;
                                newQuantity = action === 'increase' ? cur + 1 : Math.max(0, cur -
                                1);
                                $countInput.val(newQuantity);
                            }

                            // محاسبه و آپدیت قیمت برای این محصول خاص
                            updateProductPrice($productRow, newQuantity);
                        }

                        // محاسبه کل مبالغ
                        calculateTotals();
                    }
                }).fail(function() {
                    Swal.fire("خطا", "ارتباط با سرور برقرار نشد.", "error");
                }).always(function() {
                    $('.loader').hide ? $('.loader').hide() : null;
                });
            });

            // تابع برای آپدیت قیمت یک محصول خاص
            function updateProductPrice($productRow, quantity) {
                var basePrice = $productRow.data('base-price');
                var baseOff = $productRow.data('base-off');

                if (basePrice && quantity > 0) {
                    var totalItemPrice = basePrice * quantity;
                    var totalItemOff = baseOff * quantity;

                    // آپدیت نمایش قیمت برای این محصول
                    $productRow.find('.item-price').text($.number(totalItemPrice));
                    $productRow.find('.item-off').text($.number(totalItemOff));
                } else if (quantity === 0) {
                    // اگر تعداد صفر شد
                    $productRow.find('.item-price').text($.number(0));
                    $productRow.find('.item-off').text($.number(0));
                }
            }

            // تابع برای محاسبه کل مبالغ
            function calculateTotals() {
                var totalPrice = 0,
                    totalOff = 0,
                    totalQty = 0;

                $('#cart-products .cart-product').each(function() {
                    var $product = $(this);
                    var qty = parseInt($product.find('.quantity-input').val()) ||
                        parseInt($product.find('.count').val()) ||
                        parseInt($product.find('.count').text()) || 0;

                    // خواندن قیمت و تخفیف فعلی از نمایش
                    var price = parseInt($product.find('.item-price').text().replace(/,/g, '')) || 0;
                    var off = parseInt($product.find('.item-off').text().replace(/,/g, '')) || 0;

                    totalPrice += price;
                    totalOff += off;
                    totalQty += qty;
                });

                var total = totalPrice - totalOff;
                updateTotalDisplays(totalPrice, totalOff, total, totalQty);
            }

            // تابع برای آپدیت نمایش مقادیر کل
            function updateTotalDisplays(totalPrice, totalOff, total, totalQty) {
                $('#cart-info-price').attr('data-value', totalPrice).text($.number(totalPrice));
                $('#cart-info-off').text($.number(totalOff));
                $('#cart-info-total').attr('data-value', total).text($.number(total));
                $('#total').text($.number(total));
                $('.header-total-quantity, #cart_info-quantity').text(totalQty);
            }

            // Delete item
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var id = $btn.data('id');
                var model = $btn.data('model');
                var $productRow = $btn.closest('.cart-product');
                var quantity = parseInt($productRow.find('.count').val()) || parseInt($productRow.find(
                    '.count').text()) || 1;

                Swal.fire({
                    title: "آیا از حذف این محصول مطمئن هستید؟",
                    text: "این عملیات منجر به حذف محصول از سبد خرید شما خواهد شد.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "حذف",
                    confirmButtonColor: "#d33",
                    cancelButtonText: "انصراف",
                    dangerMode: true,
                }).then((result) => {
                    if (!result.isConfirmed) return;
                    $('.loader').show ? $('.loader').show() : null;

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('cart.deleteItem') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            model: model
                        },
                        success: function(data) {
                            if (data.status == "error") {
                                Swal.fire("خطا  در اجرای عملیات", data.message || "",
                                    "error");
                            } else if (data.status == "success") {
                                if (data.totals) {
                                    updateTotalsFromResponse(data.totals);
                                } else {
                                    // local fallback adjust
                                    var currentPrice = parseInt($('#cart-info-price')
                                        .text().replace(/,/g, '')) || 0;
                                    var currentOff = parseInt($('#cart-info-off').text()
                                        .replace(/,/g, '')) || 0;
                                    var price = parseInt($productRow.find('.item-price')
                                        .text().replace(/,/g, '')) || 0;
                                    var off = parseInt($productRow.find('.item-off')
                                        .text().replace(/,/g, '')) || 0;
                                    var quantity = parseInt($productRow.find('.count')
                                        .val()) || parseInt($productRow.find(
                                        '.count').text()) || 1;
                                    var newPrice = currentPrice - (price + off);
                                    var newOff = currentOff - off;
                                    var newTotal = newPrice - newOff;
                                    // alert(currentPrice);
                                    // alert(currentOff);
                                    // alert(price);
                                    // alert(off);
                                    // alert(quantity);
                                    // alert(newPrice);
                                    // alert(newOff);
                                    // alert(newTotal);
                                    $('#cart-info-price').attr('data-value', newPrice)
                                        .text($.number(newPrice));
                                    $('#cart-info-off').text($.number(newOff));
                                    $('#cart-info-total').attr('data-value', newTotal)
                                        .text($.number(newTotal));
                                    $('#total').text($.number(newTotal));
                                    var hq = parseInt($('.header-total-quantity')
                                        .text()) || 0;
                                    $('.header-total-quantity, #cart_info-quantity')
                                        .text(Math.max(0, hq - quantity));
                                }

                                $productRow.fadeOut(function() {
                                    $(this).remove();
                                });

                                // if no products left, show empty-cart UI (optional reload)
                                if ($('#cart-products .cart-product').length === 0) {
                                    location.reload();
                                }

                                Swal.fire({
                                    title: "عملیات با موفقیت انجام شد.",
                                    text: "محصول از سبد خرید شما حذف شد.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            }
                        },
                        error: function() {
                            Swal.fire("خطا", "ارتباط با سرور برقرار نشد.", "error");
                        },
                        complete: function() {
                            $('.loader').hide ? $('.loader').hide() : null;
                        }
                    });
                });
            });

            // Apply discount (right column)
            $('#saveDiscountCard').on('click', function(e) {
                e.preventDefault();
                var code = $('#code').val().trim();
                if (!code) {
                    Swal.fire("خطا", "لطفا ابتدا کد تخفیف را وارد کنید.", "error");
                    $('#code').addClass('is-invalid').focus();
                    return;
                }
                var sum = $('#cart-info-price').data('value') || parseInt($('#cart-info-price').text()
                    .replace(/,/g, '')) || 0;
                $.ajax({
                    type: 'POST',
                    url: "{{ route('cart.storeDiscountCard') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code,
                        sum: sum
                    },
                    success: function(data) {
                        if (data.res == "success") {
                            $('#discountCardRow').hide();
                            if ($('#discountCardInfo').length == 0) {
                                $('<div class="d-flex justify-content-between mb-2" id="discountCardInfo"><span>تخفیف ویژه</span><span>' +
                                        $.number(data.message) + ' تومان</span></div>')
                                    .insertAfter($('#discountCardRow'));
                            }
                            var total = parseInt($('#cart-info-total').attr('data-value')) ||
                                parseInt($('#cart-info-total').text().replace(/,/g, '')) || 0;
                            $('#cart-info-total').text($.number(total - data.message)).attr(
                                'data-value', total - data.message);
                            $('#total').text($.number(total - data.message));
                            $('#discount-success').removeClass('d-none');
                            Swal.fire("عملیات با موفقیت انجام شد.", "کد تخفیف اعمال شد .",
                                "success");
                            $('#code').val('');
                        } else if (data.res == "error") {
                            Swal.fire("خطا در اجرای عملیات", data.message, "error");
                        }
                    },
                    error: function() {
                        Swal.fire("خطا", "ارتباط با سرور برقرار نشد.", "error");
                    }
                });
            });

            // Apply discount (left column duplicate button)
            $('#applyLeft').on('click', function() {
                $('#code').val($('#codeLeft').val());
                $('#saveDiscountCard').trigger('click');
            });

        });
    </script>
@endsection
