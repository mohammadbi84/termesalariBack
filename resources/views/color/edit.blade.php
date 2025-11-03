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
							<input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" placeholder="لطفا عنوانرنگ را وارد کنید." value="{{ old('color',$color->color) }}">
							@error('color')
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
