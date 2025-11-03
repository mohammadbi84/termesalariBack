@extends('admin-layout')

@section('title','لیست سفارش های موفق')

@push('link')
	<!-- DataTables -->
 	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
 	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.css')}}">
	<style type="text/css">
		.datepicker-grid-view .header {
		    background-color: unset !important;
		    height: unset !important;
		    padding: unset !important;
		}
	</style>
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
		              	<h3 class="card-title float-right"><span>لیست سفارش ها</span></h3>
		            </div>
		            <!-- /.card-header -->
		            <div class="card-body">
		              	<table id="dataTable-table" class="table table-striped display nowrap dataTable text-center" style="width:100%;text-align: center;" cellspacing="0">
			                <thead>
				                <tr>
				                	<th class="no-sort">
					                    <input type="checkbox" data-value = "All" class="flat-red checkAll">
					                </th>
									<th class="no-sort">ردیف</th>
									<th>کد فاکتور</th>
									<th>تاریخ</th>
									<th>نام و نام خانوادگی</th>
									<th>گیرنده</th>
									<th>روش ارسال</th>
									<th>پرداختی</th>
									<th>روش پرداخت</th>
									<th>وضعیت</th>
									<th>اطلاعات پستی</th>
									<th>چاپ آدرس</th>
									<th class="no-sort">جزئیات</th>
									<th class="no-sort">حذف</th>
				                </tr>
			                </thead>
			                <tbody>	
				                @foreach($list as $key=>$item)
					                <tr>
					                	<td>
						                    <input type="checkbox" data-value ="{{ $item->order->id }}" class="flat-red checkbox">
					                	</td>
										<td class="no-sort">{{ $loop->iteration }}</td>
										<td>{{ $item->order->code }}</td>
										<td>{{ Verta($item->order->created_at)->format('%d %B %Y') }} - {{ $item->order->created_at->toTimeString() }}</td>
										<td>{{ $item->order->user->name }} {{ $item->order->user->family }}</td>
										<td>{{ $item->order->recipient->name }} {{ $item->order->recipient->family }}</td>
										<td>{{ $item->order->post->title }}</td>
										<td>
											@php 
												// $sum = 0;
												$total = 0;
												$price = 0;
												$off = 0;
												foreach ($item->order->orderitems as $orderitem) {
													$price = $price + ($orderitem->price * $orderitem->count);
													$off = $off + ($orderitem->offPrice * $orderitem->count);
													$total = $price - $off + $item->order->postPrice;
												}
													// dump($price);
												// $total = $total + $item->order->postPrice;
												if($item->order->discount_card_id != "")
					      						{
					      							if ($item->order->discountCard->type == "price")
			      										$total = $total - $item->order->discountCard->amount;

			      									elseif($item->order->discountCard->type == "percent")
			      										$total = $total - ($item->order->discountCard->amount * $price)/100 ;
					      						}
					      						
												// if(session()->has("discountCardPrice"))
		      				// 						$total = $total + $item->order->postPrice - session("discountCardPrice");
		      				// 					else
		      				// 						$total = $total + $item->order->postPrice;

												print number_format($total)." ".$item->order->local;
											@endphp
										</td>
										<td>
											{{ $item->payment_method->title }}
										</td>
										<td id="{{ $item->order->id }}">
											@if($item->order->status == 0)
												<a class="changeStatus" data-action="confirm" href="#" data-id="{{$item->order->id}}" title="تائید سفارش جهت ارسال"><i class="fas fa-check success-color"></i></a>&nbsp&nbsp&nbsp
												<a class="changeStatus" data-action="reject" href="#" data-id="{{$item->order->id}}" title="عدم تایید سفارش"><i class="fas fa-close danger-color"></i> </a>
												 
											@elseif($item->order->status == 1 and $item->order->post_code == "")
												<span class="badge badge-warning">تائید شد</span>

											@elseif($item->order->status == 2)
												<span class="badge badge-danger">رد شد</span>

											@elseif($item->order->post_code != "")
												<span class="badge badge-success">ارسال شد</span>

											@endif

										</td>
										<td>
											@if($item->order->status != '2')
												<a href="#" class="btn btn-flat btn-sm btn-outline-success postInfoSave" data-id="{{ $item->order->id }}" data-toggle="modal" data-target="#postForm" data-code="{{ $item->order->post_code }}" data-date="@if($item->order->post_date != "") {{ Verta($item->order->post_date)->format('Y-m-d H:m:s') }} @endif"><i class="fas fa-save"></i> ثبت</a>
											@endif

											
										</td>
										<td>
											<a href="{{ route('order.printAddress',$item->order->id) }}" class="btn btn-flat btn-sm btn-outline-success addressPrint" data-id="{{ $item->order->id }}"><i class="fas fa-print"></i> چاپ</a>
										</td>
										<td>
											<a href="{{ route('order.show',[$item->order]) }}" class="btn btn-sm btn-outline-info btn-flat"><i class="fas fa-info-circle" style=""></i> جزئیات </a>
										</td>
										<td>
											<form class="del-form" action="{{ route('order.destroy', [$item->order]) }}" method="post">
												@csrf
												@method('delete')
												<a href="#" data-id="{{ $item->order->id }}" class="btn btn-sm btn-outline-danger btn-flat delete"><i class="fas fa-trash-alt"></i> حذف </a>
											</form>
										</td>
					                </tr>
					            @endforeach
					            <div class="modal fade" id="postForm" tabindex="-1" role="dialog" aria-labelledby="postFormLabel" aria-hidden="true">
		                            <div class="modal-dialog modal-dialog-centered" role="document">
		                                <div class="modal-content">
		                                    <div class="modal-header">
		                                        <h5 class="modal-title" id="postFormLabel">
		                                        	ثبت اطلاعات مرسوله پستی
		                                        </h5>
		                                    </div>
		                                    <div class="modal-body">
		                                        <form role="form" method="post" id="postInfo">
		                                        	<div class="form-group">
														<label for="post_code">کد مرسوله</label>
														<input type="text" name="post_code" id="post_code" class="form-control @error('post_code') is-invalid @enderror" placeholder="این کد توسط اداره پست به مرسوله تخصیص یافته است ." value="" >
														@error('post_code')
														    <div class="invalid-feedback">{{$message}}</div>
														@enderror
													</div>

													<div class="form-group" style="z-index: 1050">
														<label for="post_date">تاریخ و ساعت تحویل مرسوله</label>
														<input type="text" name="post_date" id="post_date" class="form-control @error('post_date') is-invalid @enderror" placeholder="تاریخ و ساعت تحویل مرسوله به ادره پست را ثبت کنید ." value="" >
														@error('post_date')
														    <div class="invalid-feedback">{{$message}}</div>
														@enderror
													</div>

		                                        </form>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <a href="#" class="btn btn-flat btn-primary ml-2" id="savePostInfo" data-dismiss="modal" data-id="">ثبت</a>
		                                        <button type="button" class="btn  btn-flat btn-secondary" data-dismiss="modal">بستن</button>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
			                </tbody>

			                <tfoot>
				                <tr>
				                	<th></th>
				                	<th>ردیف</th>
									<th>کد فاکتور</th>
									<th>تاریخ</th>
									<th>نام و نام خانوادگی</th>
									<th>گیرنده</th>
									<th>روش ارسال</th>
									<th>پرداختی</th>
									<th>روش پرداخت</th>
									<th>وضعیت</th>
									<th>اطلاعات پستی</th>
									<th>چاپ آدرس</th>
									<th>جزئیات</th>
									<th>حذف</th>
				                </tr>
			                </tfoot>
		            	</table>
		            	<!-- <a href="#" id="changeStatuseGroup" class="btn btn-primary btn-flat">تغییر وضعیت</a> -->
		            	<a class="btn btn-flat btn-primary" id="printAddresses" href="#">چاپ آدرس</a>
		            </div>
		            <!-- /.card-body -->
	          	</div>
	          	<!-- /.card -->
	    	</div>
	    </div>
	</section>

