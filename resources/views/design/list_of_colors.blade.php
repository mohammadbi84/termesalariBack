@extends('admin-layout')

@section('title','پنل مدیریت | رنگبندی طرح ' . $design->title)

@push('link')
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
		
			<div class="card col-md-12 col-sm-12">
				<div class="card-header">
					<a href="#" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="رنگ جدید" data-toggle="modal" data-target="#createForm" id="createNewColor">+</a>
					<div class="card-title">
						<span>مدیریت  رنگبندی طرح {{ $design->title }}</span>
					</div>
				</div>
				<div class="card-body">
					<table class="table text-center" style="width:100%;" cellspacing="0">
						<tr>
							<th>ردیف</th>
							<th>رنگ</th>
							{{-- <th>وضعیت</th> --}}
							<th>حذف</th>
						</tr>
						@foreach($design->colors as $designColor)
						{{-- @dd($designColor) --}}
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $designColor->color }}</td>
								{{-- <td>
									@if($designColor->active == 0)
										<a class="changeActive" href="#" data-id="{{$designColor->id}}"><i class="fas fa-close danger-color"></i></a> 
									@else
										<a class="changeActive" href="#" data-id="{{$designColor->id}}"><i class="fas fa-check success-color"></i> </a>
									@endif
								</td> --}}
								<td>
									<a href="#" data-designColorID="{{$designColor->id}}" data-designID="{{ $design->id }}" class="btn btn-outline-danger btn-flat btn-sm delete"><i class="fas fa-trash-alt"></i> حذف </a>
								</td>
							</tr>
						@endforeach
					</table>
					<a href="{{ route('design.index') }}" class="btn btn-flat btn-secondary">بازگشت</a>
				</div>
			</div>
		</div>
	</section>
	<div class="modal fade" id="createForm" tabindex="-1" role="dialog" aria-labelledby="createFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postFormLabel">
                    	ایجاد رنگ جدید
                    </h5>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" id="">
                    	{{-- <div class="form-group">
							<label for="title">رنگ</label>
							<input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" placeholder="لطفا رنگ مربوط به طرح انتخابی را وارد کنید." value="{{old('color')}}">
							@error('color')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div> --}}

						{{-- <div class="form-group @error('active') is-invalid @enderror">
							<label for="active">وضعیت</label>
		                  	<select name="active" id="active" class="form-control" style="width: 100%;">
			                  		<option value="1" @if(old('active') == '1') selected @endif >فعال</option>

			                  		<option value="0" @if(old('active') == '0') selected @endif >غیرفعال</option>
		                  	</select>
		                  	@error('active')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
		                </div> --}}
		                <div class="form-group">
							<label>لطفا رنگ های مورد نظر را انتخاب کنید:</label>
							<select class="form-control select2" name="colors" id="colors"  multiple="multiple" data-placeholder="لطفا رنگ های مورد نظر را انتخاب کنید." style="width: 100%;text-align: right">
						    	@foreach($colors as $color)
									<option value="{{ $color->id }}">{{ $color->color }}</option>
						    	@endforeach
							</select>
						</div>

                    </form>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-flat btn-primary ml-2" id="saveColor" data-dismiss="modal">ثبت</a>
                    <button type="button" class="btn  btn-flat btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
	<!-- Select2 -->
	<script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
	<script>
		$(function () {
			$('.select2').select2();
			//-----------------------change Statuse---------------------------
			//  $(".changeActive").click(function(event){
			// 	event.preventDefault();
			// 	$(".loader").show();
			// 	var id = $(this).data("id");
			// 	var url = "{{ route('design.designColor_changeActive') }}";
			// 	var $thiz = $(this);
			// 	$.ajax({
			// 	    type: 'POST',
			// 	    url: url,
			// 	    data: {
		 //              _token: '<?php echo csrf_token() ?>',
		 //              id: id,
		 //            },
			// 	    success: function(data){
			// 	        var $i = $thiz.children("i");
			// 	        if($i.hasClass("fa-check"))
			// 	        {
			// 	        	$i.removeClass("fa-check success-color");
			// 	        	$i.addClass("fa-close danger-color");
			// 	        }
			// 	        else if ($i.hasClass("fa-close"))
			// 	        {
			// 	        	$i.removeClass("fa-close danger-color");
			// 	        	$i.addClass("fa-check success-color");
			// 	        }
			
			// 	        if(data.res == "error")
			// 	        {
			// 	        	title = "خطا  در اجرای عملیات" ;
			// 	        }
			// 	        else if(data.res == "success")
			// 	        {
			// 	        	title = "عملیات با موفقیت انجام شد.";
			// 	        }
			// 	        swal(title, data.message,data.res);
			// 	        $(".loader").hide();
			// 	    }
			// 	});
			// });

	//-----------------------------------------------------	    
			$(".delete").click(function(){
				event.preventDefault();
				var colorID = $(this).data("designcolorid");
				var designID = $(this).data("designid");
				var thiz = $(this);
				var addr = "{{ route('design.designColor_delete') }}";
				swal({
				  	title: "آیا از حذف این رنگ مطمئن هستید؟",
					text: "این عمل غیرقابل بازگشت  می باشد.",
				  	icon: "warning",
				   	buttons: ["انصراف","حذف"],
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
				  		$(".loader").show();
					  	$.ajax({
				            type:'POST',
				            url: addr,
				            data: {
					            _token: '<?php echo csrf_token() ?>',
					            colorID: colorID ,
					            designID: designID ,
				            },
				            success:function(data){
				                if(data.res == "error")
						        {
						        	title = "خطا  در اجرای عملیات" ;
						        }
						        else if(data.res == "success")
						        {
						        	title = "عملیات با موفقیت انجام شد.";
						        	thiz.closest("tr").fadeOut('slow');
						        }
						        swal(title, data.message,data.res);
						        $(".loader").hide();
				            }
			        	});
					}
				});
				
			});

			$("#createNewColor").click(function(){
				event.preventDefault();
				$(".modal-body").find("#colors").val("");
			});

			$("#saveColor").click(function(){
				event.preventDefault();
				var colors = $(".modal-body").find("#colors").val();
				// var active = $(".modal-body").find("#active").val();
				console.log(colors);
				var thiz = $(this);
				$(".loader").show();
			  	$.ajax({
		            type:'POST',
		            dataType: "json",
		            url: "{{ route('design.designColor_store') }}",
		            data: {
			            _token: '<?php echo csrf_token() ?>',
			            colors: colors ,
			            // active: active ,
			            design_id: "{{ $design->id }}",
		            },
		            success:function(data){
		            	if(data.res == "error")
				        {
				        	title = "خطا  در اجرای عملیات" ;
				        	swal(title, data.message,data.res);
				        }
				        else if(data.res == "success")
				        {
		                	location.reload();
				        }
				        $(".loader").hide();
		            }
	        	});
			});

		});//end
	</script>
@endpush