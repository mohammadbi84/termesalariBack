@extends("user.user-layout")

@push('link')
@endpush

@section("card-title","آدرس ها")
	
@section("user-content")
	<div class="row">
		@foreach($recipients as $recipient)
			<div class="col-sm-12 col-md-6 col-lg-4 recipientBox">
				<div class="card card-primary card-outline ml-3">
					<div class="card-header">
						<div class="card-title m-2" style="margin-right: 16px !important;">
							<h1 class="small">
								<i class="fa fa-user mr-1" title="نام و نام خانوادگی گیرنده"></i>
								<span class="mr-2">{{ $recipient->name }} {{ $recipient->family }}</span>
						</h1></div>
					</div>
					<div class="card-body" style="line-height: 1.8rem;">
						<div class="recipient_address row">
							<i class="fa fa-map-signs col-1" style="margin-top: 7px;"></i>
		                	<span class="col-11 text-right">
		                		{{ $recipient->subcity->city->name }}، {{ $recipient->subcity->name }}، {{ $recipient->address }}، پلاک {{ $recipient->houseId }}
		                	</span>
		                </div>
		                <div class="mt-2">
		                	<i class="fa fa-envelope m-1" title="کد پستی"></i>
		                	<span class="text-muted">{{ $recipient->zipcode }} <br></span>
		                	<i class="fa fa-phone m-1" aria-hidden="true" title="موبایل"></i>
		                	<span class="text-muted">{{ $recipient->mobile }}</span> 
		                	
		                </div>
					</div>
					<div class="card-footer">
						<a href="{{ route('recipient.edit',[$recipient]) }}" class="btn btn-outline-primary btn-flat btn-sm">ویرایش</a>
						<a href="{{route('recipient.destroy', [$recipient])}}" class="btn btn-outline-danger btn-flat btn-sm deleteRecipient">حدف</a>
					</div>
					
				</div>
			</div>
			
		@endforeach
	</div>
	

@endsection

@push('js')
	<script type="text/javascript">
		$(function(){

		$(document).on('click', '.deleteRecipient', function(event){
			event.preventDefault();
			// event.stopPropagation();
			var $thiz = $(this);
			var addr = $(this).attr("href");
			swal({
			  text: "آیا از حذف این گیرنده  مطمئن هستید؟",
			  title: "توجه",
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
			              _method : 'DELETE'
			            },
			            success:function(data){
			                $thiz.parents('.recipientBox').fadeOut("fast");
			                swal(title, data.message,data.res);
			            }
			        });
				}
			});
			
		});


		});//End
	</script>
@endpush