@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/datepicker-master/persian-date.min.js')}}"></script>
    <script src="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.js')}}"></script>
	<script>
		$(function () {


		//------------------------------Data Table-----------------
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
		       	],
		    });

//-----------------------change Statuse---------------------------
			$(document).on('click', '.changeStatus', function(event){
				event.preventDefault();
				var id = $(this).data("id");
				var action = $(this).data("action");
				var url = "{{route('order.setStatus')}}";
				var $savePostButton = $(this).closest("tr").find("a.postInfoSave");
				$thiz = $(this);
				if (action == 'confirm') {
					title ="آیا از تایید این سفارش  مطمئن هستید؟";
				}
				else if (action == 'reject') {
					title ="آیا از رد کردن این سفارش  مطمئن هستید؟";
				}
				swal({
				  	title: title ,
					text: "این عمل غیرقابل بازگشت  می باشد.",
				  	icon: "warning",
				   	buttons: ["خیر","بله"],
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
						$.ajax({
						    type: 'POST',
						    url: url,
						    data: {
				              _token: '<?php echo csrf_token() ?>',
				              action: action,
				              id: id,
				            },
						    success: function(data){
						    	// $("body").html(data);
						        // console.log(data);
						        // var $span = $thiz.children("span");
						        if(action == 'confirm')
						        {
						        	$thiz.parent().html('<span class="badge badge-warning">تائید شده</span>');
						        }
						        else if (action == 'reject')
						        {
						        	$thiz.parent().html('<span class="badge badge-danger">رد شد</span>');
						        	$savePostButton.parent().text("");	
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
					}
				});
			});

			//------------------------change Statuse group--------------------
			// $('#changeStatuseGroup').click(function(event){
			// 	event.preventDefault();
			// 	var items = [];
			// 	var url = "{{route('order.changeStatusGroup')}}"
		 //  		$("#dataTable-table").find("div[aria-checked='true']").children("input").each(function(index){
			// 		items[index] = $(this).data("value");
			// 	});
			//     $.ajax({
		 //            type:'POST',
		 //            url: url,
		 //            data: {
		 //              _token: '<?php echo csrf_token() ?>', // this is optional cause you already added it header
		 //              items: items,
		 //            },
		 //            success:function(data){
		 //               	if(data.res == "error")
			// 	        {
			// 	        	title = "خطا  در اجرای عملیات" ;
			// 	        }
			// 	        else if(data.res == "success")
			// 	        {
			// 	        	title = "عملیات با موفقیت انجام شد.";
			// 	        	$("#dataTable-table").find("div[aria-checked='true']").each(function(index)
			// 	        	{
			// 	        		$(this).find('.icheckbox_flat-blue').iCheck('uncheck');
			// 					$(this).removeClass("bg-skyblue");
			// 					var $thiz = $(this).parents("tr").find("a[class='changeStatus']").children("span");
			// 					if($thiz.hasClass("badge-success"))
			// 			        {
			// 			        	$thiz.removeClass("badge-success");
			// 			        	$thiz.addClass("badge-warning");
			// 			        	$thiz.text("در حال پردازش");
			// 			        }
			// 			        else if ($thiz.hasClass("badge-warning"))
			// 			        {
			// 			        	$thiz.removeClass("badge-warning");
			// 			        	$thiz.addClass("badge-success");
			// 			        	$thiz.text("ارسال شده");
			// 			        }
								
			// 				});

			// 	        }
			// 	        swal(title, data.message,data.res);
		 //            }
		 //        });
			// });
	//---------------------------------------------------------------	    
		$(document).on('click', '.delete', function(event){
			event.preventDefault();
			var id = $(this).data("id");
			var thiz = $(this);
			var addr = $(this).parents(".del-form").attr("action");
			swal({
			  	title: "آیا از حذف این  سفارش  مطمئن هستید؟",
				text: "این عمل غیرقابل بازگشت  می باشد.",
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
					        }
					        swal(title, data.message,data.res);
					        thiz.closest("tr").fadeOut('slow');
			            }
		        	});
				}
			});
			
		});
		//-------------------------------------------------------------
		dateValue = $('#post_date').val();
		pd = $('#post_date').pDatepicker({
        	onlySelectOnDate : true ,
        	autoClose : true ,
        	responsive : true ,
        	initialValueType: 'gregorian',
        	persianDigit: false,
			format: 'YYYY/MM/DD H:m:s',
			defaultDate:"",
			// container: '#postForm modal-body',
        	timePicker : {
        		"enabled" : true ,
        	} ,
        	monthPicker : {
        		"enabled" : true ,
        		"titleFormat" : "YYYY" ,
        	} ,
        	yearPicker : {
        		"enabled" : true ,
        		"titleFormat" : "YYYY" ,
        	} ,
        });

        $('#post_date').val(dateValue);
        var $saveBtn;

		$(document).on('click', '.postInfoSave', function(event){
			event.preventDefault();
			$saveBtn= $(this);
			$("#postForm").find(".invalid-feedback").text("");
			$("#postForm").find("input").removeClass("is-invalid").val("");
			var order_id = $(this).data('id');
			$("#savePostInfo").attr('data-id',order_id);
			$('.loader').show();
			$.ajax({
	            type:'post',
	            url: '{{ route("order.getPostInfo") }}',
	            data: {
	              	_token: '<?php echo csrf_token() ?>',
					order_id: order_id,
	            },
	            success:function(data){
	            	// console.log(data);
	            	var post_code = data.code;
					var post_date = data.date;
					$("#postForm").find('#post_code').val(post_code).focus();
					$("#postForm").find('#post_date').val(post_date);
				   	return true;
	            },
			    complete: function(){
			        $('.loader').hide();
			    }
	        });
			
		});

		$("#savePostInfo").click(function(event){
			event.preventDefault();
			$("#postForm").find(".invalid-feedback").text("");
			$("#postForm").find("input").removeClass("is-invalid");
			codeInput = $("#postForm").find("#post_code");
			dateInput = $("#postForm").find("#post_date");
			var post_code = codeInput.val();
			var post_date = dateInput.val();
			var order_id = $(this).data('id');
			if(post_code == "" || isNaN(post_code) == true)
			{
				codeInput.addClass("is-invalid").focus();
				codeInput.after('<div class="invalid-feedback">لطفا کد مرسوله را یه صورت عددی وارد کنید .</div>');
				return false;
				event.preventDefault();
			}

			if(post_date == "")
			{
				dateInput.addClass("is-invalid").focus();
				dateInput.after('<div class="invalid-feedback">لطفا تاریخ تحویل مرسوله به اداره پست را وارد کنید .</div>');
				return false;
				event.preventDefault();
			}
			$('.loader').show();
			$.ajax({
	            type:'POST',
	            url: '{{ route("order.savePostInfo") }}',
	            data: {
	              	_token: '<?php echo csrf_token() ?>',
	              	post_code : post_code,
					post_date : post_date,
					order_id : order_id,
	            },
	            success:function(data){
	            	$saveBtn.attr("data-code",post_code);
	            	$saveBtn.attr("data-date",data);
	            	$('.table').find('td[id='+ order_id +']').html('<span class="badge badge-success">ارسال شد</span>');
				   	return true;
	            },
			    complete: function(){
			        $('.loader').hide();
			    }
	        });

		});

// -----------------------------------------------------------

		/*$(".addressPrint").click(function(event){
			event.preventDefault();
			var id = $(this).data("id");

			$.ajax({
	            type:'post',
	            url: '{{ route("order.printAddress") }}',
	            data: {
	              	_token: '<?php echo csrf_token() ?>',
					id: id,
	            },
	            success:function(data){

	            }
	        });
		})*/

//-------------------------------------------------------------------

		$('#printAddresses').click(function(event){
			var items = [];
	  		$("#dataTable-table").find("div[aria-checked='true']").children("input").each(function(index){
				items[index] = $(this).data("value");
			});
			// console.log(items.length);
			if (items.length < 1) {
				swal("خطا در انجام عملیات", "لطفا ابتدا سطرهای مورد نظر را انتخاب کنید.","error");
				return false;
			}
			else{
				var data = encodeURIComponent(JSON.stringify(items));
				var url = document.location.origin +"/order/printAddresses/"+data;
				$(this).attr("href",url);
				return true;
			}
		});
//------------------------------------------------

	})//END
	</script>

@endpush