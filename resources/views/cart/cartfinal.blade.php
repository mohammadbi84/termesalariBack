@extends('shop.layouts.master')
@section('title', __('cart.checkout_final.title'))
@section('head')
    <link href="{{ asset('/storetemplate/dist/css/cart.css') }}" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/iCheck/all.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('../storetemplate/plugins/select2/select2.min.css') }}">
    <style type="text/css">
        #TopMenuCartIcone {
            display: none;
        }
    </style>
    <link href="{{ asset('/hometemplate/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/custom-style.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/termehsalari.css') }}">
@endsection
@section('content')
    <div class="container my-4 px-3" style="margin-top: 120px !important;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><span>{{ __('cart.checkout_final.recipient_card_title') }}</span></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body product-header-info cart-container row">
                <div class="col-md-3 col-sm-12 mb-4">
                    <b>{{ __('cart.checkout_final.recipient_fields.name') }}</b> {{ $recipient->name }}
                </div>
                <div class="col-md-3 col-sm-12 mb-4">
                    <b>{{ __('cart.checkout_final.recipient_fields.family') }}</b> {{ $recipient->family }}
                </div>
                <div class="col-md-3 col-sm-12 mb-4">
                    <b>{{ __('cart.checkout_final.recipient_fields.national_code') }}</b> {{ $recipient->nationalCode }}
                </div>
                <div class="col-md-3 col-sm-12 mb-4">
                    <b>{{ __('cart.checkout_final.recipient_fields.mobile') }}</b> {{ $recipient->mobile }}
                </div>
                <div class="col-md-9 col-sm-12 mb-4">
                    <b>{{ __('cart.checkout_final.recipient_fields.address') }}</b> {{ $recipient->city->name }} -
                    {{ $recipient->subcity->name }} - {{ $recipient->address }} -
                    {{ __('cart.checkout_final.recipient_fields.house_number') }} {{ $recipient->houseId }}
                </div>
                <div class="col-md-3 col-sm-12 mb-4">
                    <b>{{ __('cart.checkout_final.recipient_fields.postal_code') }}</b> {{ $recipient->zipcode }}
                </div>
            </div>
            {{-- </div> --}}


            {{-- <div class="card"> --}}
            <div class="card-header">
                <h3 class="card-title"><span>{{ __('cart.checkout_final.invoice_card_title') }}</span></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body product-header-info cart-container row">
                @if (isset($list) and count($list) > 0)
                    <div class="cart-products col-12">
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
                                        $price = $price + ($p->price - $p->offPrice) * $list['quantities'][$key];
                                        $off = $off + $cartItemOff * $list['quantities'][$key];
                                    } elseif ($p->offType == 'درصد') {
                                        $cartItemPrice = $p->price - $p->price * ($p->offPrice / 100);
                                        $cartItemOff = $p->price * ($p->offPrice / 100);
                                        $price = $price + ($p->price - $cartItemOff) * $list['quantities'][$key];
                                        $off = $off + $cartItemOff * $list['quantities'][$key];
                                    }
                                } else {
                                    $cartItemPrice = $p->price;
                                    $price = $price + $p->price * $list['quantities'][$key];
                                }

                            @endphp
                            <div class="col-12 cart-product ">
                                <div class="row">
                                    <div class="image-box col-md-2">

                                        <img class="image-product w-100"
                                            src="{{ asset('storage/images/thumbnails/' . $product->images->first()->name) }}"
                                            alt="{{ $product->title }}">

                                    </div>

                                    <div class="info-product col-md-9">
                                        <div class="col-md-9 float-right">
                                            <h3>{{ $product->category->title }} {{ __('products.design') }}
                                                {{ $product->color_design->design->title }} {{ __('products.color') }}
                                                {{ $product->color_design->color->color }}</h3>
                                            <h3>{{ __('products.product_row.code_label') }} {{ $product->code }}</h3>
                                            <h3>{{ __('cart.product_row.quantity_label') ?? 'تعداد :' }}
                                                {{ $list['quantities'][$key] }}</h3>
                                            <h4>{{ __('products.product_row.guarantee_text') }}</h4>
                                        </div>

                                        <div class="price-product col-md-3 float-left">
                                            @if ($cartItemOff > 0)
                                                <del>
                                                    <span id="price">{{ number_format($p->price) }}</span>
                                                    <small>{{ $p->local }}</small>
                                                </del>
                                                <div style="color: red">
                                                    <small>{{ __('cart.checkout_final.summary.discount_label') }}</small>
                                                    <span id="offprice">{{ number_format($cartItemOff) }}</span>
                                                    <small>{{ $p->local }}</small>
                                                </div>
                                                <span>{{ number_format($cartItemPrice) }}</span>
                                                <small>{{ $p->local }}</small>
                                            @else
                                                <span id="price">{{ number_format($cartItemPrice) }}</span>
                                                <small>{{ $p->local }}</small>
                                            @endif
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 total-row">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 text-center pt-4 mb-2">
                                    <a href="{{ route('cart.cartlevel2') }}"
                                        class="btn btn-flat btn-sm btn-secondary">{{ __('cart.checkout_final.buttons.back') }}</a>
                                    {{-- </div>
							<div class="col-md-1 col-sm-12"> --}}
                                    <a href="{{ route('payment.create') }}"
                                        class="btn btn-flat btn-sm btn-success">{{ __('cart.checkout_final.buttons.confirm_and_pay') }}</a>
                                </div>
                                <div class="col-md-2 col-sm-12 text-center">
                                    <small>{{ __('cart.checkout_final.summary.payment_method') }}</small>
                                    <p>{{ $payType }}</p>
                                </div>
                                <div class="col-md-2 col-sm-12 text-center">
                                    <small>{{ __('cart.checkout_final.summary.shipping_method') }} {{ $post->title }}
                                    </small>
                                    <p>{{ __('cart.checkout_final.summary.shipping_cost') }}
                                        {{ number_format($post->price) }} {{ __('cart.order_summary.currency') }}</p>
                                </div>
                                @if (session()->has('discountCardPrice'))
                                    <div class="col-md-2 col-sm-12 text-center">
                                        <small>{{ __('cart.checkout_final.summary.special_discount') }}</small>
                                        <p>{{ number_format(session('discountCardPrice')) }} {{ __('cart.order_summary.currency') }}</p>
                                    </div>
                                @endif
                                <div class="col-md-2 col-sm-12 text-center">
                                    <small>{{ __('cart.checkout_final.summary.payable_amount') }} </small>
                                    <p style="padding-top: 5px;color: #ef3a4e;">
                                        <b id="total">
                                            @php
                                                if (session()->has('discountCardPrice')) {
                                                    print number_format(
                                                        $price +
                                                            $off +
                                                            $post->price -
                                                            $off -
                                                            session('discountCardPrice'),
                                                    );
                                                } else {
                                                    print number_format($price + $off + $post->price - $off);
                                                }
                                            @endphp
                                            {{-- {{ number_format(($price + $off + $post->price) - $off) }} --}}
                                        </b> <small> {{ __('cart.order_summary.currency') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
@endsection


{{-- @extends('store-layout')

@push('link')
    <link href="{{ asset('/storetemplate/dist/css/cart.css') }}" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/iCheck/all.css') }}">
    <style type="text/css">
        .table td {
            border-top: 0 !important;
        }

        #TopMenuCartIcone {
            display: none;
        }
    </style>
@endpush

@section('title', 'ادامه فرایند خرید - تایید اطلاعات')

@section('main-content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><span>اطلاعات گیرنده</span></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body product-header-info cart-container row">
            <div class="col-md-3 col-sm-12 mb-4">
                <b>نام : </b> {{ $recipient->name }}
            </div>
            <div class="col-md-3 col-sm-12 mb-4">
                <b>نام خانوادگی : </b> {{ $recipient->family }}
            </div>
            <div class="col-md-3 col-sm-12 mb-4">
                <b>کدملی : </b> {{ $recipient->nationalCode }}
            </div>
            <div class="col-md-3 col-sm-12 mb-4">
                <b>شماره موبایل : </b> {{ $recipient->mobile }}
            </div>
            <div class="col-md-9 col-sm-12 mb-4">
                <b>آدرس : </b> {{ $recipient->city->name }} - {{ $recipient->subcity->name }} - {{ $recipient->address }}
                - پلاک {{ $recipient->houseId }}
            </div>

            <div class="col-md-3 col-sm-12 mb-4">
                <b>کد پستی : </b> {{ $recipient->zipcode }}
            </div>
        </div>


        <div class="card-header">
            <h3 class="card-title">
                <span>صورت حساب</span>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body product-header-info cart-container row">
            @if (isset($list) and count($list) > 0)
                <div class="cart-products col-12">
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
                                    $price = $price + ($p->price - $p->offPrice) * $list['quantities'][$key];
                                    $off = $off + $cartItemOff * $list['quantities'][$key];
                                } elseif ($p->offType == 'درصد') {
                                    $cartItemPrice = $p->price - $p->price * ($p->offPrice / 100);
                                    $cartItemOff = $p->price * ($p->offPrice / 100);
                                    $price = $price + ($p->price - $cartItemOff) * $list['quantities'][$key];
                                    $off = $off + $cartItemOff * $list['quantities'][$key];
                                }
                            } else {
                                $cartItemPrice = $p->price;
                                $price = $price + $p->price * $list['quantities'][$key];
                            }

                        @endphp
                        <div class="col-12 cart-product ">
                            <div class="row">
                                <div class="image-box col-md-2">

                                    <img class="image-product w-100"
                                        src="{{ asset('storage/images/thumbnails/' . $product->images->first()->name) }}"
                                        alt="{{ $product->title }}">

                                </div>

                                <div class="info-product col-md-9">
                                    <div class="col-md-9 float-right">
                                        <h3>{{ $product->category->title }} طرح
                                            {{ $product->color_design->design->title }} رنگ
                                            {{ $product->color_design->color->color }}</h3>
                                        <h3>کد محصول : {{ $product->code }}</h3>
                                        <h3>تعداد : {{ $list['quantities'][$key] }} </h3>
                                        <h4>گارانتی اصالت و سلامت فیزیکی کالا</h4>
                                    </div>

                                    <div class="price-product col-md-3 float-left">
                                        @if ($cartItemOff > 0)
                                            <del>
                                                <span id="price">{{ number_format($p->price) }}</span>
                                                <small>{{ $p->local }}</small>
                                            </del>
                                            <div style="color: red">
                                                <small> تخفیف</small>
                                                <span id="offprice">{{ number_format($cartItemOff) }}</span>
                                                <small>{{ $p->local }}</small>
                                            </div>
                                            <span>{{ number_format($cartItemPrice) }}</span>
                                            <small>{{ $p->local }}</small>
                                        @else
                                            <span id="price">{{ number_format($cartItemPrice) }}</span>
                                            <small>{{ $p->local }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 total-row">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-center pt-4 mb-2">
                                <a href="{{ route('cart.cartlevel2') }}" class="btn btn-flat btn-sm btn-secondary">بازگشت
                                    به مرحله قبل</a>

                                <a href="{{ route('payment.create') }}" class="btn btn-flat btn-sm btn-success">تائید
                                    اطلاعات و پرداخت</a>
                            </div>
                            <div class="col-md-2 col-sm-12 text-center">
                                <small>روش پرداخت </small>
                                <p>{{ $payType }}</p>
                            </div>
                            <div class="col-md-2 col-sm-12 text-center">
                                <small>ارسال به صورت {{ $post->title }} </small>
                                <p>هزینه ارسال : {{ number_format($post->price) }} تومان</p>
                            </div>
                            @if (session()->has('discountCardPrice'))
                                <div class="col-md-2 col-sm-12 text-center">
                                    <small>تخفیف ویژه</small>
                                    <p>{{ number_format(session('discountCardPrice')) }} تومان</p>
                                </div>
                            @endif
                            <div class="col-md-2 col-sm-12 text-center">
                                <small>مبلغ قابل پرداخت </small>
                                <p style="padding-top: 5px;color: #ef3a4e;">
                                    <b id="total">
                                        @php
                                            if (session()->has('discountCardPrice')) {
                                                print number_format(
                                                    $price + $off + $post->price - $off - session('discountCardPrice'),
                                                );
                                            } else {
                                                print number_format($price + $off + $post->price - $off);
                                            }
                                        @endphp
                                    </b> <small> تومان</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection --}}
