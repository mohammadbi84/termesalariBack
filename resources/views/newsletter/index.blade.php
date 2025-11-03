@extends('admin-layout')

@section('title','پنل مدیریت | لیست اعضای خبرنامه')

@push('link')
	<!-- DataTables -->
 	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
 	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
	<style type="text/css">
		a.nav-link.active{
			border: 0;
			border-bottom: 3px solid #0772d1 !important;
			color: #0772d1 !important;
		}

		a.nav-link.active >i{
			color: #0772d1;
		}

		.nav-tabs .nav-link:focus, 
		.nav-tabs .nav-link:hover{
			border: 0px !important;
		}

		.nav-side-menu li a.myOrders , {
			color: red !important;
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
		              	<h3 class="card-title"><span>لیست اعضای خبرنامه</span></h3>
		            </div>

		            <div class="card-body ">
		            	<!-- Nav tabs -->
					  	<nav class="nav nav-pills">
					  		<a href="#email-newsletter" class="nav-item nav-link active" data-toggle="tab">
						        اعضای خبرنامه ایمیلی@if($email_newsletters->total() > 0)({{ $email_newsletters->total() }}) @endif
						    </a>
						    <a href="#mobile-newsletter" class="nav-item nav-link" data-toggle="tab">
						        اعضای خبرنامه پیامکی@if($mobile_newsletters->total() > 0)({{ $mobile_newsletters->total() }}) @endif
						    </a>
						</nav>
						<!-- Tab panes -->
  						<div class="tab-content">
  							<div id="email-newsletter" class="container tab-pane fade show active"><br>
				            	<div class="row">
									@foreach($email_newsletters as $newsletter)
										<div class="col-md-3 col-sm-6 newsletter-box">
											<div class="card">
												<div class="card-body text-center">
													{{ $newsletter->email }}
												</div>
												<div class="card-footer">
													<div class="float-right">{{ Verta($newsletter->created_at)->format('%d %B %Y') }}</div>
													
														<form class="del-form" action="{{route('newsletter.destroy', [$newsletter])}}" method="post">
															@csrf
															@method('delete')
															<a href="#" class="float-left  delete" data-id="{{ $newsletter->id }}" title="حذف"><i class="fas fa-trash-alt"></i>  </a>
														</form>
												</div>
											</div>
										</div>
									@endforeach
								</div>
								<div class="row">
									<div class="m-auto pt-5">{{ $email_newsletters->appends(['email_newsletters' => $email_newsletters->currentPage()])->links() }}</div>
								</div>
								<div class="row">
									<a href="{{ route('newsletter.create') }}" class="btn btn-flat btn-primary float-left ml-4 " title="ارسال خبرنامه جدید">ارسال ایمیل به همه</a>
									<a href="{{ route('newsletter.emails.export') }}" class="btn btn-flat btn-secondary">ذخیره در فایل اکسل</a>
								</div>
							</div>
							<div id="mobile-newsletter" class="container tab-pane fade "><br>
				            	<div class="row">
									@foreach($mobile_newsletters as $newsletter)
										<div class="col-md-3 col-sm-6 newsletter-box">
											<div class="card">
												<div class="card-body text-center">
													{{ $newsletter->mobile }}
												</div>
												<div class="card-footer">
													<div class="float-right">{{ Verta($newsletter->created_at)->format('%d %B %Y') }}</div>
													
														<form class="del-form" action="{{route('newsletter.destroy', [$newsletter])}}" method="post">
															@csrf
															@method('delete')
															<a href="#" class="float-left  delete" data-id="{{ $newsletter->id }}" title="حذف"><i class="fas fa-trash-alt"></i>  </a>
														</form>
												</div>
											</div>
										</div>
									@endforeach
								</div>
								<div class="row">
									<div class="m-auto pt-5">{{ $mobile_newsletters->appends(['mobile_newsletters' => $mobile_newsletters->currentPage()])->links() }}</div>
								</div>
								<div class="row">
									<div class="float-right"><a href="{{ route('newsletter.mobiles.export') }}" class="btn btn-flat btn-secondary">ذخیره در فایل اکسل</a></div>
								</div>
							</div>
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
		//-------------------Delete------------------
		$(document).on('click', '.delete', function(event){
			event.preventDefault();
			var id = $(this).data("id");
			var thiz = $(this);
			var addr = thiz.parents('.del-form').attr('action');
			swal({
			  title: "آیا از حذف این عضو خبرنامه مطمئن هستید؟",
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
			              id: id 
			            },
			            success:function(data){
			                if(data.res == "error")
					        {
					        	title = "خطا  در اجرای عملیات" ;
					        }
					        else if(data.res == "success")
					        {
					        	title = "عملیات با موفقیت انجام شد.";
					        	thiz.closest(".newsletter-box").fadeOut('slow');
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