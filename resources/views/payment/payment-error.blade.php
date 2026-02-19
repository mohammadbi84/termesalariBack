{{-- @extends('store-layout')
@section('title', 'فاکتور خرید')

@section('main-content')

    <section class="content">
        <div class="row">
            <div class="col-12 text-center">
                <img src="{{ asset('/storetemplate/dist/img/payment-error.jpg') }}" alt="payment error" class="w-25 mb-2">
                <h2 class="text-danger mt-4 mb-4">متاسفم، تراکنش ناموفق بود.</h2>
                @isset($error)
                    <h1 class="text-danger mt-4 mb-4">{{ $error }}</h1>
                @endisset

            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4 text-left">
                <a href="{{ route('cart.index') }}" class="btn btn-flat btn-danger ">بازگشت به سبد خرید</a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4 text-right">
                <a href="{{ route('homeStore.index') }}" class="btn btn-flat btn-success ">بازگشت به فروشگاه</a>
            </div>
        </div>
    </section>
@endsection --}}


@extends('shop.layouts.master')
@section('title', 'فاکتور خرید')
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
        <section class="content">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="{{ asset('/storetemplate/dist/img/payment-error.jpg') }}" alt="payment error"
                        class="w-25 mb-2">
                    <h2 class="text-danger mt-4 mb-4">متاسفم، تراکنش ناموفق بود.</h2>
                    @isset($error)
                        <h1 class="text-danger mt-4 mb-4">{{ $error }}</h1>
                    @endisset

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 mb-4 d-flex justify-content-center align-items-center gap-5">
                    <a href="{{ route('cart.index') }}" class="btn btn-flat btn-danger ">بازگشت به سبد خرید</a>
                    <a href="{{ route('homeStore.index') }}" class="btn btn-flat btn-success ">بازگشت به فروشگاه</a>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
@endsection
