@extends('admin-layout')

@section('title','تصاویر اسلایدشو ')

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
					<div class="card-title"><span>تنظیمات اسلایدشو صفحه اصلی فروشگاه</span></div>
				</div>
				<form class="form" role="form" action="{{ route('slideshow.store') }}" method="POST" enctype="multipart/form-data">
					<div class="card-body">
						
						@csrf

						<div class="form-group @error('position') is-invalid @enderror">
							<label for="position">موقعیت اسلایدشو</label>
		                  	<select name="position" id="position" class="form-control select2 select2-hidden-accessible " style="width: 100%;">
			                    <option value="" selected="selected" style="">.موقعیت اسلایدشو را انتخاب کنید</option>
			                  	<option value="homeStore-A" @if (old('position') == 'homeStore-A')) selected @endif >صفحه اصلی - موقعیت اول</option>
			                  	<option value="homeStore-B" @if (old('position') == 'homeStore-B')) selected @endif >صفحه اصلی - موقعیت دوم</option>
		                  	</select>
		                </div>

		                <div class="form-group">
							<label for="title">عنوان</label>
							<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="لطفا عنوان  تصویر را وارد کنید." value="{{old('title')}}" maxlength="100">
							@error('title')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="description">توضیحات</label>
							<textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="لطفا توضیحات  تصویر را وارد کنید." maxlength="300">{{ old('description') }}</textarea>
							@error('description')
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

				        <div class="form-group">
							<label for="link">لینک</label>
							<input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror" placeholder="لطفا آدرس لینک تصویر را وارد کنید." value="{{old('link')}}">
							@error('link')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

				        <div class="form-group">
							<label for="order">ترتیب</label>
							<input type="text" name="order" id="order" class="form-control @error('order') is-invalid @enderror" placeholder="لطفا عدد مربوط به ترتیب تصویر را وارد کنید." value="{{old('order')}}">
							@error('order')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

					</div>
					<div class="card-footer">
			          <button type="submit" class="btn btn-flat btn-primary">ارسال</button>
			          <a href="{{ route('slideshow.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
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

		$('.select2').select2({
	    	minimumResultsForSearch: Infinity
	    });

	    

	    var p = $('#position').select2('data');
		var position_value = p[0].id;
		if( position_value != "" ){
			if($.trim(position_value)=='homeStore-A')
				$('#description').removeAttr('disabled');
			else
				$('#description').attr('disabled','disabled');
		}

		$('#position').on('select2:select', function (e) {
			var id = e.params.data.id;
			// console.log(id);
			if($.trim(id)=='homeStore-A')
				$('#description').removeAttr('disabled');
			else
				$('#description').attr('disabled','disabled');
		});



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
