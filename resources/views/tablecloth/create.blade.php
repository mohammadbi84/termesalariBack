@extends('admin-layout')

@push('link')
	<!-- Select2 -->
  	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/select2/select2.min.css')}}">
	{{-- <link rel="stylesheet" href="{{asset('../storetemplate/plugins/dropzone-5.7.0/dist/min/dropzone.min.css')}}"> --}}
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css')}}" media="all" >
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css')}}" media="all" >
<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/explorer-fas/theme.min.css')}}" media="all" >

	<style>
		.is-invalid .select2-selection {
		    border-color: rgb(185, 74, 72) !important;
		}

		.is-invalid .file-preview  {
		    border: 1px solid rgb(185, 74, 72) !important;
		}

		.kv-file-content{
			width: 190px !important;
		}

		.price {
		    text-align: right !important; 
		    color: #000000 !important; 
		    font-size: 1rem !important;
		 }

	</style>
@endpush

@section('title','پنل مدیریت | ایجاد محصول رومیزی')
{{-- {{dd(($designs[1]->designColors))}} --}}
@section('main-content')
<div class="row">
	<div class="col">
		<!-- general form elements -->
	    <div class="card">
	      <div class="card-header">
	        <h3 class="card-title"><span>رومیزی جدید</span></h3>
	      </div>
	      <!-- /.card-header -->
	      <!-- form start -->
	      <form class="createForm" role="form" action="{{route('tablecloth.store')}}" method="POST" enctype="multipart/form-data">
	      	@csrf

	        <div class="card-body">

	        	<div class="form-group">
                	<label for="code">کد محصول</label>
					<input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" placeholder="کد محصول را وارد کنید ." value="{{old('code')}}" autofocus="autofocus">
					@error('code')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group @error('category_id') is-invalid @enderror">
					<label for="category_id">دسته بندی محصول</label>
                  	<select name="category_id" id="category_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;">
                  		<option value="" style="">نوع محصول را انتخاب کنید  </option>
                  		@foreach($categories as $category)
                  			<option value="{{ $category->id }}" @if($category->id == old('category_id')) selected @endif >{{ $category->title }}</option>
                  		@endforeach
                  	</select>

					@error('category_id')
					    <div class="invalid-feedback d-block">{{$message}}</div>
					@enderror
                </div>

				<div class="form-group @error('design_id') is-invalid @enderror">
					<label for="design_id">عنوان  طرح</label>
                  	<select name="design_id" id="design_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;" >

	                    <option value="" selected="selected" style="">نام طرح را انتخاب کنید  </option>
	                    @foreach($designs as $design)
	                    	<option  @if($design->id == old('design_id')) selected @endif value="{{$design->id}}">{{$design->title}}</option>
	                    @endforeach

                  	</select>

                  	@error('design_id')
					    <div class="invalid-feedback d-block">{{$message}}</div>
					@enderror	
                </div>

				<div class="form-group">
                	<label for="color_id">رنگ محصول</label>
                    <select name="color_id" id="color_id" class="form-control @error('color_id') is-invalid @enderror"></select>
                    @error('color_id')
					    <div class="invalid-feedback d-block">{{$message}}</div>
					@enderror
                </div>

				<div class="form-group">
					<label for="contains">مشتمل بر</label>
					<textarea name="contains" id="contains" class="form-control @error('contains') is-invalid @enderror" rows="3" placeholder="مثلا شامل یک رومیزی  مربع و دو رومیزی عسلی">{{old('contains')}}</textarea>

					@error('contains')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="dimensions">ابعاد محصول</label>
					<textarea name="dimensions" id="dimensions" class="form-control @error('dimensions') is-invalid @enderror" rows="3" placeholder="ابعاد محصول مثلاً رومیزی مربع با ابعاد 100 * 100 سانتیمتر  &#13;&#10;رومیزی عسلی با ابعاد 50 * 100 سانتیمتر">{{old('dimensions')}}</textarea>
					@error('dimensions')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="weight">وزن تقریبی</label>
					<textarea name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" rows="3" placeholder="مثلاً رومیزی کوچک   200 گرم &#13;&#10; رومیزی بزرگ  500 گرم">{{old('weight')}}</textarea>
					@error('weight')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="kind">جنس محصول</label>
                    <select name="kind" id="kind" class="form-control @error('kind') is-invalid @enderror">
                    	{{-- <option value="">جنس محصول را انتخاب کنید .</option> --}}
                      	<option  @if (old('kind') == 'ابریشم مصنوعی (ویسکوز ریون)') selected @endif value="ابریشمی">ابریشم مصنوعی (ویسکوز ریون)</option>
						<option  @if (old('kind') == 'ابریشم مصنوعی') selected @endif value="ابریشم مصنوعی">ابریشم مصنوعی</option>
                    </select>
                    @error('kind')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

                <div class="form-group">
                	<label for="sewingType">نوع دوخت</label>
                    <select name="sewingType" id="sewingType" class="form-control @error('sewingType') is-invalid @enderror">
                    	{{-- <option value="">نوع دوخت را انتخاب کنید .</option> --}}
                      	<option  @if (old('sewingType') == 'مغزی دوزی') selected @endif value="مغزی دوزی">مغزی دوزی</option>
						<option  @if (old('sewingType') == 'ساده') selected @endif value="ساده">ساده</option>
                    </select>
                    @error('sewingType')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

                <div class="form-group">
                	<label for="haveEster">آستر</label>
                    <select name="haveEster" id="haveEster" class="form-control @error('haveEster') is-invalid @enderror">
                    	{{-- <option value="">آنتخاب ویژگی آستر</option> --}}
                      	<option @if (old('haveEster') == 'دارد') selected @endif value="دارد">دارد</option>
						<option @if (old('haveEster') == 'ندارد') selected @endif value="ندارد">ندارد</option>
                    </select>
                    @error('haveEster')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

				<div class="form-group">
					<label for="kindOfEster">جنس آستر</label>
					<input disabled="disabled" type="text" name="kindOfEster" id="kindOfEster" class="form-control @error('kindOfEster') is-invalid @enderror" placeholder="مثلاً ساتن مرغوب" value="{{old('kindOfEster', 'ساتن مرغوب')}}"  >
					@error('kindOfEster')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
                	<label for="washable">قابلیت شستشو</label>
                    <select name="washable" id="washable" class="form-control @error('washable') is-invalid @enderror">
                    	<option value="">قابلیت شستشو</option>
                      	<option @if (old('washable') == 'توسط دست')  @endif value="توسط دست">توسط دست</option>
						<option @if (old('washable') == 'دارد ( ترجیحا خشکشویی)') selected @endif value="دارد ( ترجیحا خشکشویی)">دارد ( ترجیحا خشکشویی)</option>
						<option @if (old('washable') == 'ندارد') selected @endif value="ندارد">ندارد</option>
                    </select>
                    @error('washable')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

                <div class="form-group">
					<label for="uses">موارد استفاده</label>
					<textarea name="uses" id="uses" class="form-control @error('uses') is-invalid @enderror" rows="3" placeholder="مثلاً رومیزی، روی پشتی، روی تاقچه، سفره زینتی و ...">{{old('uses')}}</textarea>

					@error('uses')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="prices-one" >
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label for="price">قیمت محصول</label>
								<input type="text" name="price[]"  class="form-control price @error('price.0') is-invalid @enderror" placeholder="تنها شامل اعداد" value="{{old('price.0')}}">
								@error('price.0')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
			                	<label for="local">واحد</label>
			                    <select name="local[]"  class="form-control local @error('local.0') is-invalid @enderror">
			                    	<option value="">واحد پول را انتخاب کنید .</option>
			                      	<option @if (old('local.0') == 'تومان') selected @endif value="تومان">تومان</option>
									<option @if (old('local.0') == '$') selected @endif value="$">$</option>
									<option @if (old('local.0') == '&euro;') selected @endif value="&euro;">&euro;</option>
			                    </select>
			                    @error('local.0')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
			                </div>
						</div>

						<div class="col-md-2" style="text-align: left;margin: auto;">
							<a href="#" class="btn btn-flat btn-secondary addPrice" style="width: 40px" data-value="prices-two" >+</a>
						</div>	

					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
			                	<label for="offType">نوع تخفیف</label>
			                    <select name="offType[]"  class="form-control offType @error('offType.0') is-invalid @enderror">
			                    	<option value="">نوع تخفیف را انتخاب کنید .</option>
			                      	<option @if (old('offType.0') == 'درصد') selected @endif value="درصد">درصدی</option>
									<option @if (old('offType.0') == 'مبلغ') selected @endif value="مبلغ">مبلغ</option>
			                    </select>
			                    @error('offType.0')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
			                </div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label for="offPrice">میزان تخفیف</label>
								<input type="text" name="offPrice[]"  class="form-control offPrice @error('offPrice.0') is-invalid @enderror" placeholder="مثلاً 30 یا 100000" value="{{old('offPrice.0')}}"  @if(old('offPrice.0')=="") disabled @else enable @endif>
								@error('offPrice.0')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
						</div>

					</div>
				</div>

				<div class="prices-two mt-4 pt-4" style="border-top: 1px solid lightgray; @if(old("price.1")!="") display: block; @else  display: none; @endif"  >
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label for="price">قیمت محصول</label>
								<input type="text" name="price[]"  class="form-control price @error('price.1') is-invalid @enderror" placeholder="تنها شامل اعداد" value="{{old('price.1')}}">
								@error('price.1')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
			                	<label for="local">واحد</label>
			                    <select name="local[]"  class="form-control local @error('local.1') is-invalid @enderror">
			                    	<option value="">واحد پول را انتخاب کنید .</option>
			                      	<option @if (old('local.1') == 'تومان') selected @endif value="تومان">تومان</option>
									<option @if (old('local.1') == '$') selected @endif value="$">$</option>
									<option @if (old('local.1') == '&euro;') selected @endif value="&euro;">&euro;</option>
			                    </select>
			                    @error('local.1')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
			                </div>
						</div>

						<div class="col-md-2" style="text-align: left;margin: auto;">
							<a href="#" class="btn btn-flat btn-secondary addPrice" style="width: 40px" data-value="prices-three">+</a>
							<a href="#" class="btn btn-flat btn-danger delPrice" style="width: 40px" data-value="prices-two">-</a>
						</div>	

					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
			                	<label for="offType">نوع تخفیف</label>
			                    <select name="offType[]"  class="form-control offType @error('offType.1') is-invalid @enderror">
			                    	<option value="">نوع تخفیف را انتخاب کنید .</option>
			                      	<option @if (old('offType.1') == 'درصد') selected @endif value="درصد">درصدی</option>
									<option @if (old('offType.1') == 'مبلغ') selected @endif value="مبلغ">مبلغ</option>
			                    </select>
			                    @error('offType.1')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
			                </div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label for="offPrice">میزان تخفیف</label>
								<input type="text" name="offPrice[]"  class="form-control offPrice @error('offPrice.1') is-invalid @enderror" placeholder="مثلاً 30 یا 100000" value="{{old('offPrice.1')}}"  disabled="disabled">
								@error('offPrice.1')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
						</div>

					</div>
				</div>

				<div class="prices-three mt-4 pt-4" style="border-top: 1px solid lightgray; @if(old("price.2")!="") display: block; @else  display: none; @endif" >
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label for="price">قیمت محصول</label>
								<input type="text" name="price[]"  class="form-control price @error('price.2') is-invalid @enderror" placeholder="تنها شامل اعداد" value="{{old('price.2')}}">
								@error('price.2')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
			                	<label for="local">واحد</label>
			                    <select name="local[]"  class="form-control local @error('local.2') is-invalid @enderror">
			                    	<option value="">واحد پول را انتخاب کنید .</option>
			                      	<option @if (old('local.2') == 'تومان') selected @endif value="تومان">تومان</option>
									<option @if (old('local.2') == '$') selected @endif value="$">$</option>
									<option @if (old('local.2') == '&euro;') selected @endif value="&euro;">&euro;</option>
			                    </select>
			                    @error('local.2')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
			                </div>
						</div>

						<div class="col-md-2" style="text-align: left;margin: auto;">
							<a href="#" class="btn btn-flat btn-danger delPrice" style="width: 40px"data-value="prices-three">-</a>
						</div>	

					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
			                	<label for="offType">نوع تخفیف</label>
			                    <select name="offType[]"  class="form-control offType @error('offType.2') is-invalid @enderror">
			                    	<option value="">نوع تخفیف را انتخاب کنید .</option>
			                      	<option @if (old('offType.2') == 'درصد') selected @endif value="درصد">درصدی</option>
									<option @if (old('offType.2') == 'مبلغ') selected @endif value="مبلغ">مبلغ</option>
			                    </select>
			                    @error('offType.2')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
			                </div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label for="offPrice">میزان تخفیف</label>
								<input type="text" name="offPrice[]"  class="form-control offPrice @error('offPrice.2') is-invalid @enderror" placeholder="مثلاً 30 یا 100000" value="{{old('offPrice.2')}}"  disabled="disabled">
								@error('offPrice.2')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>
						</div>

					</div>
				</div>

				
				
				{{-- <div class="form-group @error('tags') is-invalid @enderror">
					<label for="tags">تگ یا برچسب برای استفاده در جستجو ها . لطفا به جای فاصله بین کلمات از زیرخط استفاده نمایید .</label>
					<select name="tags[]" id="tags" class="form-control" multiple="multiple" data-placeholder="امکان تایپ  و انتخاب برچسب مرتبط وجود دارد . بعنوان مثال رومیزی_گرد " style="width: 100%;text-align: right"></select>
					@error('tags')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div> --}}

                <div class="form-group @error('images') is-invalid @enderror">
                    <label for="images">انتخاب تصاویر محصول</label>
					<div class="file-loading">
					    <input id="images" name="images[]" type="file" multiple data-browse-on-zone-click="true" data-show-upload="true" data-show-caption="true" data-upload-url="#">
					    
					</div>
					@error('images')
						<div class="invalid-feedback d-block">{{$message}}</div>
					@enderror
                </div>

                <div class="form-group">
					<label for="quantity">موجودی در انبار</label>
					<input type="text" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="مثلاً 200" value="{{old('quantity')}}">
					@error('quantity')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="description">توضیحات بیشتر</label>
					<textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="توضیحات ، نکات و ویژگی های بیشتر در رابطه به محصول">{{old('description')}}</textarea>
					@error('description')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

	        <!-- /.card-body -->

	        <div class="card-footer">
	          	<button type="submit" class="btn btn-flat btn-primary">ارسال</button>
	        	<a href="{{ route('tablecloth.index') }}" class="btn btn-flat btn-secondary">بازگشت</a>
	        </div>
	      </form>
	    </div>
	    <!-- /.card -->
	</div>
