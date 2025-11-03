@extends('admin-layout')

@push('link')
@endpush

@section('title','مشاهده حزئیات پیام')

@section('main-content')
	<div class="card">
		<div class="card-header">
          <h3 class="card-title float-right"><span>جزئیات پیام {{ $messageStart->user->name }} {{ $messageStart->user->family }}</span></h3>
        </div>
		<div class="card-body">
			<div class="card">
				{{-- <div class="card-header">
		          <h3 class="card-title float-right"><span>پیغام های اعضای سایت</span></h3>
		        </div> --}}
		        <!-- /.card-header -->
		        <div class="card-body">
		        	<p>تاریخ : {{ Verta($messageStart->created_at)->format('%d %B، %Y') }}</p>
					<p>عنوان : {{ $messageStart->subject }}</p>
					<p>متن پیام : {{ $messageStart->message }}</p>
					<a href="{{ route('userMessage.index') }}" class="float-left" >بازگشت <i class="fa fa-chevron-left small"></i></a>
				</div>
			</div>
			@if($messageDetails->count() > 0)
				<table class="table border-less text-center">
					<tr>
						<th>ردیف</th>
						<th>تاریخ</th>
						<th>متن پیام</th>
						<th>وضعیت</th>
						<th>مشاهده</th>
						<th>حذف</th>
					</tr>
					
					@foreach($messageDetails as $key=>$message)	
						<tr class="@if($message->isRead  == 0 and $message->user_id != Auth::id()) text-bold @endif messageDetail  @if($message->user_id != Auth::id()) text-success @endif"  data-id="{{ $message->id }}" >
							<td>{{$loop->iteration}}</td>
							<td>{{ Verta($message->created_at)->format('%d %B، %Y') }}</td>
							<td>
								<p>
									{{ Str::limit($message->message,30) }}
								</p>
							</td>
							<td>@isset($message->deleted_at) <span class="text-danger">حذف شده</span> @endisset</td>
							<td>
								<a href="" class="messageRead text-success" data-id="{{ $message->id }}"><i class="far @if($message->user_id != Auth::id()) @if($message->isRead  == 0) fa-envelope  @else fa-envelope-open @endif @else fa-envelope-open @endif" data-toggle="modal" data-target="#messagetText{{ $key }}"></i></a>
							</td>
							<td>
								<a href="#" title="حذف پیام"  class="del-message" data-id="{{ $message->id }}"><i class="far fa-trash-alt"></i></a>
							</td>
						</tr>

						<div class="modal fade row text-regular" id="messagetText{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="messagetTextLabel" aria-hidden="true">
		                        <div class="modal-dialog modal-dialog-centered col-12" role="document">
		                            <div class="modal-content">
		                                <div class="modal-header">
		                                    <h6 class="modal-title" id="messagetTextLabel">
		                                    	تاریخ : {{ verta($message->created_at)->format('%d %B، %Y') }}
		                                    </h6>
		                                </div>
		                                <div class="modal-body">
		                    				{{-- <p>عنوان پیام : {{ $message->subject }}</p> --}}
		                    				<p>{{ $message->message }}</p>
		                                </div>
		                                <div class="modal-footer">
		                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
		                                </div>
		                            </div>
		                        </div>
		                    </div>

					@endforeach
					
				</table>
			@endif
			<form method="post" action="{{ route('user.saveAnswer',$messageStart) }}">
				@csrf
				<div class="form-group">
	            	<!-- <label for="answer">عنوان پیام</label> -->
					<textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" placeholder="" autofocus="autofocus">{{old('message')}}</textarea>
					@error('message')
					    <div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<input type="submit" class="btn btn-flat btn-primary" value="ارسال" name="storeAnswer">
			</form>
		</div>
	</div>
@endsection

@push('js')
  <script type="text/javascript">
  		$(function () {
			$(document).on('click', '.messageRead', function(event){
				event.preventDefault();
				var message_id = $(this).data('id');
				var url = document.location.origin + "/user/message/detail/read/";
				var $child = $(this).children('i');
				$(this).parents('tr').removeClass('text-bold');
				if($child.hasClass('fa-envelope'))
				{
					$child.removeClass('fa-envelope');
					$child.addClass('fa-envelope-open');
				}
				$.ajax({
			        type:'post',
			        url:url,
			        data: {
			          message_id : message_id,
			           _token: '<?php echo csrf_token() ?>',
			        },
			        success:function(data){
			            
			        }
			    })
			});


			$(document).on('click', '.del-message', function(event){
				event.preventDefault();
				var id = $(this).data("id");
				var thiz = $(this);
				var addr = "{{ route('userMessage.delMessage') }}";
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
  		})//End
  	
  </script>

@endpush