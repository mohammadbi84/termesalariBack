@extends('store-layout')

@push('link')
	<link rel="stylesheet" type="text/css" href="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.css')}}">
	<style type="text/css">
		#TopMenuCartIcone{
			display: none;
		}
		.datepicker-grid-view .header {
		    background-color: unset !important;
		    height: unset !important;
		    padding: unset !important;
		}
	</style>
@endpush

@section('title','ثبت اطلاعات رسید پرداخت')
@php
	if(session()->has('discountCardPrice'))
		$sumPayPrice = session('sumPayPrice') - session('discountCardPrice');
	else
		$sumPayPrice = session('sumPayPrice');
@endphp
@section('main-content')
	<section class="content">
      	<div class="row">
        	<div class="col-12">
	        	@if(session()->has('success') or session()->has('danger'))
		  			<div class="alert  @if(session()->has('success')) alert-success @elseif(session()->has('danger')) alert-danger @endif  alert-dismissible">
		              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		              <h5><i class="icon fa fa-check"></i> توجه!</h5>
		              @if(session()->has('success'))
		              	{{session('success')}}
		              @elseif(session()->has('danger'))
						{{session('danger')}}
		              @endisset
		            </div>
		      	@endif
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">
							<span>ثبت اطلاعات رسید پرداخت</span>
						</h4>
					</div>
					<!-- /.card-header -->
					<div class="card-body product-header-info cart-container row">
						<div class="m-auto col-md-6 col-sm-12">
							<form method="post" action="{{ route('payment.store') }}" role="form">
								@csrf

								<div class="form-group">
						    		<label for="tracing_code">شماره ارجاع یا شماره پیگیری</label>
						      		<input type="text" name="tracing_code" id="tracing_code" class="form-control @error('tracing_code') is-invalid @enderror" placeholder="" value="{{old('tracing_code')}}" autofocus="autofocus">
						      		@error('tracing_code')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
						    	</div>

						    	<div class="form-group">
							    	<label for="date">تاریخ و ساعت (طبق اطلاعات ثبت شده بر روی رسید پرداخت)</label>
							      	<input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="" value="{{ old('date') }}"  autocomplete="off" >
							      	{{-- Verta(old('date'))->datetime()->format('Y-m-d') --}}
							      	@error('date')
									    <div class="invalid-feedback">{{ $message }}</div>
									@enderror
							    </div>

								<div class="form-group">
						    		<label for="price_cardPay">مبلغ پرداختی</label>
						      		<input type="text" readonly name="price_cardPay" id="price_cardPay" class="form-control @error('price_cardPay') is-invalid @enderror" placeholder="" value="{{old('price_cardPay', $sumPayPrice) }}">
						      		@error('price_cardPay')
									    <div class="invalid-feedback">{{ $message }}</div>
									@enderror
						    	</div>

				    			<input type="submit" class="btn btn-primary btn-flat" value="ثبت اطلاعات">
				    			<a href="{{ route('cart.index') }}" class="btn btn-flat btn-secondary">بازگشت به سبد خرید</a>

							</form>
						</div>
						

					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('js')
	<script src="{{asset('/storetemplate/plugins/datepicker-master/persian-date.min.js')}}"></script>
    <script src="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.js')}}"></script>

	<script type="text/javascript">
		$(function () {
			dateValue = $('#date').val();
			pd = $('#date').pDatepicker({
	        	onlySelectOnDate : true ,
	        	autoClose : true ,
	        	responsive : true ,
	        	initialValueType: 'gregorian',
	        	persianDigit: false,
				format: 'YYYY/MM/DD H:m:s',
				defaultDate:"",
	        	timePicker : {
	        		"enabled" : true ,
	        	} ,
	        	monthPicker : {
	        		"enabled" : true ,
	        		"titleFormat" : "YYYY" ,
	        	} ,
	        	yearPicker : {
	        		"enabled" : true ,
	        		"titleFormat" : "YYYY" ,
	        	} ,
	        });
	        
	        $('#date').val(dateValue);
	        @if(old('date'))
	        	$('#date').val("{{ old('date') }}");
	        @endif



		});//end
	</script>
@endpush