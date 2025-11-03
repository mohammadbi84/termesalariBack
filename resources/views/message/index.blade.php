@extends('admin-layout')
@push('link')
	<!-- DataTables -->
 	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
 	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
@endpush

@section('title','پیام ها')

@section('main-content')
	<section class="content">

		<div class="card">
        <div class="card-header">
          <h3 class="card-title float-right"><span>پیام ها</span></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

        	<nav class="nav nav-pills">
			    <a href="#userMessages" class="nav-item nav-link active" data-toggle="tab">
			        {{-- <i class="fa fa-envelope pl-1" ></i> --}}پیام های اعضای سایت
			    </a>
			    <a href="#messages" class="nav-item nav-link" data-toggle="tab">
			        {{-- <i class="fa fa-bars pl-1" ></i> --}}پیام های بازدیدکنندگان
			    </a>
			</nav>



			<!-- Tab panes -->
			<div class="tab-content">
			    <div id="userMessages" class="container tab-pane active"><br>
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
			      	@if($userMessages->count() > 0)
						<table class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0" id="dataTable-table">
	                		<thead>
								<tr>
									<th class="no-sort">
				                		<label>
					                    	<input type="checkbox" data-value = "All" class="flat-red checkAll">
					                  	</label>
					                </th>
									<th class="no-sort">ردیف</th>
									<th>نام و نام خانوادگی</th>
									<th>تاریخ</th>
									<th>عنوان</th>
									<th>پیغام</th>
									<th>وضعیت</th>
									<th class="no-sort">مشاهده</th>
									<th class="no-sort">حذف</th>
								</tr>
							</thead>
							<tbody>
								@foreach($userMessages as $message)

									<tr class="@if($message->isRead  == 0 and $message->user_id != Auth::id()) text-bold @endif messageDetail "  data-id="{{ $message->id }} ">
										<td>
					                		<label>
						                    	<input name="selectUserMessage[]" form="delGroupForm" type="checkbox" value = "{{$message->id}}" class="flat-red checkbox">
						                  	</label>
					                	</td>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $message->user->name }} {{ $message->user->family }}</td>
										<td>{{ Verta($message->created_at)->format('%d %B، %Y') }}</td>
										<td>{{ Str::limit($message->subject,20) }}</td>
										<td>{{ Str::limit($message->message,20) }}</td>
										<td>@if(isset($message->deleted_at)) <span class="text-danger">حذف شده</span> @else - @endif</td>
										<td><a href="{{ route('userMessage.show',[$message]) }}" class="text-success"><i class="far @if($message->isRead  == 0 and $message->user_id != Auth::id()) fa-envelope  @else fa-envelope-open @endif"></i></a></td>
										<td>
											<form method="post" action="{{ route('userMessage.destroy',[$message]) }}" class="del-form">
				  								@method('delete')
				  								@csrf
				  								<a href="#" title="حذف گفتگو" class="del-conversation" data-id="{{ $message->id }}"><i class="far fa-trash-alt"></i></a>
				  							</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<form method="post" id="delGroupForm" action="{{ route('userMessage.delUserMessageGroup') }}">
				    		@csrf
							<input type="submit" id="delUserMessageGroupBtn" class="btn btn-flat btn-primary" value="حذف"  >
						</form>
					@else
						<p class="text-center text-danger">داده ای برای نمایش وجود ندارد.</p>
					@endif
				</div>

				<div id="messages" class="container tab-pane pt-4">
					@if($messages->count() > 0)
						<table class="table table-striped display nowrap " style="text-align: center;" cellspacing="0" id="dataTable-messages">
	                		<thead>
								<tr>
									<th class="no-sort">
					                    <input  type="checkbox" data-value = "All" class="flat-red checkAll">
					                </th>
									<th class="no-sort">ردیف</th>
									<th>تاریخ</th>
									<th>موبایل</th>
									<th>پیغام</th>
									<th class="no-sort">مشاهده</th>
									<th class="no-sort">حذف</th>
								</tr>
							</thead>
							<tbody>
								@foreach($messages as $key=>$message)

									<tr class="@if($message->isRead  == 0) text-bold @endif messageDetail "  data-id="{{ $message->id }} ">
										<td>
						                    <input name="selectMessage[]" form="delGroupMessageForm" type="checkbox" value = "{{$message->id}}" class="flat-red checkbox">
					                	</td>
										<td>{{ $loop->iteration }}</td>
										<td>{{ Verta($message->created_at)->format('%d %B، %Y') }}</td>
										<td>{{ $message->mobile }}</td>
										<td>{{ Str::limit($message->message,20) }}</td>
										<td>
											<a href="{{ route('message.show',[$message]) }}" class="text-success messageShow" data-id="{{ $message->id }}"  data-toggle="" data-target="#messageText{{$key}}"><i class="far @if($message->isRead  == 0) fa-envelope  @else fa-envelope-open @endif "></i></a>

											<div class="modal fade" id="messageText{{$key}}" tabindex="-1" role="dialog" aria-labelledby="messageTextLabel" aria-hidden="true">
					                            <div class="modal-dialog modal-dialog-centered" role="document">
					                                <div class="modal-content">
					                                    <div class="modal-header">
					                                        <h5 class="modal-title" id="messageTextLabel">
																{{$message->mobile}}
					                                        </h5>
					                                    </div>
					                                    <div class="modal-body">
					                                        <p>{{$message->message}}</p>

					                                    </div>
					                                    <div class="modal-footer">
					                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
					                                    </div>
					                                </div>
					                            </div>
					                        </div>

										</td>
										<td>
											<form method="post" action="{{ route('message.destroy',[$message]) }}" class="del-form">
				  								@method('delete')
				  								@csrf
				  								<a href="#" title="حذف پیام" class="del-message" data-id="{{ $message->id }}"><i class="far fa-trash-alt"></i></a>
				  							</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<form method="post" id="delGroupMessageForm" action="{{ route('message.delMessageGroup') }}">
				    		@csrf
							<input type="submit" id="delMessageGroupBtn" class="btn btn-flat btn-primary" value="حذف"  >
						</form>
					@else
						<p class="text-center text-danger">داده ای برای نمایش وجود ندارد.</p>
					@endif
				</div>

			</div>

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
  	<script type="text/javascript">
  		$(function () {

			$(document).on('click', '.messageShow', function(event){
  				event.preventDefault();
				var id = $(this).data("id");
				// var thiz = $(this);
				$(this).closest("tr").removeClass('text-bold');
		        $(this).children("i").removeClass('fa-envelope').addClass('fa-envelope-open');
		        $(this).attr('data-toggle','modal');
				$.ajax({
		            type:'GET',
		            url: $(this).attr("href"),
		            data: {
		              _token: '<?php echo csrf_token() ?>',
		              id: id ,
		            },
	        	});
  			});
  			//--------------------Data Table----------------------------
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


		    $('#dataTable-messages').DataTable({
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
		       	"order":[],
		       	"columnDefs":[
			       	{ "targets":'no-sort',"orderable":false,},
			       	// { "width": "10%", "targets": 9 }
		       	],
		    });
//-----------------------Delete Conversation--------------------
		$(document).on('click', '.del-conversation', function(event){
			event.preventDefault();
			var id = $(this).data("id");
			var thiz = $(this);
			var addr = thiz.parents('.del-form').attr('action');
			swal({
			  	title: "آیا از حذف این پیام مطمئن هستید؟",
			  	text: "با حذف این پیام تمام گفتگوهای مربوط به آن حذف خواهد شد.",
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

	//----------------------Delete Message-----------------------------
			$(document).on('click', '.del-message', function(event){
				event.preventDefault();
				var id = $(this).data("id");
				var thiz = $(this);
				var addr = thiz.parents('.del-form').attr('action');
				swal({
				  	title: "آیا از حذف این پیام مطمئن هستید؟",
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
						        }
						        swal(title, data.message,data.res);
						        thiz.closest("tr").fadeOut('slow');
				            }
			        	});
					}
				});
				
			});

			//---------------------Delete Conversation--------------------
			$("#delUserMessageGroupBtn").click(function(event){
				event.preventDefault();
				swal({
				  	title: "مطمئن هستید که می خواهید پیام های انتخابی حذف شوند؟",
				  	text: "با حذف این پیام ها تمام گفتگوهای مربوط به آن ها حذف می شود.",
				  	icon: "warning",
				   	buttons: ["انصراف","حذف"],
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
			        	$("#delUserMessageGroupBtn").unbind('click').click(); 
			        	
					}
				});
				
			});


			//----------------------Delete Group Message--------------
			$("#delMessageGroupBtn").click(function(event){
				event.preventDefault();
				swal({
				  	title: "مطمئن هستید که می خواهید پیام های انتخابی حذف شوند؟",
				  	text: "این عمل غیرقابل برگشت می باشد.",
				  	icon: "warning",
				   	buttons: ["انصراف","حذف"],
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
			        	$("#delMessageGroupBtn").unbind('click').click(); 
					}
				});
				
			});


  		})//End
  	
  </script>

@endpush