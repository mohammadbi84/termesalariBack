@extends('admin-layout')

@section('title','پنل مدیریت | ویرایش رنگ')

@push('link')

@endpush

@section('main-content')
	<section class="content">
		<div class="row">

			<div class="card col-md-12 col-sm-12">
				<div class="card-header">
					<div class="card-title">
						<span>ویرایش رنگ</span>
					</div>
				</div>
				<div class="card-body">
					<form class="form" role="form" action="{{ route('color.update',[$color]) }}" method="post" enctype="multipart/form-data">
						@csrf
						@method('put')
		                <div class="form-group">
							<label for="color">عنوان رنگ</label>
							<input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" placeholder="لطفا عنوان رنگ را وارد کنید." value="{{ old('color',$color->color) }}">
							@error('color')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>
		                <div class="form-group">
							<label for="e_color">عنوان انگلیسی رنگ</label>
							<input type="text" name="e_color" id="e_color" class="form-control @error('e_color') is-invalid @enderror" placeholder="لطفا عنوان انگلیسی رنگ را وارد کنید." value="{{ old('e_color',$color->e_color) }}">
							@error('e_color')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>
		                <div class="form-group">
							<label for="ar_color">عنوان عربی رنگ</label>
							<input type="text" name="ar_color" id="ar_color" class="form-control @error('ar_color') is-invalid @enderror" placeholder="لطفا عنوان انگلیسی رنگ را وارد کنید." value="{{ old('ar_color',$color->ar_color) }}">
							@error('ar_color')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>
						<button type="submit" class="btn btn-flat btn-primary">ویرایش اطلاعات</button>
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