</div>

@endsection
@push('js')

	<!-- Select2 -->
	<script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
	{{-- <script src="{{asset('../storetemplate/plugins/dropzone-5.7.0/dist/min/dropzone.min.js')}}"></script> --}}
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/fileinput.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/piexif.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/purify.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/locales/fa.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js')}}"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js 
   3.3.x versions without popper.min.js. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script>
	  $(function () {
$.fn.fileinputBsVersion = "3.3.7";

		$("#images").fileinput({
			theme: "fas",
			// minImageWidth: 20,
   // 		 	minImageHeight: 20,
	        enableResumableUpload: true,
	        allowedFileTypes: ["image"],
	        allowedFileExtensions: ["jpg", "png"],
	        browseLabel: "انتخاب تصاویر محصول",
	        // maxFileCount: 5,
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
	            "   {caption}\n"  +
	            "</div>"
	        },

	    });

	    //Initialize Select2 Elements
// {
// 		  selectOnClose: true
// 		}
	    $('.select2').select2({
	    	minimumResultsForSearch: Infinity
	    });

	 //    $('#tags').select2({
	 //    	dir: "rtl",
	 //    	multiple: "true",
	 //    	// tags: true,
		//   	ajax: {
		// 	    url: '{{-- {{route('api.tags')}} --}}',
		// 	    processResults: function (data) {
		//     	// console.log(data);
		//       	return data;
		//     	}
		//  	}
		// });

		$('#color_id').click(function(){
			// console.log();
			if($.trim($(this).html())==''){
				alert("لطفاً ابتدا نام طرح را انتخاب کنید");
			}
		});

//----------------------------------------------------------------------
		var d = $('#design_id').select2('data');
		var design_id = d[0].id;
		if( design_id != "" ){
			$('#color_id').html("");
			$.ajax({
				type: "GET",
				dataType: 'json',
				url: "{{ route('api.showColors') }}",
				data: 'id='+design_id,
				cache: false,
				success: function(data)
				{
					if(data.length > 0){
						$('#color_id').html('<option value="" >رنگ محصول را انتخاب کنید .</option>').trigger("change");
			        	data.forEach((element) => {
							if("{{ old('color_id') }}" == element.id)
			        			var newOption = new Option(element.color, element.id, false, true);
							else
			        			var newOption = new Option(element.color, element.id, false, false);

							$('#color_id').append(newOption).trigger('change');
						});
					}
					else{
						alert("این طرح فاقد اطلاعات رنگ بندی می باشد .بنابراین امکان استفاده از این طرح وجود ندارد .");
					}
				}
			});
		}

		$('#design_id').on('select2:select', function (e) {
			$('#color_id').html("");
			var id = e.params.data.id;
			// var id = $(this).children(":selected").attr('value');
			if(id != "")
			{
				$.ajax({
					type: "GET",
					dataType: 'json',
					url: "{{ route('api.showColors') }}",
					data: 'id=' + id ,
					cache: false,
					success: function(data)
					{
						// console.log(data);
						// data.forEach(element => console.log(element));
						// console.log(data[0].id);


						if(data.length > 0){
							$('#color_id').append('<option value="">رنگ محصول را انتخاب کنید .</option>');
							data.forEach((element) => {
								$('#color_id').append("<option value='"+element.id+"'>"+element.color+"</option>");
							});
						}
						else{
							alert("این طرح فاقد اطلاعات رنگ بندی می باشد .بنابراین امکان استفاده از این طرح وجود ندارد .");
						}
					}
				});
			}
		 	return false;
		});

		if($.trim($('#haveEster').val())=='دارد')
			$('#kindOfEster').removeAttr('disabled');

		$('#haveEster').change(function(){
			$('#kindOfEster').val("");
			if($.trim($(this).children(":selected").attr('value'))=='دارد')
				$('#kindOfEster').removeAttr('disabled');
			else
				$('#kindOfEster').attr('disabled','disabled');
		});

		if($.trim($('.offType').val())=='درصد' || $.trim($('.offType').val())== 'مبلغ' )
			$(this).parents(".col-md-5").parent(".row").find(".offPrice").removeAttr('disabled');

		$('.offType').change(function(){
			var $offPrice = $(this).parents(".col-md-5").parent(".row").find(".offPrice");
			$offPrice.val("");
			// $('#offPrice').val("");
			if($.trim($(this).children(":selected").attr('value'))=='درصد' ||  $.trim($(this).children(":selected").attr('value'))=='مبلغ')
				$offPrice.removeAttr('disabled');
			else
				$offPrice.attr('disabled','disabled');
		});

		$('.addPrice').click(function(){
			event.preventDefault();
			var $thiz = $(this);
			var value = $(this).data("value");
			$("."+value).fadeIn("fast");
			$thiz.hide();
			if(value == "prices-two"){
				$(".prices-two").find(".delPrice").fadeIn("fast");
				$(".prices-two").find(".addPrice").fadeIn("fast");
			}
			if(value == "prices-three"){
				$(".prices-two").find(".delPrice").fadeOut("fast");
				$(".prices-two").find(".addPrice").fadeOut("fast");
			}

		});

		$('.delPrice').click(function(){
			event.preventDefault();
			var $thiz = $(this);
			var value = $(this).data("value");
			$("."+value).fadeOut("fast");
			$("."+value).find(".price").val("");
			$("."+value).find(".offPrice").val("");
			$("."+value).find(".local").children("option[value='']").attr("selected","selected");
			$("."+value).find(".offType").children("option[value='']").attr("selected","selected");
			$("."+value).find(".offPrice").attr("disabled","disabled");
			if(value == "prices-two"){
				$(".prices-one").find(".addPrice").fadeIn("fast");
			}
			if(value == "prices-three"){
				$(".prices-two").find(".delPrice").fadeIn("fast");
				$(".prices-two").find(".addPrice").fadeIn("fast");
			}
		});

		


	  });//End


	</script>
@endpush