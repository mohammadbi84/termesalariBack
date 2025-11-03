@extends('admin-layout')

@section('title','پنل مدیریت | ویرایش طرح ')

@push('link')

@endpush

@section('main-content')
	<section class="content">
		<div class="row">
	        
			<div class="card col-md-12 col-sm-12">
				<div class="card-header">
					<div class="card-title">
						<span>ویرایش طرح </span>
					</div>
				</div>
				<div class="card-body">
					<form class="form" role="form" action="{{ route('design.update',[$design]) }}" method="post" enctype="multipart/form-data">
						@csrf
						@method('put')
		                <div class="form-group">
							<label for="title">عنوان طرح</label>
							<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="لطفا عنوان طرح را وارد کنید." value="{{ old('title',$design->title) }}">
							@error('title')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="countOfColor">تعداد رنگ بافت</label>
							<input type="text" name="countOfColor" id="countOfColor" class="form-control @error('countOfColor') is-invalid @enderror" placeholder="لطفا تعداد رنگ بافت طرح را به صورت عددی وارد کنید." value="{{ old('countOfColor',$design->countOfColor) }}">
							@error('countOfColor')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						<div class="form-group @error('active') is-invalid @enderror">
							<label for="active">وضعیت</label>
		                  	<select name="active" id="active" class="form-control" style="width: 100%;">
			                  		<option value="1" @if(old('active',$design->active) == '1') selected @endif >فعال</option>

			                  		<option value="0" @if(old('active',$design->active) == '0') selected @endif >غیرفعال</option>
		                  	</select>
		                  	@error('active')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
		                </div>

						<button type="submit" class="btn btn-flat btn-primary">ویرایش اطلاعات</button>
			          	<a href="{{ route('design.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('js')

	<script>
		$(function () {

		})//End
	</script>
@endpush
