@extends('admin-layout')

@section('title','پنل مدیریت | ویرایش  کد تخفیف')

@push('link')
	<link rel="stylesheet" type="text/css" href="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.css')}}">
	<style type="text/css">
		.datepicker-grid-view .header {
		    background-color: unset !important;
		    height: unset !important;
		    padding: unset !important;
		}
	</style>
@endpush

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
	      	</div>
			<div class="card col-md-12 col-sm-12">
				<div class="card-header">
					<div class="card-title">
						<span>ویرایش  کد تخفیف</span>
					</div>
				</div>
				<div class="card-body">
					{{-- {{ dd($errors->all()) }} --}}
					<form class="form" role="form" action="{{ route('discountCard.update',[$discountCard]) }}" method="post">
						@csrf
						@method('put')
						

						<div class="row">
							<div class="col-4">
								<div class="form-group">
				                	<label for="code">کد تخفیف</label>
									<input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" placeholder="کد تخفیف را وارد کنید ." value="{{ old('code', $discountCard->code) }}" >
									@error('code')
									    <div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>

							<div class="col-4">
								<div class="form-group">
				                	<label for="type_scope">نوع کد تخفیف</label>
				                	<select name="type_scope" id="type_scope" autofocus="autofocus" class="form-control @error('type_scope') is-invalid @enderror">
				                		<option value="private" @if(old('type_scope',$discountCard->type_scope) == 'private') selected @endif>خصوصی</option>
				                		<option value="public" @if(old('type_scope',$discountCard->type_scope) == 'public') selected @endif>عمومی</option>
				                	</select>
									@error('type_scope')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>
							</div>

							<div class="col-4">
								<div class="form-group">
				                	<label for="count_usable">تعداد دفعات استفاده</label>
									<input type="text" name="count_usable" id="count_usable" class="form-control @error('count_usable') is-invalid @enderror" placeholder="تعداددفعات استفاده را وارد کنید ." value="{{old('count_usable',$discountCard->count_usable)}}" disabled>
									@error('count_usable')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-6">
								<div class="form-group">
				                	<label for="type_amount">نحوه اعمال تخفیف</label>
				                	<select name="type_amount" id="type_amount" class="form-control @error('type_amount') is-invalid @enderror">
				                		<option value="percent" @if(old('type_amount', $discountCard->type) == 'percent') selected @endif>درصدی</option>
				                		<option value="price" @if(old('type_amount', $discountCard->type) == 'price') selected @endif>مقدار ثابت</option>
				                	</select>
									@error('type_amount')
									    <div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
				                	<label for="amount">میزان تخفیف</label>
									<input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="مقدار تخفیف را وارد کنید ." value="{{ old('amount', $discountCard->amount) }}" >
									@error('amount')
									    <div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6">
								<div class="form-group">
				                	<label for="start_date">تاریخ اعمال</label>
									<input type="text" name="start_date" id="start_date" class="form-control date @error('start_date') is-invalid @enderror" placeholder="روز و ساعت مورد نظر را انتخاب کنید ." value="{{ old('start_date', Verta($discountCard->start_date)->datetime()->format('Y-m-d H:m:s')) }}" autocomplete="off">
									@error('start_date')
									    <div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
				                	<label for="expire_date">تاریخ انقضا</label>
									<input type="text" name="expire_date" id="expire_date" class="form-control date @error('expire_date') is-invalid @enderror" placeholder="روز و ساعت مورد نظر را انتخاب کنید ." value="{{ old('expire_date', Verta($discountCard->expire_date)->datetime()->format('Y-m-d H:m:s')) }}" autocomplete="off">
									@error('expire_date')
									    <div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>

						<button type="submit" class="btn btn-flat btn-primary">ویرایش اطلاعات</button>
						<a href="{{ route('discountCard.index') }}" class="btn btn-flat btn-secondary">بازگشت</a>

					</form>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('js')
	<script src="{{asset('/storetemplate/plugins/datepicker-master/persian-date.min.js')}}"></script>
    <script src="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.js')}}"></script>

	<script>
		$(function () {
			
			pd = $('.date').pDatepicker({
	        	onlySelectOnDate : true ,
	        	autoClose : true ,
	        	responsive : true ,
	        	initialValueType: 'gregorian',
	        	persianDigit: false,
				format: 'YYYY/MM/DD H:m:s',
				// defaultDate:"",
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
			var start_date = $('#start_date').val();
			var expire_date = $('#expire_date').val();
	        @if(old('expire_date') || old('start_date'))
	        	start_date = "{{ old('start_date') }}";
				expire_date = "{{ old('expire_date') }}";
	        @endif
			$('#start_date').val(start_date);
			$('#expire_date').val(expire_date);
//----------------------------------------------------------
			if($.trim($('#type_scope').val())=='public')
				$('#count_usable').removeAttr('disabled');

			$('#type_scope').change(function(){
				$('#count_usable').val("");
				if($.trim($(this).children(":selected").attr('value')) == 'public')
					$('#count_usable').removeAttr('disabled');
				else
					$('#count_usable').attr('disabled','disabled');
			});
	        
		});

	</script>
@endpush