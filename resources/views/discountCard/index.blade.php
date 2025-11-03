@extends('admin-layout')

@section('title','کدهای تخفیف')

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

			<div class="card">
            <div class="card-header">
              	<a href="{{ route('discountCard.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="کد تخفیف جدید">+</a>
              	<h3 class="card-title float-right">
              		<span>
              			لیست  کدهای تخفیف
              		</span>
              	</h3>
            </div>
            <!-- /.card-header -->
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
						<th>کد  تخفیف</th>
						<th>نوع دسترسی</th>
						<th>دفعات قابل استفاده</th>
						<th>نحوه اعمال</th>
						<th>مقدار</th>
						<th>تاریخ و ساعت اعمال</th>
						<th>تاریخ و ساعت انقضا</th>
						<th>هدیه شد</th>
						<th>استفاده کننده</th>
						<th>فاکتور</th>
						<th class="no-sort">ویرایش</th>
						<th class="no-sort">حذف</th>
	                </tr>
                </thead>
                <tbody class="text-center">
                	
                @foreach($discountCards as $key=>$discountCard)
                
	                <tr 
	                @php
	                	date_default_timezone_set('Asia/Tehran');
		                $startDate = verta($discountCard->start_date);
		                $expireDate = verta($discountCard->expire_date);
		                $now = verta(now());
		                if ($now->lt($startDate)){
		                    print 'class="text-warning"';
		                }
		                elseif ($now->gt($expireDate)) {
		                    print 'class="text-danger"';
		                }
		                elseif($now->between($startDate,$expireDate))
		                {
	                		print 'class="text-success"';
	                	}
	                @endphp
	                >
	                	<td>
	                		<label>
		                    	<input type="checkbox" data-value = "{{ $discountCard->id }}" class="flat-red checkbox">
		                  	</label>
	                	</td>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $discountCard->code }}</td>
						<td>
							@if($discountCard->type_scope == 'private')
								خصوصی
							@elseif($discountCard->type_scope == 'public')
								عمومی
							@endif
						</td>
						<td>{{ $discountCard->count_usable }}</td>
						<td>
							@if($discountCard->type_amount == 'percent')
								درصدی
							@else
								مقدار ثابت
							@endif
						</td>
						<td>
							@if($discountCard->type_amount == 'percent')
								{{ $discountCard->amount }} درصد
							@else
								{{ number_format($discountCard->amount) }} تومان
							@endif
						</td>
						<td>{{ Verta($discountCard->start_date)->format('%d %B %Y H:m:s') }}</td>
						<td>{{ Verta($discountCard->expire_date)->format('%d %B %Y H:m:s') }}</td>
						<td class="text-center">
							@if($discountCard->is_gifted == 0)
								<a class="changeIsGifted" href="#" data-id="{{$discountCard->id}}"><i class="fas fa-close danger-color"></i></a> 
							@else
								<a class="changeIsGifted" href="#" data-id="{{$discountCard->id}}"><i class="fas fa-check success-color"></i> </a>
							@endif
						</td>
						<td>
							@if($discountCard->orders->count() > 0)
								@if($discountCard->orders->count() == 1)
									<a class="text-danger" href="{{ route('user.show',[$discountCard->orders->first()->user->id]) }}">{{ $discountCard->orders->first()->user->name }} {{ $discountCard->orders->first()->user->family }}</a>
								@else
									<span class="text-danger">{{ $discountCard->orders->count() }} کاربر</span>
								@endif
							@else
								<span class="text-secondary">استفاده نشده</span>
							@endif
						</td>
						<td>
							@php
							if($discountCard->orders->count() > 0)
							{
								$orders = $discountCard->orders;
								foreach($orders as $order){
							@endphp
									<a href="{{ route('order.show',[$order->id]) }}">{{ $order->code }}</a>
							@php
								if($discountCard->orders->count() > 1)
									print ' / ';
								}
							}
							else
								print '<span class="text-danger">-</span>';
							@endphp
						</td>
						<td>
							<a href="{{route('discountCard.edit',[$discountCard])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش </a>
						</td>
						<td>
							<form class="del-form" action="{{route('discountCard.destroy', [$discountCard])}}" method="post">
								<a href="#" data-id="{{$discountCard->id}}"  class="btn btn-outline-danger btn-flat btn-sm delete"><i class="fas fa-trash-alt"></i> حذف </a>
							</form>
						</td>
	                </tr>
	            @endforeach
                </tbody>

                <tfoot>
	                <tr>
	                	<th></th>
	                  	<th class="no-sort">ردیف</th>
						<th>کد  تخفیف</th>
						<th>نوع دسترسی</th>
						<th>دفعات قابل استفاده</th>
						<th>نحوه اعمال</th>
						<th>مقدار</th>
						<th>تاریخ و ساعت اعمال</th>
						<th>تاریخ و ساعت انقضا</th>
						<th>هدیه شد</th>
						<th>استفاده کننده</th>
						<th>فاکتور</th>
						<th class="no-sort">ویرایش</th>
						<th class="no-sort">حذف</th>
	                </tr>
                </tfoot>
              </table>
              <div class="buttons">
              	<a href="#" id="deleteGroup" class="btn btn-primary btn-flat">حذف</a>
              	<a href="#" id="changeIsGiftedGroup" class="btn btn-primary btn-flat">هدیه شد</a>
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

	<!-- page script -->
<script>
$(function(){
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
	       	// { "width": "30%", "targets": 11 }
       	],
    });

//--------------------Delete Product-----------------------------
	$(document).on('click', '.delete', function(event){
		event.preventDefault();
		event.stopPropagation();
		var id = $(this).data("id");
		var thiz = $(this);
		var addr = thiz.parents('.del-form').attr('action');
		swal({
		  title: "آیا از حذف این کد تخفیف مطمئن هستید؟",
		  text: "این کار غیر قابل بازگشت می باشد.",
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


	$("#deleteGroup").click(function(){
		event.preventDefault();
		var items = [];
		$("#dataTable-table").find("div[aria-checked='true']").children("input").each(function(index){
			items[index] = $(this).data("value");
		});
		var thiz = $(this);
		var addr = document.location.origin + "/discountCard/deleteGroup";
		swal({
		  title: "آیا از حذف این کد تخفیف مطمئن هستید؟",
		  text: "این کار غیر قابل بازگشت می باشد.",
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
				        		$(this).closest("tr").fadeOut('slow');
							});
				        }
				        swal(title, data.message,data.res);
		            }
	        	});
			}

		});
	});
//---------------------------------------------------------
$(document).on('click', '.changeIsGifted', function(event){
		event.preventDefault();
		var url = "{{ route('discountCard.changeIsGifted') }}";
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
		        if(data.res == "error")
		        {
		        	title = "خطا  در اجرای عملیات" ;
		        }
		        else if(data.res == "success")
		        {
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
		        	title = "عملیات با موفقیت انجام شد.";
		        }
		        swal(title, data.message,data.res);
		    }
		});
	});
//----------change Is Gifted group--------------------------------
	$('#changeIsGiftedGroup').click(function(event){
		event.preventDefault();
		var items = [];
		var url = "{{ route('discountCard.changeIsGiftedGroup') }}"
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
						var $thiz = $(this).parents("tr").find("a[class='changeIsGifted']").children("i");
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


})//End

</script>
@endpush