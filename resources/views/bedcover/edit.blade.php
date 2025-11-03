@extends('admin-layout')

@push('link')
<!-- Select2 -->
  <link rel="stylesheet" href="{{asset('../storetemplate/plugins/select2/select2.min.css')}}">
  {{-- Bootstrap File Input --}}
  <link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput.min.css')}}" media="all" >
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/css/fileinput-rtl.min.css')}}" media="all" >

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

@section('title','پنل مدیریت | ویرایش محصول')

@section('main-content')
{{-- {{ dd($bedcover) }} --}}
<div class="row">
	<div class="col">
		<!-- general form elements -->
	    <div class="card">
	      <div class="card-header">
	        <h3 class="card-title"><span>ویرایش  محصول  {{ $bedcover->category->title}} طرح {{$bedcover->color_design->design->title}} رنگ {{$bedcover->color_design->color->color}}</span></h3>
	      </div>
	      <!-- /.card-header -->
	      <!-- form start -->
	      {{-- @dump($errors) --}}
	      <form role="form" id="editForm" action="{{route('bedcover.update',[$bedcover])}}" method="POST" enctype="multipart/form-data">
	      	@csrf
	      	@method('put')
	        <div class="card-body">

	        	<div class="form-group">
                	<label for="code">کد محصول</label>
					<input type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="کد محصول را وارد کنید ." value="{{old('code',$bedcover->code)}}" autofocus="autofocus">
					@error('code')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

                <div class="form-group @error('category_id') is-invalid @enderror">
					<label for="category_id">دسته بندی محصول</label>
                  	<select name="category_id" id="category_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;">
                  		<option value="">نوع محصول را انتخاب کنید  </option>
                  		@foreach($categories as $category)
                  			<option value="{{ $category->id }}" @if($category->id == old('category_id',$bedcover->category->id)) selected @endif >{{ $category->title }}</option>
                  		@endforeach
                  	</select>

					@error('category_id')
					    <div class="invalid-feedback d-block">{{$message}}</div>
					@enderror
                </div>

				<div class="form-group @error('design_id') is-invalid @enderror">
					<label for="design_id">عنوان  طرح</label>
                  	<select  name="design_id" id="design_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;" >

	                    <option value="">نام طرح را انتخاب کنید  </option>
	                    @foreach($designs as $design)
	                    	<option @if (old('design_id', $bedcover->color_design->design->id) == $design->id ) selected @endif value="{{ $design->id }}">{{ $design->title }}</option>
	                    @endforeach

                  	</select>

                  	@error('design_id')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror	
               </div>
 
				<div class="form-group">
                	<label for="color_id">رنگ محصول</label>
                    <select name="color_id" id="color_id" class="form-control @error('color_id') is-invalid @enderror">
                    	@foreach($colors as $color)
                    		<option @if (old('color_id', $bedcover->color_design->color->id) == $color->id ) selected @endif value="{{ $color->id }}">{{ $color->color }}</option>
                    	@endforeach
                    </select>
                    @error('color_id')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

				<div class="form-group">
					<label for="contains">مشتمل بر</label>
					<textarea name="contains" class="form-control @error('contains') is-invalid @enderror" rows="3" placeholder="مثلا شامل یک رومیزی  مربع و دو رومیزی عسلی">{{old('contains',$bedcover->contains)}}</textarea>

					@error('contains')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="dimensions">ابعاد محصول</label>
					<textarea name="dimensions" class="form-control @error('dimensions') is-invalid @enderror" rows="3" placeholder="ابعاد محصول مثلاً رومیزی مربع با ابعاد 100 * 100 سانتیمتر  &#13;&#10;رومیزی عسلی با ابعاد 50 * 100 سانتیمتر">{{old('dimensions',$bedcover->dimensions)}}</textarea>
					@error('dimensions')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="weight">وزن تقریبی</label>
					<textarea name="weight" class="form-control @error('weight') is-invalid @enderror" rows="3" placeholder="مثلاً رومیزی کوچک تقریباً 200 گرم &#13;&#10; رومیزی بزرگ تقریباً 500 گرم">{{old('weight',$bedcover->weight)}}</textarea>
					@error('weight')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="kind">جنس محصول</label>
                    <select name="kind" class="form-control @error('kind') is-invalid @enderror">
                    	{{-- <option value="">جنس محصول را انتخاب کنید .</option> --}}
                      	<option  @if (old('kind',$bedcover->kind) == 'ابریشم مصنوعی (ویسکوز ریون)') selected @endif value="ابریشم مصنوعی (ویسکوز ریون)">ابریشم مصنوعی (ویسکوز ریون)</option>
						<option  @if (old('kind',$bedcover->kind) == 'ابریشم مصنوعی') selected @endif value="ابریشم مصنوعی">ابریشم مصنوعی</option>
                    </select>
                    @error('kind')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

                <div class="form-group">
                	<label for="sewingType">نوع دوخت</label>
                    <select name="sewingType" class="form-control @error('sewingType') is-invalid @enderror">
                    	{{-- <option value="">نوع دوخت را انتخاب کنید .</option> --}}
                      	<option @if (old('sewingType',$bedcover->sewingType) == 'مغزی دوزی') selected @endif value="مغزی دوزی">مغزی دوزی</option>
						<option @if (old('sewingType',$bedcover->sewingType) == 'ساده') selected @endif value="ساده">ساده</option>
                    </select>
                    @error('sewingType')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

                <div class="form-group">
                	<label for="haveEster">آستر</label>
                    <select name="haveEster" id="haveEster" class="form-control @error('haveEster') is-invalid @enderror">
                    	{{-- <option value="">آنتخاب ویژگی آستر</option> --}}
                      	<option @if (old('haveEster',$bedcover->haveEster) == 'دارد') selected @endif value="دارد">دارد</option>
						<option @if (old('haveEster',$bedcover->haveEster) == 'ندارد') selected @endif value="ندارد">ندارد</option>
                    </select>
                    @error('haveEster')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

				<div class="form-group">
					<label for="kindOfEster">جنس آستر</label>
					<input disabled="disabled" type="text" name="kindOfEster" id="kindOfEster" class="form-control @error('kindOfEster') is-invalid @enderror" placeholder="مثلاً ساتن مرغوب" value="{{old('kindOfEster',$bedcover->kindOfEster)}}"  >
					@error('kindOfEster')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
                	<label for="washable">قابلیت شستشو</label>
                    <select name="washable" class="form-control @error('washable') is-invalid @enderror">
                    	<option value="">قابلیت شستشو</option>
                      	<option @if (old('washable',$bedcover->washable) == 'توسط دست') selected @endif value="توسط دست">توسط دست</option>
						<option @if (old('washable',$bedcover->washable) == 'دارد ( ترجیحا خشکشویی)') selected @endif value="دارد ( ترجیحا خشکشویی)">دارد ( ترجیحا خشکشویی)</option>
						<option @if (old('washable',$bedcover->washable) == 'ندارد') selected @endif value="ندارد">ندارد</option>
                    </select>
                    @error('washable')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
                </div>

				@foreach($bedcover->prices->sortBy('local') as $key=>$prices)
					{{-- @dump($key,$prices) --}}
					<div class="prices-{{ $key + 1 }} @if($key == 1 or $key == 2) mt-4 pt-4 @endif " @if($key == 1 or $key == 2) style="border-top: 1px solid lightgray; @if(old('price.' . $key,$prices->price)!="") display: block; @else  display: none; @endif" @endif>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<label for="price">قیمت محصول</label>
									<input type="text" name="price[]"  class="form-control price @error('price.' . $key) is-invalid @enderror" placeholder="تنها شامل اعداد" value="{{old('price.' . $key,$prices->price)}}">
									
									@error('price.' . $key)
									    <div class="invalid-feedback">{{ $errors->first('price.' . $key) }}</div>
									@enderror
								</div>
							</div>

							<div class="col-md-5">
								<div class="form-group">
				                	<label for="local">واحد</label>
				                    <select name="local[]"  class="form-control local @error('local.' . $key) is-invalid @enderror">
				                    	<option value="">واحد پول را انتخاب کنید .</option>
				                      	<option @if (old('local.' . $key ,$prices->local) == 'تومان') selected @endif value="تومان">تومان</option>
										<option @if (old('local.' . $key,$prices->local) == '$') selected @endif value="$">$</option>
										<option @if (old('local.' . $key,$prices->local) == '&euro;') selected @endif value="&euro;">&euro;</option>
				                    </select>
				                    @error('local.' . $key)
									    <div class="invalid-feedback">{{  $errors->first('local.' . $key) }}</div>
									@enderror
				                </div>
							</div>

							<div class="col-md-2" style="text-align: left;margin: auto;">
								@if($key == 0 or $key == 1)
									<a href="#" class="btn btn-flat btn-secondary addPrice @if( ($key == 0 and $bedcover->prices->count() > 1) or ($key == 1 and $bedcover->prices->count() > 2) ) d-none @else d-inline-block @endif " style="width: 40px" data-value="prices-{{$key+2}}" >+</a>
									 
								@endif
								
									<a href="#" class="btn btn-flat btn-danger delPrice " style="width: 40px" data-value="prices-{{$key+1}}">-</a>
							</div>	

						</div>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
				                	<label for="offType">نوع تخفیف</label>
				                    <select name="offType[]"  class="form-control offType @error('offType.' . $key) is-invalid @enderror">
				                    	<option value="">نوع تخفیف را انتخاب کنید .</option>
				                      	<option @if (old('offType.' . $key,$prices->offType) == 'درصد') selected @endif value="درصد">درصدی</option>
										<option @if (old('offType.' . $key,$prices->offType) == 'مبلغ') selected @endif value="مبلغ">مبلغ</option>
				                    </select>
				                    @error('offType.' . $key)
									    <div class="invalid-feedback">{{  $errors->first('offType.' . $key) }}</div>
									@enderror
				                </div>
							</div>

							<div class="col-md-5">
								<div class="form-group">
									<label for="offPrice">میزان تخفیف</label>
									<input type="text" name="offPrice[]"  class="form-control offPrice @error('offPrice.' . $key) is-invalid @enderror" placeholder="مثلاً 30 یا 100000" value="{{old('offPrice.' .$key ,$prices->offPrice)?? '0'}}" >

									@error('offPrice.' . $key)
									    <div class="invalid-feedback">{{  $errors->first('offPrice.' . $key) }}</div>
									@enderror
								</div>
							</div>

						</div>
					</div>

				@endforeach

				@if($bedcover->prices->count() == 1)

					<div class="prices-2 mt-4 pt-4" style="border-top: 1px solid lightgray; @if(old("price.1")!="") display: block; @else  display: none; @endif"  >
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
								<a href="#" class="btn btn-flat btn-secondary addPrice" style="width: 40px" data-value="prices-3">+</a>
								<a href="#" class="btn btn-flat btn-danger delPrice" style="width: 40px" data-value="prices-2">-</a>
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
									<input type="text" name="offPrice[]"  class="form-control offPrice @error('offPrice.1') is-invalid @enderror" placeholder="مثلاً 30 یا 100000" value="{{old('offPrice.1')}}" @if(old('offPrice.1')=="") disabled @else enable @endif>
									@error('offPrice.1')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>
							</div>

						</div>
					</div>

				@endif

				@if($bedcover->prices->count() < 3)
					<div class="prices-3 mt-4 pt-4" style="border-top: 1px solid lightgray; @if(old("price.2")!="") display: block; @else  display: none; @endif" >
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
								<a href="#" class="btn btn-flat btn-danger delPrice" style="width: 40px" data-value="prices-3">-</a>
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
									<input type="text" name="offPrice[]"  class="form-control offPrice @error('offPrice.2') is-invalid @enderror" placeholder="مثلاً 30 یا 100000" value="{{old('offPrice.2')}}" @if(old('offPrice.2')=="") disabled @else enable @endif>
									@error('offPrice.2')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>
							</div>

						</div>
					</div>
				@endif

                <div class="form-group @error('images') is-invalid @enderror">
                    <label for="images">تصاویر محصول</label>
					<div class="file-loading">
					    <input id="images" name="images[]" type="file" multiple>
					</div>
					
					<div class="invalid-feedback d-block" style=""></div>
					
                </div>

                <div class="form-group">
					<label for="quantity">موجودی در انبار</label>
					<input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="مثلاً 200" value="{{old('quantity',$bedcover->quantity)}}">
					@error('quantity')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

				<div class="form-group">
					<label for="description">توضیحات بیشتر</label>
					<textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="توضیحات ، نکات و ویژگی های بیشتر در رابطه به محصول">{{old('description',$bedcover->description)}}</textarea>
					@error('description')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
				</div>

	        <!-- /.card-body -->

	        <div class="card-footer">
	          <button type="submit" id="store" class="btn btn-flat btn-primary">ثبت</button>
	          <a href="{{ route('bedcover.index') }}" class="btn btn-flat btn-secondary">بازگشت</a>
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
	{{-- Bootstrap File Input --}}
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/fileinput.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/piexif.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/popper.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/purify.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/themes/fas/theme.min.js')}}"></script>
	<script src="{{asset('../storetemplate/plugins/bootstrap-fileinput-master/js/locales/fa.js')}}"></script>

	<script>
	  $(function () {
		@php
      		$images = $bedcover->images()->get()->sortby('ordering');
      		$urls = [];
	    @endphp  	
      	@foreach($images as $image)
	    	var url{{$image['id']}} = "{{asset('storage/images/thumbnails/'.$image['name'])}}"
   		@endforeach

	    $("#images").fileinput({
	        initialPreview:[
		        @foreach($images as $image)
		        	url{{$image['id']}} , 
		        @endforeach
	        ],
	        initialPreviewAsData: true,
	        initialPreviewShowDelete: true,
	        initialPreviewConfig: [
	        	@foreach($images as $image)
		        	{
		        		filename: "{{$image['name']}}",
		        		width: "120px",
		        		downloadUrl: url{{$image['id']}} ,
		        		url: "{{route('image.delOneImage')}}" ,
		        		key: {{$image['id']}} ,
		        		extra: {
		        			'_token' : '{{csrf_token()}}',
                			'_method' : 'DELETE',
                			'id': {{ $bedcover->id }}, 
                			'model':"Bedcover", 
                		},
		        	}, 
		        @endforeach
	        ],
	        deleteUrl: "{{ route('image.delOneImage') }}",
	        deleteExtraData: {
                '_token': '{{csrf_token()}}',
                '_method' : 'DELETE',
            },
            uploadUrl: "{{ route('image.delOneImage') }}",
	        uploadAsync: false,
	        initialPreviewFileType: 'image',
	        overwriteInitial: false,
	        enableResumableUpload: true,
	    	showCaption: false,
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
	    
		}).on('filebeforedelete', function(event, key, data) {
	    	// console.log('Key = ' + key);
	        var aborted = !window.confirm('آیا با حذف این تصویر موافق هستید ؟');

	        return aborted;
	    }).on('filesorted', function(e, params) {
	    	$.ajax({
				type: "post",
				dataType: 'json',
				url: "{{ route('image.ordering') }}",
				data: {
					id1: params.stack[params.newIndex].key ,
					id2: params.stack[params.oldIndex].key ,
					oldIndex: params.oldIndex ,
					newIndex: params.newIndex,
					_token: '<?php echo csrf_token() ?>',
				},				
				cache: false,
				success: function(data)
				{
					console.log('chanaged order');
				}
			});
		});

	    $("#store").click(function(){
	    	var totalFilesCount = $('#images').fileinput('getFilesCount', true);
	    	if(totalFilesCount == 0)
	    	{
	    		$("#images").parents(".form-group").addClass("is-invalid");
	    		var c = $("#images").parents(".form-group").find(".invalid-feedback").text("پر کردن فیلد تصاویر محصول الزامی می باشد.");
	    		// .css("display","block")
	    		event.preventDefault();
	    	}

	    	return true;
	    });


	    //Initialize Select2 Elements
	    $('.select2').select2({
	    	dir: "rtl",
	    });
		
		$('#color_id').click(function(){
			// console.log();
			if($.trim($(this).html())==''){
				alert("لطفاً ابتدا نام طرح را انتخاب کنید");
			}
		});

		//--------------------------------------------------------
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
							if("{{ old('color_id', $bedcover->color_design->color->id) }}" == element.id)
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
			if($.trim($(this).children(":selected").attr('value'))=='دارد'){
				$('#kindOfEster').removeAttr('disabled');
			}
			
			else
				$('#kindOfEster').attr('disabled','disabled');
		});

		$('.addPrice').click(function(){
			event.preventDefault();
			var $thiz = $(this);
			var value = $(this).data("value");
			$("."+value).fadeIn("fast");
			$thiz.hide();
			if(value == "prices-2"){
				$(".prices-1").find(".addPrice").addClass("d-none").removeClass("d-inline-block").fadeIn("fast");
				$(".prices-2").find(".delPrice").addClass("d-inline-block").removeClass("d-none").fadeIn("fast");
				$(".prices-2").find(".addPrice").addClass("d-inline-block").removeClass("d-none").fadeIn("fast");
			}
			if(value == "prices-3"){
				$(".prices-2").find(".addPrice").addClass("d-none").removeClass("d-inline-block").fadeOut("fast");
			}

		});

		$('.delPrice').click(function(){
			event.preventDefault();
			var c = $("#editForm").find("div[class^='prices-'][style*='display: none']").length;
			if(c == 2)
				swal("خطا در انجام عملیات","حداقل یک قیمت باید برای محصول ثبت شود." ,"error");
			else
			{
				var $thiz = $(this);
				var value = $(this).data("value");
				$("."+value).fadeOut("fast");
				$("."+value).find(".price").val("");
				$("."+value).find(".offPrice").val("");
				$("."+value).find(".local").children("option[value='']").attr("selected","selected");
				$("."+value).find(".offType").children("option[value='']").attr("selected","selected");
				$("."+value).find(".offPrice").attr("disabled","disabled");
				if(value == "prices-2"){
					$(".prices-1").find(".addPrice").addClass("d-inline-block").removeClass("d-none").fadeIn("fast");
				}
				if(value == "prices-3"){
					$(".prices-2").find(".addPrice").addClass("d-inline-block").removeClass("d-none").fadeIn("fast");
				}
			}
		});
		


	  });//End


	</script>
@endpush