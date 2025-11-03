@extends('admin-layout')

@section('title','پنل مدیریت | لیست دسته بندی محصولات')

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
		    </div>
		
			<div class="card col-md-12 col-sm-12">
				<div class="card-header">
					<a href="{{ route('category.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="دسته بندی جدید">+</a>
					<div class="card-title">
						<span>لیست دسته بندی محصولات</span>
					</div>
				</div>
				<div class="card-body">
					<table class="table" style="width:100%;" cellspacing="0" id="dataTable-table">
						@foreach($data['topCat'] as $key => $topCategory)
							{{-- @dump($key , $topCategory) --}}
							<tr style="background-color: lightgray">
								<th colspan="5" class="text-right">{{ $topCategory->title }}</th>
							</tr>
							<tr class="text-center">
								<th>ردیف</th>
								<th>عنوان</th>
								<th>وضعیت</th>
								<th>ویرایش</th>
								<th>حذف</th>
							</tr>
							@if(isset($data['subCat'][$topCategory->id]) and count($data['subCat'][$topCategory->id])>0)
								@foreach($data['subCat'][$topCategory->id] as $subCategory)
									{{-- @dump($subCategory->title) --}}
									<tr class="text-center">
										<td>{{ $loop->iteration }}</td>
										<td>
											<img src="{{ asset('storage/images/categories/thumbnails/'. $subCategory->image) }}" alt="" class="img-circle img-size-50 mr-2">
											{{ $subCategory->title }}
										</td>
										<td>
											@if($subCategory->active == 0)
												<a class="changeActive" href="#" data-id="{{$subCategory->id}}"><i class="fas fa-close danger-color"></i></a> 
											@else
												<a class="changeActive" href="#" data-id="{{$subCategory->id}}"><i class="fas fa-check success-color"></i> </a>
											@endif
										</td>
										<td>
											<a href="{{route('category.edit',[$subCategory])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش </a>
										</td>
										<td>
											<form class="del-form" action="{{route('category.destroy', [$subCategory])}}" method="post">
												@csrf
												@method('delete')
												{{-- <input type="submit" name="" class="btn btn-outline-danger btn-flat btn-sm delete" value="حذف"> --}}
												<a href="#" data-id="{{$subCategory->id}}" data-model="Tablecloth" class="btn btn-outline-danger btn-flat btn-sm delete"><i class="fas fa-trash-alt"></i> حذف </a>
											</form>
										</td>
									</tr>

								@endforeach
							@endif
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('js')
	<script>
		$(function () {
			//-----------------------change Statuse---------------------------
			$(".changeActive").click(function(event){
				event.preventDefault();
				$(".loader").show();
				var id = $(this).data("id");
				var url = "{{ route('category.changeActive') }}";
				var $thiz = $(this);
				$.ajax({
				    type: 'POST',
				    url: url,
				    data: {
		              _token: '<?php echo csrf_token() ?>',
		              id: id,
		            },
				    success: function(data){
				        var $i = $thiz.children("i");
				        if($i.hasClass("fa-check"))
				        {
				        	$i.removeClass("fa-check success-color");
				        	$i.addClass("fa-close danger-color");
				        }
				        else if ($i.hasClass("fa-close"))
				        {
				        	$i.removeClass("fa-close danger-color");
				        	$i.addClass("fa-check success-color");
				        }
			
				        if(data.res == "error")
				        {
				        	title = "خطا  در اجرای عملیات" ;
				        }
				        else if(data.res == "success")
				        {
				        	title = "عملیات با موفقیت انجام شد.";
				        }
				        swal(title, data.message,data.res);
				        $(".loader").hide();

				    }
				});
			});

			
	//----------------------------------------------------------------------------	    

			$(".delete").click(function(){
				event.preventDefault();
				var id = $(this).data("id");
				var thiz = $(this);
				var addr = $(this).parents(".del-form").attr("action");
				swal({
				  	title: "آیا از حذف این  دسته بندی  مطمئن هستید؟",
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
				              _method : 'DELETE',
				              id: id ,
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
		});//end
	</script>
@endpush