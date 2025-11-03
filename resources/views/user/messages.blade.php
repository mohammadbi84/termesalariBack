@extends("user.user-layout")

@push('user-link')
	<style type="text/css">
		a.nav-link.active{
			border: 0;
			border-bottom: 1px solid #18d36e !important;
			color: #18d36e !important;
		}

		a.nav-link.active >i{
			color: #18d36e;
		}

		.nav-tabs .nav-link:focus, 
		.nav-tabs .nav-link:hover{
			border: 0px !important;
		}

		.nav-side-menu li a.myOrders , {
			color: red !important;
		}

		@media (min-width: 992px) {
		  .modal-dialog {
		    max-width: 70% !important;
		  }
		}
	</style>
@endpush

@section("card-title","پیغام ها")
	
@section("user-content")
<!-- Nav tabs -->
  	<nav class="nav nav-pills">
	    <a href="#newMessage" class="nav-item nav-link active" data-toggle="tab">
	        <i class="far fa-envelope pl-1" ></i>ارسال پیام
	    </a>
	    <a href="#messages" class="nav-item nav-link" data-toggle="tab">
	        <i class="fa fa-bars pl-1" ></i>لیست پیام ها
	    </a>
	</nav>


	<!-- Tab panes -->
	<div class="tab-content">
	    <div id="newMessage" class="container tab-pane active"><br>
	      	<div class="card">
	      		<div class="card-header">
	      			<div class="card-title">
	      				
	      			</div>
	      		</div>
	      		<div class="card-body">
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
	      			<form method="post" action="{{ route('user.messageStore') }}">
	      				@csrf
	      				<div class="form-group">
			            	<label for="subject">عنوان پیام</label>
							<input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="" value="{{old('subject')}}" autofocus="autofocus">
							@error('subject')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>
						<div class="form-group">
			            	<label for="message">متن پیام</label>
			            	<textarea name="message" class="form-control @error('message') is-invalid @enderror" placeholder="">{{old('message')}}</textarea>
							@error('message')
							    <div class="invalid-feedback">{{$message}}</div>
							@enderror
						</div>
						<input type="submit" name="save" class="btn btn-flat btn-primary" value="ارسال">
	      			</form>
	      			
	      		</div>
	      	</div>
	    </div>

	    <div id="messages" class="container tab-pane pt-4">
  			<table class="table text-center"><!-- table-hover -->
  				<tr>
  					<th>ردیف</th>
  					<th>تاریخ</th>
  					<th>عنوان </th>
  					<th>متن پیام</th>
  					<th>مشاهده</th>
  					<th>حذف</th>
  				</tr>
  				@foreach($userMessages as $key=>$message)
  					<tr class="@if($message->isRead  == 0 and $message->user_id != Auth::id()) text-bold @endif messageDetail"  data-id="{{ $message->id }}" >
  						<td>{{$loop->iteration}}</td>
  						<td>{{ Verta($message->created_at)->format('%d %B، %Y') }}</td>
  						<td>{{ $message->subject }}</td>
  						<td>
  							<p>
  								{{ Str::limit($message->message,30) }}
  							</p>
  						</td>
  						<td><a href="{{ route('user.messageDetail',[$message->id]) }}" class="text-success" title="مشاهده گفتگو"><i class="far @if($message->isRead  == 0 and $message->user_id != Auth::id()) fa-envelope  @else fa-envelope-open @endif"></i></a></td>
  						<td>
  							<a href="#" title="حذف گفتگو" style="font-size: 1.2rem" class="del-conversation" data-id="{{ $message->id }}"><i class="far fa-trash-alt"></i></a>
  						</td>
  					</tr>
  				@endforeach
  			</table>
	      		
	    </div>



	</div>



    



@endsection


@push('js')
<script type="text/javascript">
	$(function () {
	//---------------------Delete Conversation------------------------
		$(document).on('click', '.del-conversation', function(event){
			event.preventDefault();
			var id = $(this).data("id");
			var thiz = $(this);
			var addr = "{{ route('user.delConversation') }}";
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
			              // _method : 'DELETE',
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

	})//end
</script>

@endpush