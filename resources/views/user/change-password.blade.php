@extends("user.user-layout")

@push('link')
	<style type="text/css">
		
	</style>
@endpush

@section("card-title","تغییر رمز عبور")
	
@section("user-content")
	{{-- @isset($success)
		<div class="alert alert-success alert-dismissible">
          	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          	<i class="icon fa fa-check"></i>  {{ $success }}
        </div>
	@endisset --}}
	<div class="row">
        <div class="col-12">
        	@if(session()->has('success') or session()->has('danger'))
	  			<div class="alert @if(session()->has('success')) alert-success @elseif(session()->has('danger')) alert-danger @endif  alert-dismissible">
	            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	              	<h5><i class="icon fa fa-check"></i> توجه!</h5>
	              	@if(session()->has('success'))
	              		{{ session('success') }}
	              	@elseif(session()->has('danger'))
						{{ session('danger') }}
	              	@endisset
	            </div>
	      	@endif
	    </div>
		<form role="form" method="post" action="{{ route('user.updatePassword') }}" class="card col-6  m-auto p-3" id="">
			@csrf
			<div class="form-group">
            	<label for="currentPassword" class="">رمز عبور فعلی</label>
				<input type="password" name="currentPassword" id="currentPassword" class="form-control @error('currentPassword') is-invalid @enderror" placeholder="" value="{{old('currentPassword')}}" autofocus="autofocus">
				@error('currentPassword')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror

				{{--@isset($error)
					<div class="invalid-feedback d-block">{{ $error }}</div>
				@endisset--}}
			</div>

			<div class="form-group">
            	<label for="password" class="">رمز عبور جدید</label>
				<input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="" value="{{old('password')}}" autofocus="autofocus">
				@error('password')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
			</div>

			<div class="form-group">
            	<label for="password_confirmation" class="">تکرار رمز عبور  جدید</label>
				<input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="" value="{{old('password_confirmation')}}" autofocus="autofocus">
				@error('password_confirmation')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
			</div>
				
			<div class="card-footer" style="background-color: transparent;">
				<button type="submit" id="updatePassword" class="btn btn-primary">ذخیره</button>
			</div>

			
		</form>
	</div>
	
@endsection


@push('js')
@endpush