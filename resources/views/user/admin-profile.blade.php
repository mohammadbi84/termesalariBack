@extends("admin-layout")

@push('link')
	{{-- <link rel="stylesheet" type="text/css" href="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/select2/select2.min.css')}}">
	<style type="text/css">

		.datepicker-grid-view .header {
		    background-color: unset !important;
		    height: unset !important;
		    padding: unset !important;
		}

	</style> --}}
@endpush

@section("main-content")
{{-- {{ $errors->first() }} --}}
	<section class="content">
	    <div class="row">
	        <div class="col-12">

				<div class="card">
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
		            <div class="card-header">
		              <h3 class="card-title float-right"><span>ویرایش حساب کاربری</span></h3>
		            </div>
		            <!-- /.card-header -->
		            <div class="card-body">
		            	<form class="" id="" role="form" action="{{route('user.adminProfileStore',[Auth::user()])}}" method="POST">
							@csrf
							@method('put')
							<div class="form-row">
							    <div class="form-group col-md-6">
						    		<label for="name">نام</label>
						      		<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{old('name' , Auth::user()->name)}}" autofocus="autofocus">
						      		@error('name')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
						    	</div>

								<div class="form-group col-md-6">
						    		<label for="family">نام خانوادگی</label>
						      		<input type="text" name="family" id="" class="form-control @error('family') is-invalid @enderror" placeholder="" value="{{old('family' , Auth::user()->family)}}" >
						      		@error('family')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
						    	</div>
							    	  	
							</div>
					    	<input type="submit" class="btn btn-primary btn-flat" id="" name="" value="ثبت اطلاعات">
						</form>
		            </div>
		        </div>
		    </div>
		</div>
	</section>

@endsection

@push('js')
    {{-- <script src="{{asset('/storetemplate/plugins/datepicker-master/persian-date.min.js')}}"></script>
    <script src="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.js')}}"></script>
     --}}<!-- Select2 -->
	<script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            
            

        })//end
    </script>



@endpush