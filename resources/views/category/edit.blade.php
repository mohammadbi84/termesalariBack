@extends('admin-layout')

@section('title','پنل مدیریت | ایجاد دسته بندی محصولات')

@push('link')
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css')}}" media="all" >
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css')}}" media="all" >
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
			<div class="card col-md-12 col-sm-12">
				<div class="card-header">
					<div class="card-title">
						<span>ایجاد دسته بندی محصولات</span>
					</div>
				</div>
				<div class="card-body">

					<form class="form" role="form" action="{{ route('category.update',[$category]) }}" method="post" enctype="multipart/form-data">
						@csrf
						@method('put')
						<div class="form-group @error('parent_id') is-invalid @enderror">
							<label for="parent_id">عنوان محصول</label>
		                  	<select name="parent_id" id="parent_id" class="form-control" style="width: 100%;">
			                  	@foreach($productCategories as $productCategory)
									<option value="{{ $productCategory->id }}" @if($productCategory->id  == old('parent_id',$category->parent_id)) selected @endif >{{ $productCategory->title }}</option>
			                  	@endforeach
		                  	</select>
		                  	@error('parent_id')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
		                </div>

		                <div class="form-group">
							<label for="title">عنوان دسته بندی</label>
							<input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="لطفا عنوان  دسته بندی را وارد کنید." value="{{old('title',$category->title)}}">
							@error('title')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>

						<div class="form-group @error('image') is-invalid @enderror">
				            <label for="image">انتخاب تصویر </label>
							<div class="file-loading">
							    <input id="image" name="image" type="file" data-browse-on-zone-click="true" data-show-caption="true" value="{{ $category->image }}">
							</div>
							@error('image')
								<div class="invalid-feedback d-block">{{$message}}</div>
							@enderror
				        </div>

						<div class="form-group @error('active') is-invalid @enderror">
							<label for="active">وضعیت</label>
		                  	<select name="active" id="active" class="form-control" style="width: 100%;">
			                  		<option value="1" @if(old('active',$category->active) == '1') selected @endif >فعال</option>

			                  		<option value="0" @if(old('active',$category->active) == '0') selected @endif >غیرفعال</option>
		                  	</select>
		                  	@error('active')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
		                </div>

						<button type="submit" class="btn btn-flat btn-primary">ثبت تغییرات</button>
			          	<a href="{{ route('category.index') }}" class="btn btn flat btn-secondary">بازگشت</a>
					</form>
				</div>
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

	<script>
		$(function () {
			$("#image").fileinput({
		        initialPreview:[
		    		url = "{{asset('storage/images/categories/thumbnails/'.$category->image)}}"
		        ],
		        initialPreviewAsData: true,
		        initialPreviewShowDelete: false,
	        	uploadAsync: false,
	        	initialPreviewFileType: 'image', 
		        overwriteInitial: true,
		        enableResumableUpload: true,
		    	showCaption: false,
		        maxFileCount: 1,
		    	showCancel: false,
		    	showUpload: false,
		    	browseOnZoneClick: true,
		        allowedFileTypes: ["image"],
		        allowedFileExtensions: ["jpg", "png"],
		        browseLabel: "انتخاب تصاویر محصول",
		        theme: 'fas',
		        browseClass: "btn btn-primary",
		        rtl: true,
		        language: "fa",
		        layoutTemplates: {
		            main1: "{preview}\n" +
		            "<div class=\'input-group {class}\'>\n" +
		            "   <div class=\'input-group-btn\ input-group-prepend'>\n" +
		            "       {browse}\n" +
		            "   </div>\n" +
		            "   {caption}\n" +
		            "</div>"
		        },
	    	});


		});
	</script>
@endpush
