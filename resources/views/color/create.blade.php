@extends('admin-layout')

@section('title','پنل مدیریت | ثبت رنگ جدید')

@push('link')

@endpush

@section('main-content')
	<section class="content">
		<div class="row">
	        
			<div class="card col-md-12 col-sm-12">
				<div class="card-header">
					<div class="card-title">
						<span>ثبت رنگ جدید</span>
					</div>
				</div>
				<div class="card-body">
					<form class="form" role="form" action="{{ route('color.store') }}" method="post" enctype="multipart/form-data">
						@csrf
		                <div class="form-group">
							<label for="color">عنوان رنگ</label>
							<input type="text" name="color[]" id="color1" class="form-control @error('color') is-invalid @enderror" placeholder="لطفا عنوان رنگ را وارد کنید." value="{{old('color')}}">
							@error('color')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="color">عنوان رنگ</label>
							<input type="text" name="color[]" id="color1" class="form-control @error('color') is-invalid @enderror" placeholder="لطفا عنوان رنگ را وارد کنید." value="{{old('color')}}">
							@error('color')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="color">عنوان رنگ</label>
							<input type="text" name="color[]" id="color1" class="form-control @error('color') is-invalid @enderror" placeholder="لطفا عنوان رنگ را وارد کنید." value="{{old('color')}}">
							@error('color')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						
						<button type="submit" class="btn btn-flat btn-primary">ثبت اطلاعات</button>
			          	<a href="{{ route('color.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
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
