@extends('store-layout')
@section('title','فاکتور خرید')

@section('main-content')

	<section class="content">
      	<div class="row">
        	<div class="col-12 text-center">
        		<img src="{{ asset('/storetemplate/dist/img/payment-error.jpg') }}" alt="payment error" class="w-25 mb-2" >
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
@endsection