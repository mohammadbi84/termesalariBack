@extends('admin-layout')

@section('title',' مشتری جدید')

@push('link')
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css')}}" media="all" >
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css')}}" media="all" >
	<!-- Select2 -->
  	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/select2/select2.min.css')}}">
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

			<div class="card col-md-10 col-sm-12">
				<div class="card-header">
					<div class="card-title"><span>مشتری جدید</span></div>
				</div>
				<form class="form" role="form" action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
					<div class="card-body">

						@csrf
		                <div class="form-group">
							<label for="title">عنوان</label>
							<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="لطفا عنوان  مشتری را وارد کنید." value="{{old('title')}}" maxlength="100">
							@error('title')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						<div class="form-group @error('image') is-invalid @enderror">
				            <label for="image">انتخاب تصویر </label>
							<div class="file-loading">
							    <input id="image" name="image" type="file" multiple data-browse-on-zone-click="true" data-show-upload="true" data-show-caption="true" data-upload-url="#">
							</div>
							@error('image')
								<div class="invalid-feedback d-block">{{$message}}</div>
							@enderror
				        </div>
					</div>
					<div class="card-footer">
			          <button type="submit" class="btn btn-flat btn-primary">ارسال</button>
			          <a href="{{ route('client.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
			        </div>
				</form>
			</div>
		</div>
	</section>
@endsection

@push('js')
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/fileinput.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/piexif.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/purify.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/locales/fa.js')}}"></script>
	<!-- Select2 -->
	<script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
	<script>
	$(function () {

		$("#image").fileinput({
	        enableResumableUpload: true,
	        allowedFileTypes: ["image"],
	        allowedFileExtensions: ["jpg", "png"],
	        browseLabel: "انتخاب تصویر ",
	        maxFileCount: 1,
	        theme: 'fas',
	        showUpload: false,
	        showPause :false,
	        // browseIcon: "<i class=\"fas fa-trash\"></i> ",
	        browseClass: "btn btn-primary btn-block",
	        showCaption: true,
	        // showRemove: true,
	        rtl: true,
	        required: true,
	        language: "fa",
	     	//    previewFileIcon: '<i class="fas fa-file"></i>',
		    // allowedPreviewTypes: null, // set to empty, null or false to disable preview for all types
		    // previewFileIconSettings: {
		    //     'docx': '<i class="fas fa-file-word text-primary"></i>',
		    //     'xlsx': '<i class="fas fa-file-excel text-success"></i>',
		    //     'pptx': '<i class="fas fa-file-powerpoint text-danger"></i>',
		    //     'jpg': '<i class="fas fa-file-image text-warning"></i>',
		    //     'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
		    //     'zip': '<i class="fas fa-file-archive text-muted"></i>',
		    // },
	        layoutTemplates: {
	            main1: "{preview}\n" +
	            "<div class=\'input-group {class}\'>\n" +
	            "   <div class=\'input-group-btn\ input-group-prepend'>\n" +
	            "       {browse}\n" +
	            "   </div>\n" +
	            "   {caption}\n" +
	            "</div>"
	        }
	    });
	});
	</script>
@endpush
