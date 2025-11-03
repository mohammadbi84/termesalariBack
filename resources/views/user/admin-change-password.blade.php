@extends('admin-layout')

@section('title','تغییر رمز عبور')

@push('link')

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

				<div class="card">
		            <div class="card-header">
		              <h3 class="card-title float-right"><span>تغییر رمز عبور</span></h3>
		            </div>
		            <!-- /.card-header -->
		            <div class="card-body">
		            	<div class="row">
							<form role="form" method="post" action="{{ route('user.updatePassword') }}" class="card col-6 m-auto p-3">
								@csrf
								<div class="form-group">
					            	<label for="currentPassword" class="">رمز عبور فعلی</label>
									<input type="password" name="currentPassword" id="currentPassword" class="form-control @error('currentPassword') is-invalid @enderror" placeholder="" value="{{old('currentPassword')}}" autofocus="autofocus">
									@error('currentPassword')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
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
		            </div>
		            <!-- /.card-body -->
	          	</div>
	          <!-- /.card -->
	       	</div>
	        <!-- /.col -->
	    </div>
	    <!-- /.row -->
	</section>
<!-- /.content -->
@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script>
	<script>
		$(function () {

		})
	</script>
@endpush