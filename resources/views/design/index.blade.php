@extends('admin-layout')

@section('title','پنل مدیریت | لیست  طرح ها و رنگ های محصولات')

@push('link')
<!-- DataTables -->
 	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
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
					<a href="{{ route('design.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="طرح جدید">+</a>
					<div class="card-title">
						<span>لیست  طرح ها و رنگ های محصولات</span>
					</div>
				</div>
				<div class="card-body">
					<table class="table text-center" style="width:100%;" cellspacing="0" id="dataTable-table">
						<thead>
							<tr>
								<th>ردیف</th>
								<th>عنوان</th>
								<th>تعداد رنگ بافت</th>
								<th>وضعیت</th>
								<th>رنگ بندی</th>
								<th>مدیریت رنگ بندی</th>
								<th>ویرایش</th>
								<th>حذف</th>
							</tr>
						</thead>
						<tbody>
							@foreach($designs as $design)
							{{-- @dd($design) --}}
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $design->title }}</td>
									<td>{{ $design->countOfColor }}</td>
									<td>
										@if($design->active == 0)
											<a class="changeActive" href="#" data-id="{{$design->id}}" title="غیر فعال است"><i class="fas fa-close text-danger"></i></a> 
										@else
											<a class="changeActive" href="#" data-id="{{$design->id}}" title="فعال است"><i class="fas fa-check text-success"></i> </a>
										@endif
									</td>
									<td>
										@foreach($design->colors as $color)
											{{ $color->color }} /	
										@endforeach
									</td>
									<td>
										<a href="{{route('design.listOfColors',[$design])}}" class="btn btn-outline-success btn-flat btn-sm"> <i class="fas fa-palette"> </i> مدیریت رنگ </a>
									</td>
									<td>
										<a href="{{route('design.edit',[$design])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش </a>
									</td>
									<td>
										<form class="del-form" action="{{route('design.destroy', [$design])}}" method="post">
											@csrf
											@method('delete')
											{{-- <input type="submit" name="" class="btn btn-outline-danger btn-flat btn-sm delete" value="حذف"> --}}
											<a href="#" data-id="{{$design->id}}" data-model="Tablecloth" class="btn btn-outline-danger btn-flat btn-sm delete"><i class="fas fa-trash-alt"></i> حذف </a>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>ردیف</th>
								<th>عنوان</th>
								<th>تعداد رنگ بافت</th>
								<th>وضعیت</th>
								<th>رنگ بندی</th>
								<th>مدیریت رنگ بندی</th>
								<th>ویرایش</th>
								<th>حذف</th>
							</tr>
						</tfoot>
						
						{{-- @if($designs->count() > 0)
							<tr>
								<td colspan="7" style="text-align: center !important;">{{ $designs->links() }}</td>
							</tr>
						@endif --}}
					</table>
						
				</div>
			</div>
		</div>
	</section>
@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<script>
		$(function () {
			//-----------------------Data Table-------------------
		    $('#dataTable-table').DataTable({
		        "language": {
		            "paginate": {
		                "next": "بعدی",
		                "previous" : "قبلی",
		            },
		            // "decimal": ",",
		            // "thousands": ".",
		            "search" : "جستجو : ",
		            "lengthMenu":'نمایش   <select>'+
		                '<option value="10">10</option>'+
		                '<option value="20">20</option>'+
		                '<option value="30">30</option>'+
		                '<option value="40">40</option>'+
		                '<option value="50">50</option>'+
		                '<option value="-1">همه</option>'+
		                '</select> سطر' ,

		        },
				"info" : false,
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"autoWidth": true,
				"scrollX": true,
		       	"responsive": true,
		       	"order":[],
		       	"columnDefs":[
			       	{ "targets":'no-sort',"orderable":false,},
			       	{ "width": "30%", "targets": 4 }
		       	],
		    });
			//-------------------change Statuse---------------------
			$(document).on('click', '.changeActive', function(event){
				event.preventDefault();
				$(".loader").show();
				var id = $(this).data("id");
				var url = "{{ route('design.changeActive') }}";
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
				        	$i.removeClass("fa-check text-success");
				        	$i.addClass("fa-close text-danger");
				        }
				        else if ($i.hasClass("fa-close"))
				        {
				        	$i.removeClass("fa-close text-danger");
				        	$i.addClass("fa-check text-success");
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

	//---------------------------------------------------------------------------	    
			$(document).on('click', '.delete', function(event){
				event.preventDefault();
				var id = $(this).data("id");
				var thiz = $(this);
				var addr = $(this).parents(".del-form").attr("action");
				swal({
				  	title: "آیا از حذف این طرح مطمئن هستید؟",
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