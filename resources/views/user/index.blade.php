@extends('admin-layout')

@section('title','لیست اعضای سایت')

@push('link')
	<!-- DataTables -->
 	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
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

				<div class="card">
	            <div class="card-header">
	              <h3 class="card-title float-right"><span>لیست اعضای سایت</span></h3>
	            </div>
	            <!-- /.card-header -->
	            <div class="card-body">
	              <table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0">
	                <thead>
		                <tr>
		                	<th class="no-sort">
			                    <input type="checkbox" data-value = "All" class="flat-red checkAll">
			                </th>
							<th class="no-sort">ردیف</th>
							<th>نوع کاربر</th>
							<th>نام و نام خانوادگی</th>
							<th>عنوان شرکت</th>
							<th>کد ملی</th>
							<th>موبایل</th>
							<th>ایمیل</th>
							<th>نام شهر</th>	
							<th>وضعیت</th>
							<th>جزئیات</th>
							<th>ویرایش</th>
							{{-- <th>نظرات</th> --}}
							<th>حذف</th>
		                </tr>
	                </thead>
	                <tbody>	
		                @foreach($users as $key=>$user)
		                {{-- {{ dump($user->subcity) }} --}}
			                <tr>
			                	<td>
				                    <input type="checkbox" data-value ="{{$user->id}}" class="flat-red checkbox">
			                	</td>
								<td class="no-sort">{{$loop->iteration}}</td>
								<td>@if(isset($user->companyName)) حقوقی @else حقیقی  @endif</td>
								<td>{{$user->name}} {{ $user->family }}</td>
								<td>
									@if(isset($user->companyName))
										{{$user->companyName}}
									@endif
								</td>
								<td>{{ $user->nationalCode }}</td>

								<td>{{ $user->mobile }}</td>
								<td>{{ $user->email }}</td>
								<td>شهرستان  {{ $user->subcity->name ?? '' }}  از استان  {{ $user->city->name ?? '' }} </td>
								<td>
									@if($user->isActive == 0)
										<a class="changeStatus" href="#" title="غیر فعال" data-id="{{$user->id}}"><i class="fas fa-close danger-color"></i></a> 
									@else
										<a class="changeStatus" href="#" title="فعال" data-id="{{$user->id}}"><i class="fas fa-check success-color"></i></a> 
									@endif
								</td>
								<td><a href="{{route('user.show',[$user])}}" class="btn btn-sm btn-outline-info btn-flat"><i class="fas fa-info-circle" style=""></i> جزئیات </a></td>
								<td><a href="{{route('user.edit',[$user])}}" class="btn btn-sm btn-outline-primary btn-flat"><i class="fas fa-edit"></i> ویرایش </a></td>
								{{-- <td></td> --}}

								<td>
									<form class="del-form" action="{{route('user.destroy', [$user])}}" method="post">
										@csrf
										@method('delete')
										<a href="#" data-id="{{$user->id}}" class="btn btn-sm btn-outline-danger btn-flat delete"><i class="fas fa-trash-alt"></i> حذف </a>
									</form>
								</td>
			                </tr>
			            @endforeach
	                </tbody>

	                <tfoot>
		                <tr>
		                	<th class="no-sort"></th>
							<th>ردیف</th>
							<th>نوع کاربر</th>
							<th>نام و نام خانوادگی</th>
							<th>عنوان شرکت</th>
							<th>کد ملی</th>
							<th>موبایل</th>
							<th>ایمیل</th>
							<th>نام شهر</th>	
							<th>وضعیت</th>
							<th>جزئیات</th>
							<th>ویرایش</th>
							{{-- <th>نظرات</th> --}}
							<th>حذف</th>
		                </tr>
	                </tfoot>
	            </table>
	            <div class="row">
	            	<a href="#" id="changeStatuse_group" class="btn btn-primary btn-flat">تغییر وضعیت</a>
	            	<a href="{{ route('user.export') }}" class="btn btn-flat btn-secondary mr-2	">ذخیره در فایل اکسل</a>
	            </div>
	            

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
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script>
<script>
	$(function () {

//------------------------------Data Table------------------------
		    $('.dataTable').DataTable({
		        "language": {
		            "paginate": {
		                "next": "بعدی",
		                "previous" : "قبلی",
		            },
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
		    });

//-----------------------change Statuse---------------------------
			$(document).on('click', '.changeStatus', function(event){
				event.preventDefault();
				var id = $(this).data("id");
				var url = "{{url('/user/changeStatus')}}";
				var $thiz = $(this);
				$.ajax({
				    type: 'GET',
				    url: url + "/" + id ,
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
//----------------------change Statuse group--------------------------
			$('#changeStatuse_group').click(function(event){
				event.preventDefault();
				var items = [];
				var url = "{{route('user.changeStatusGroup')}}"
		  		$("#dataTable-table").find("div[aria-checked='true']").children("input").each(function(index){
					items[index] = $(this).data("value");
					// $(this).closest('tr').fadeOut('slow');
				});

				// console.log(items);
			    $.ajax({
		            type:'POST',
		            url: url,
		            data: {
		              _token: '<?php echo csrf_token() ?>', // this is optional cause you already added it header
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
								var $thiz = $(this).parents("tr").find("a[class='changeStatus']").children("i");
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
	//---------------------------------------------------------------	    
		$(document).on('click', '.delete', function(event){
			event.preventDefault();
			var id = $(this).data("id");
			var thiz = $(this);
			var addr = $(this).parents(".del-form").attr("action");
			swal({
			  	title: "آیا از حذف این  کاربر مطمئن هستید؟",
				text: "این عمل غیرقابل برگشت می باشد.",
			  	icon: "warning",
			   	buttons: ["انصراف","حذف"],
			  	dangerMode: true,
			})
			.then((willDelete) => {
			  	if (willDelete) {
				  	$.ajax({
			            type:'POST',
			            url: addr,
			            data: {
			              _token: '<?php echo csrf_token() ?>',
			              _method : 'DELETE',
			              id: id ,
			            },
			            success:function(data){
			                // console.log(data);
			                // $("body").html(data);
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
			            }
		        	});
				}
			});
			
		});




	})
</script>
@endpush
