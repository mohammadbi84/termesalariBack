@extends('admin-layout')

@section('title','پنل مدیریت | ارسال خبرنامه جدید')

@push('link')
  	<style type="text/css">
  		.ck-editor__editable {
		    min-height: 200px !important;
		    direction: rtl;
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

				<div class="card">
		            <div class="card-header">
		              <h3 class="card-title float-right"><span>ارسال خبرنامه جدید</span></h3>
		            </div>

		            <div class="card-body">
		            	<form action="{{ route('newsletter.sendMail') }}" method="post" >
		            		@csrf
		            		<div class="form-group">
			                  <input class="form-control" name="subject" id="subject" placeholder="عنوان ایمیل ">
			                </div>
			                <div class="form-group">
			                    <textarea name="compose" id="compose" class="form-control" style="height: 300px;direction: rtl;"></textarea>
			                </div>
			                <button type="submit" name="send" id="send" class="btn btn-flat btn-primary">ارسال ایمیل به همه اعضا</button>
			                <a href="{{ route('newsletter.index') }}" class="btn btn-flat btn-secondary">بازگشت</a>
		            	</form>
		            	
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
	<script src="{{asset('/storetemplate/plugins/ckeditor/ckeditor.js')}}"></script>
<script>
	$(function () {
		CKEDITOR.replace( 'compose' );
	})
</script>
@endpush