@extends('admin-layout')

@section('title','لیست تصاویر اسلایدشو')

@push('link')
	<!-- DataTables -->
  	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
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
		</div>
		<div class="card">
			<div class="card-header">
				<a href="{{ route('slideshow.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="محصول جدید">+</a>
				<div class="card-title float-right"><span>تصاویر اسلایدشو</span></div>
			</div>
			<div class="card-body">
				<table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0">
					<thead>
						<tr>
							<th class="no-sort">
		                		<label>
			                    	<input type="checkbox" data-value = "All" class="flat-red checkAll">
			                  	</label>
			                </th>
							<th class="no-sort">ردیف</th>
							<th>موقعیت</th>
							<th>عنوان</th>
							<th>لینک</th>
							<th>ترتیب</th>
							<th>نمایش</th>
							<th class="no-sort">ویرایش</th>
							<th class="no-sort">حذف</th>
						</tr>
					</thead>
					<tbody>
						@foreach($slideshowImages as $slideshow)
						<tr>
							<td>
		                		<label>
			                    	<input type="checkbox" data-value = "{{ $slideshow->id }}" class="flat-red checkbox">
			                  	</label>
		                	</td>
							<td>{{ $loop->iteration }}</td>
							<td>
								@if($slideshow->position == 'homeStore-B') صفحه اصلی - موقعیت دوم @elseif ($slideshow->position == 'homeStore-A') صفحه اصلی - موقعیت اول  @endif
							</td>
							<td>
								<img src="{{asset('storage/images'. $slideshow->image)}}" class="img-circle img-size-50 mr-2">
								{{ $slideshow->title }}
							</td>
							<td>{{ $slideshow->link }}</td>
							<td>{{ $slideshow->order }}</td>
							<td>
								@if($slideshow->visibility == 0)
									<a class="changeVisibility" href="#" data-id="{{$slideshow->id}}"><i class="fas fa-close danger-color"></i></a> 
								@else
									<a class="changeVisibility" href="#" data-id="{{$slideshow->id}}"><i class="fas fa-check success-color"></i> </a>
								@endif
							</td>
							<td>
								<a href="{{route('slideshow.edit',[$slideshow])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش </a>
							</td>
							<td>
								<form class="del-form" action="{{route('slideshow.destroy', [$slideshow])}}" method="post">
									@csrf
									@method('delete')
									{{-- <input type="submit" class="btn btn-outline-danger btn-flat delete" value="حذف " name="submit"> --}}
									<a href="#" class="btn btn-outline-danger btn-flat btn-sm delete"><i class="fas fa-trash-alt"></i> حذف </a>

								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th class="no-sort">
		                		<label>
			                    	<input type="checkbox" data-value = "All" class="flat-red checkAll">
			                  	</label>
			                </th>
							<th class="no-sort">ردیف</th>
							<th>موقعیت</th>
							<th>عنوان</th>
							<th>لینک</th>
							<th>ترتیب</th>
							<th>نمایش</th>
							<th class="no-sort">ویرایش</th>
							<th class="no-sort">حذف</th>
						</tr>
					</tfoot>
				</table>
				<div class="buttons">
              		<a href="" id="changeVisibilityGroup" class="btn btn-primary btn-flat">نمایش / عدم نمایش</a>
              	</div>
			</div>
		</div>
	</section>
@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	{{-- <script src="{{asset('/storetemplate/dist/js/dataTable.js')}}"></script> --}}
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script>
	<script>
		$(function () {
			$(document).on('click', '.delete', function(event){
				event.preventDefault();
				// event.stopPropagation();
				var $thiz = $(this);
				swal({
				  	title: "آیا از حذف این تصویر مطمئن هستید؟",
				  	text: "با انجام این کار، این تصویر از اسلایدشو صفحه اصلی حذف خواهد شد.",
				  	icon: "warning",
				   	buttons: ["انصراف","حذف"],
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
						// title = "عملیات با موفقیت انجام شد.";
						// swal(title, data.message,data.res);
						// thiz.closest("tr").fadeOut('slow');       
				        // $thiz.unbind('click').click(); 
				        $thiz.parent('.del-form').submit()
			        }
				});
			});

//-----------------------change Statuse---------------------------
			$(document).on('click', '.changeVisibility', function(event){
				event.preventDefault();
				var url = "{{ route('slideshow.changeVisibility') }}";
				var id = $(this).data("id");
				var $thiz = $(this);
				$.ajax({
				    type: 'POST',
				    url: url ,
				    data: {
		              	_token: '<?php echo csrf_token() ?>',
		              	id: id,
		            },
				    success: function(data){
				    	// $("body").html(data);
				        // console.log(data);
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
				    }
				});
			});
		//--------change Statuse group--------------------------------
			$('#changeVisibilityGroup').click(function(event){
				event.preventDefault();
				var items = [];
				var url = "{{ route('slideshow.changeVisibilityGroup') }}"
		  		$("#dataTable-table").find("div[aria-checked='true']").children("input").each(function(index){
					items[index] = $(this).data("value");
					// $(this).closest('tr').fadeOut('slow');
				});

				// console.log(items);
			    $.ajax({
		            type:'POST',
		            url: url,
		            data: {
		              	_token: '<?php echo csrf_token() ?>',
		              	items: items,
		            },
		            success:function(data){
		               if(data.res == "error")
				        {
				        	title = "خطا  در اجرای عملیات" ;
				        }
				        else if(data.res == "success")
				        {
				        	title = "عملیات با موفقیت انجام شد.";
				        	$("#dataTable-table").find("div[aria-checked='true']").each(function(index)
				        	{
				        		$(this).find('.icheckbox_flat-blue').iCheck('uncheck');
								$(this).removeClass("bg-skyblue");
								var $thiz = $(this).parents("tr").find("a[class='changeVisibility']").children("i");
								if($thiz.hasClass("fa-check"))
						        {
						        	$thiz.removeClass("fa-check success-color");
						        	$thiz.addClass("fa-close danger-color");
						        }
						        else if ($thiz.hasClass("fa-close"))
						        {
						        	$thiz.removeClass("fa-close danger-color");
						        	$thiz.addClass("fa-check success-color");
						        }
								
							});
				        }
				        swal(title, data.message,data.res);
		            }
		        });
			});
		//-------------------------------------------

			$('#dataTable-table').DataTable({
		        "language": {
		            "paginate": {
		                "next": "بعدی",
		                "previous" : "قبلی",
		            },
		            // "searchPanes":{
		            // 	"count":'{total} found',
		            // 	"countFiltered": '{shown} ({total})',
		            // },
		            "decimal": ",",
		            "thousands": ".",
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
			       	// { "width": "10%", "targets": 9 }
		       	],
		       	// "saerchPanes":{
		       	// 	"viewTotal":true,
		       	// },
		       	// "dom":'Pfrtip'

				
		    });

		});
	</script>
@endpush