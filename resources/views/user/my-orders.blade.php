@extends("user.user-layout")

@push('user-link')
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

@section('title','سفارش های من')
@section("card-title","تاریخچه سفارش ها")
	
@section("user-content")

  <!-- Nav tabs -->
  	<nav class="nav nav-pills">
  		<a href="#processingOrders" class="nav-item nav-link text-warning active" data-toggle="tab">
	        <i class="fa fa-cog" style="font-size: 1.2rem;" ></i> در حال پردازش
	    </a>
	    <a href="#postedOrders" class="nav-item nav-link text-success" data-toggle="tab">
	        <i class="fa fa-check-circle" aria-hidden="true" style="font-size: 1.2rem;"></i> ارسال شده
	    </a>
	    <a href="#rejectOrders" class="nav-item nav-link text-danger" data-toggle="tab">
	        <i class="fa fa-times-circle" aria-hidden="true" style="font-size: 1.2rem;"></i> رد شده
	    </a>
	    <a href="#unsuccessOrders" class="nav-item nav-link" data-toggle="tab" style="color: #000 ;">
	        <i class="fas fa-exclamation-triangle" aria-hidden="true" style="font-size: 1.2rem;"></i> پرداخت ناموفق
	    </a>
	</nav>

  <!-- Tab panes -->
  	<div class="tab-content">
	  	@php 
	  		$orders = $successOrders;
	  		// dd($SuccessOrders);
	  	@endphp


	    <div id="processingOrders" class="container tab-pane active"><br>
	    	@isset($successOrders)
		      	@foreach($successOrders as $order)
		      		@if($order->status == '0' or ($order->status == '1' and $order->post_code == ""))
				      	<div class="card">
				      		<div class="card-header">
				      			<div class="row p-2" style="font-weight: bold;">

				      				<div class="col-md-3 col-sm-12 mb-4">
				      					کد  فاکتور : 
				      					{{ $order->code }}
				      				</div>

				      				<div class="col-md-4 col-sm-12 mb-4">
				      					تاریخ  : 
				      					{{ Verta($order->created_at)->format('%d %B %Y') }} - {{ $order->created_at->toTimeString() }}
				      				</div>

				      				<div class="col-md-4 col-sm-12 mb-4">
				      					پرداختی : 
				      					@php
				      						$sumOff = 0;
				      						$sumPay = 0;
				      						$sumPrice = 0;
				      						foreach($order->orderitems as $orderitem)
				      						{
				      							$sumPay = $sumPay + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
				      							$sumOff = $sumOff + ($orderitem->offPrice * $orderitem->count);
				      							$sumPrice = $sumPrice + ($orderitem->count * $orderitem->price);
				      						}
				      						$sumPay = $sumPay + $order->postPrice;
				      						if($order->discount_card_id != "")
				      						{
				      							if ($order->discountCard->type == "price")
		      										$sumPay = $sumPay - $order->discountCard->amount;

		      									elseif($order->discountCard->type == "percent")
		      										$sumPay = $sumPay - ($order->discountCard->amount * $sumPrice)/100 ;
				      						}




				      						// $sum = 0;
				      						// foreach($order->orderitems as $orderitem)
				      						// {
				      						// 	$sum = $sum + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
				      						// }
				      						// if(session()->has("discountCardPrice"))
				      						// 	$sum = $sum + $order->postPrice - session("discountCardPrice");
				      						// else
				      						// 	$sum = $sum + $order->postPrice;
				      						print number_format($sumPay) . " " . $order->local;

				      					@endphp
				      				</div>

				      				<div class="col-md-1 col-sm-12 mb-4 collapse-icon text-danger" style="cursor: pointer;" data-toggle="collapse" data-target="#order{{$order->id}}" aria-expanded="true" aria-controls="order{{$order->id}}" >
				      					<div class="link font-weight-normal">جزئیات  <i class="fa fa-chevron-down" style="font-size: 0.7rem" ></i></div>
				      				</div>
				      				
				      				
				      			</div>
				      		</div>
				      		<div id="order{{$order->id}}" class="card-body collapse" style="font-size: 90%;overflow-x: auto;">
				      			<table class="table w-10" style="font-size: 95%">
				      				<tr>
				      					<th>ردیف</th>
				      					<th>عنوان  محصول</th>
				      					<th>تعداد</th>
				      					<th>مبلغ</th>
				      					<th>تخفیف</th>
				      					<th>پرداختی</th>
				      					
				      				</tr>
				      				@foreach($order->orderitems as $orderitem)
				      					<tr>
				      						<td>{{ $loop->iteration }}</td>
				      						<td>
				      							@php $image = $orderitem->orderitemable->images->first(); @endphp
				      							<img src="{{asset('storage/images/thumbnails/'. $image['name'])}}" alt="" class="img-circle img-size-50 mr-2">
				      							{{ $orderitem->orderitemable->category->title }} طرح {{ $orderitem->orderitemable->color_design->design->title }} رنگ {{ $orderitem->orderitemable->color_design->color->color }}
				      						</td>
				      						<td>{{ $orderitem->count }}</td>
				      						<td>{{ number_format($orderitem->price) }} {{ $order->local }}</td>
				      						<td>{{ number_format($orderitem->offPrice) }} {{ $order->local }}</td>
				      						<td>{{ number_format($orderitem->price - $orderitem->offPrice) }} {{ $order->local }}</td>
				      					</tr>
				      				@endforeach
				      			</table>
				      			@php

		      					@endphp
		      					<div class="row mt-4">
		      						
			      					<div class="col-sm-12 col-md-3 mb-4 text-center">
			      						<span class="text-bold mb-4">جمع کل </span>
			      						<p>{{ number_format($sumPrice) }} {{ $order->local }}</p>
			      					</div>
			      					<div class="col-sm-12 col-md-3 mb-4 text-center">
			      						<span class="text-bold mb-4">جمع تخفیف </span>
			      						<p>{{ number_format($sumOff) }} {{ $order->local }}</p>
			      					</div>
			      					@if($order->discount_card_id != "")
			      						<div class="col-sm-12 col-md-2 mb-4 text-center">
				      						<span class="text-bold mb-4">تخفیف ویژه </span>
				      						<p>
				      							@php  
			      									if ($order->discountCard->type == "price")
			      										print number_format($order->discountCard->amount);
			      									elseif($order->discountCard->type == "percent")
			      										print number_format( ($order->discountCard->amount * $sumPrice)/100 );
			      									
			      								@endphp
				      							{{ $order->local }}
				      						</p>
				      					</div>
			      					@endif
			      					{{-- <div class="col-sm-12 col-md-3 mb-4 text-center">
		      							<span class="text-bold mb-4">هزینه ارسال : </span>
		      							<p>{{ $order->postPrice }} {{ $order->local }}</p>
		      						</div> --}}
			      					<div class="col-sm-12 col-md-4 mb-4 text-center">
		        						<span class="text-bold mb-4">جمع پرداختی به همراه هزینه ارسال  </span>
		    							<p>{{ number_format($sumPay) }} {{ $order->local }}</p>
			      					</div>
			      				</div>

				      			<div class="card-header">
									<div class="card-title"><span>اطلاعات گیرنده</span></div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-3 col-sm-12 mb-4">
											<b>نام : </b> {{ $order->recipient->name }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>نام خانوادگی : </b> {{ $order->recipient->family }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>کدملی : </b> {{ $order->recipient->nationalCode }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>شماره موبایل : </b> {{ $order->recipient->mobile }}
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-9 col-sm-12 mb-4">
											<b>آدرس   : </b> {{ $order->recipient->city->name }} - {{ $order->recipient->subcity->name }} - {{ $order->recipient->address }} - پلاک {{ $order->recipient->houseId }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>کد پستی : </b> {{ $order->recipient->zipcode }}
										</div>
									</div>
								</div>

								<div class="card-header">
									<div class="card-title"><span>اطلاعات ارسال سفارش</span></div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4 col-sm-12 mb-4">
											<b>روش ارسال : </b><span>{{ $order->post->title }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4">
											<b>هزینه : </b><span>{{ $order->postPrice }} {{ $order->local }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4">
											<b>مدت زمان :</b><span> حداکثر {{ $order->post->delivery_time }}</span>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 col-sm-12 mb-4" >
											<b>تاریخ ارسال : </b>
											<span>
												@if(isset($order->post_date))
													{{ Verta($order->post_date)->format('%d %B %Y - H:m:s') }}
												@endif
											</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4" >
											<b>کد مرسوله : </b><span>{{ $order->post_code }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4" >
											<b></b><span></span>
										</div>
									</div>
								</div>

								{{-- @if($order->status == "0") --}}
								@php
									$payment = $order->payments->filter(function($pay){
							            
							                if ($pay->tracing_code <> '' or $pay->res_code == 0) {
							                    return true;
							                }
							                else
							                    return false;
	   
							        });
									$payment = $payment->first();
								@endphp
								@isset($payment)
									<div class="card-header">
										<div class="card-title"><span>اطلاعات پرداخت به روش  {{ $payment->payment_method->title }}</span></div>
									</div>

									<div class="card-body">
										<div class="row">
											<div class="col-md-5 col-sm-12 mb-4">
												<b>شماره ارجاع یا شماره پیگیری : </b><span>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</span>
											</div>
											<div class="col-md-4 col-sm-12 mb-4">
												<b>تاریخ پرداخت : </b><span>{{ Verta($payment->date)->format('%d %B %Y - H:m:s') }}</span>
											</div>
											<div class="col-md-3 col-sm-12 mb-4">
												<b>پرداختی : </b><span>{{ number_format($payment->price) }} {{ $order->local }}</span>
											</div>

										</div>
									</div>
								@endisset

				      		</div>
				      	</div>
				    @endif
		      	@endforeach
	      	@endisset
	    </div>

{{-- @dd(1) --}}

	    <div id="postedOrders" class="container tab-pane "><br>
	    	@isset($successOrders)
		      	@foreach($successOrders as $order)
		      		@if($order->status == '1' and $order->post_code != "")
				      	<div class="card">
				      		<div class="card-header">
				      			<div class="row p-2" style="font-weight: bold;">

				      				<div class="col-md-3 col-sm-12 mb-4">
				      					کد  فاکتور : 
				      					{{ $order->code }}
				      				</div>

				      				<div class="col-md-3 col-sm-12 mb-4">
				      					تاریخ  : 
				      					{{ Verta($order->created_at)->format('%d %B %Y') }} - {{ $order->created_at->toTimeString() }}
				      				</div>

				      				<div class="col-md-4 col-sm-12 mb-4">
				      					پرداختی : 
				      					@php
				      						$sumOff = 0;
				      						$sumPay = 0;
				      						$sumPrice = 0;
				      						foreach($order->orderitems as $orderitem)
				      						{
				      							$sumPay = $sumPay + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
				      							$sumOff = $sumOff + ($orderitem->offPrice * $orderitem->count);
				      							$sumPrice = $sumPrice + ($orderitem->count * $orderitem->price);
				      						}
				      						$sumPay = $sumPay + $order->postPrice;
				      						if($order->discount_card_id != "")
				      						{
				      							if ($order->discountCard->type == "price")
		      										$sumPay = $sumPay - $order->discountCard->amount;

		      									elseif($order->discountCard->type == "percent")
		      										$sumPay = $sumPay - ($order->discountCard->amount * $sumPrice)/100 ;
				      						}




				      						// $sum = 0;
				      						// foreach($order->orderitems as $orderitem)
				      						// {
				      						// 	$sum = $sum + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
				      						// }
				      						// if(session()->has("discountCardPrice"))
				      						// 	$sum = $sum + $order->postPrice - session("discountCardPrice");
				      						// else
				      						// 	$sum = $sum + $order->postPrice;
				      						print number_format($sumPay) . " " . $order->local;

				      					@endphp
				      				</div>

				      				<div class="col-md-2 col-sm-12 mb-4 collapse-icon text-danger" style="cursor: pointer;" data-toggle="collapse" data-target="#order{{$order->id}}" aria-expanded="true" aria-controls="order{{$order->id}}" >
				      					<div class="link font-weight-normal">جزئیات  <i class="fa fa-chevron-down" style="font-size: 0.7rem" ></i></div>
				      				</div>
				      				
				      				
				      			</div>
				      		</div>
				      		<div id="order{{$order->id}}" class="card-body collapse" style="font-size: 90%;overflow-x: auto;">
				      			<table class="table w-10" style="font-size: 95%">
				      				<tr>
				      					<th>ردیف</th>
				      					<th>عنوان  محصول</th>
				      					<th>تعداد</th>
				      					<th>مبلغ</th>
				      					<th>تخفیف</th>
				      					<th>پرداختی</th>
				      					
				      				</tr>
				      				@foreach($order->orderitems as $orderitem)
				      					<tr>
				      						<td>{{ $loop->iteration }}</td>
				      						<td>
				      							@php $image = $orderitem->orderitemable->images->first(); @endphp
				      							<img src="{{asset('storage/images/thumbnails/'. $image['name'])}}" alt="" class="img-circle img-size-50 mr-2">
				      							{{ $orderitem->orderitemable->category->title }} طرح {{ $orderitem->orderitemable->color_design->design->title }} رنگ {{ $orderitem->orderitemable->color_design->color->color }}
				      						</td>
				      						<td>{{ $orderitem->count }}</td>
				      						<td>{{ number_format($orderitem->price) }} {{ $order->local }}</td>
				      						<td>{{ number_format($orderitem->offPrice) }} {{ $order->local }}</td>
				      						<td>{{ number_format($orderitem->price - $orderitem->offPrice) }} {{ $order->local }}</td>
				      					</tr>
				      				@endforeach
				      			</table>
				      			@php

		      					@endphp
		      					<div class="row mt-4">
		      						
			      					<div class="col-sm-12 col-md-3 mb-4 text-center">
			      						<span class="text-bold mb-4">جمع کل </span>
			      						<p>{{ number_format($sumPrice) }} {{ $order->local }}</p>
			      					</div>
			      					<div class="col-sm-12 col-md-3 mb-4 text-center">
			      						<span class="text-bold mb-4">جمع تخفیف </span>
			      						<p>{{ number_format($sumOff) }} {{ $order->local }}</p>
			      					</div>
			      					@if($order->discount_card_id != "")
			      						<div class="col-sm-12 col-md-2 mb-4 text-center">
				      						<span class="text-bold mb-4">تخفیف ویژه </span>
				      						<p>
				      							@php  
			      									if ($order->discountCard->type == "price")
			      										print number_format($order->discountCard->amount);
			      									elseif($order->discountCard->type == "percent")
			      										print number_format( ($order->discountCard->amount * $sumPrice)/100 );
			      									
			      								@endphp
				      							{{ $order->local }}
				      						</p>
				      					</div>
			      					@endif
			      					{{-- <div class="col-sm-12 col-md-3 mb-4 text-center">
		      							<span class="text-bold mb-4">هزینه ارسال : </span>
		      							<p>{{ $order->postPrice }} {{ $order->local }}</p>
		      						</div> --}}
			      					<div class="col-sm-12 col-md-4 mb-4 text-center">
		        						<span class="text-bold mb-4">جمع پرداختی به همراه هزینه ارسال  </span>
		    							<p>{{ number_format($sumPay) }} {{ $order->local }}</p>
			      					</div>
			      				</div>

				      			<div class="card-header">
									<div class="card-title"><span>اطلاعات گیرنده</span></div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-3 col-sm-12 mb-4">
											<b>نام : </b> {{ $order->recipient->name }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>نام خانوادگی : </b> {{ $order->recipient->family }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>کدملی : </b> {{ $order->recipient->nationalCode }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>شماره موبایل : </b> {{ $order->recipient->mobile }}
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-9 col-sm-12 mb-4">
											<b>آدرس   : </b> {{ $order->recipient->city->name }} - {{ $order->recipient->subcity->name }} - {{ $order->recipient->address }} - پلاک {{ $order->recipient->houseId }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>کد پستی : </b> {{ $order->recipient->zipcode }}
										</div>
									</div>
								</div>

								<div class="card-header">
									<div class="card-title"><span>اطلاعات ارسال سفارش</span></div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4 col-sm-12 mb-4">
											<b>روش ارسال : </b><span>{{ $order->post->title }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4">
											<b>هزینه : </b><span>{{ $order->postPrice }} {{ $order->local }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4">
											<b>مدت زمان :</b><span> حداکثر {{ $order->post->delivery_time }}</span>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 col-sm-12 mb-4" >
											<b>تاریخ ارسال : </b>
											<span>
												@if(isset($order->post_date))
													{{ Verta($order->post_date)->format('%d %B %Y - H:m:s') }}
												@endif
											</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4" >
											<b>کد مرسوله : </b><span>{{ $order->post_code }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4" >
											<b></b><span></span>
										</div>
									</div>
								</div>

								@php
									$payment = $order->payments->filter(function($pay){
							            
							                if ($pay->tracing_code <> '' or $pay->res_code == 0) {
							                    return true;
							                }
							                else
							                    return false;
	   
							        });
									$payment = $payment->first();
								@endphp
								@isset($payment)
									<div class="card-header">
										<div class="card-title"><span>اطلاعات پرداخت به روش  {{ $payment->payment_method->title }}</span></div>
									</div>

									<div class="card-body">
										<div class="row">
											<div class="col-md-5 col-sm-12 mb-4">
												<b>شماره ارجاع یا شماره پیگیری : </b><span>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</span>
											</div>
											<div class="col-md-4 col-sm-12 mb-4">
												<b>تاریخ پرداخت : </b><span>{{ Verta($payment->date)->format('%d %B %Y - H:m:s') }}</span>
											</div>
											<div class="col-md-3 col-sm-12 mb-4">
												<b>پرداختی : </b><span>{{ number_format($payment->price) }} {{ $order->local }}</span>
											</div>

										</div>
									</div>
								@endisset

				      		</div>
				      	</div>
				    @endif
		      	@endforeach
	      	@endisset
	    </div>



	    <div id="rejectOrders" class="container tab-pane "><br>
	    	@isset($successOrders)
		      	@foreach($successOrders as $order)
		      		@if($order->status == '2')
				      	<div class="card">
				      		<div class="card-header">
				      			<div class="row p-2" style="font-weight: bold;">

				      				<div class="col-md-3 col-sm-12 mb-4">
				      					کد  فاکتور : 
				      					{{ $order->code }}
				      				</div>

				      				<div class="col-md-3 col-sm-12 mb-4">
				      					تاریخ  : 
				      					{{ Verta($order->created_at)->format('%d %B %Y') }} - {{ $order->created_at->toTimeString() }}
				      				</div>

				      				<div class="col-md-4 col-sm-12 mb-4">
				      					پرداختی : 
				      					@php
				      						$sumOff = 0;
				      						$sumPay = 0;
				      						$sumPrice = 0;
				      						foreach($order->orderitems as $orderitem)
				      						{
				      							$sumPay = $sumPay + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
				      							$sumOff = $sumOff + ($orderitem->offPrice * $orderitem->count);
				      							$sumPrice = $sumPrice + ($orderitem->count * $orderitem->price);
				      						}
				      						$sumPay = $sumPay + $order->postPrice;
				      						if($order->discount_card_id != "")
				      						{
				      							if ($order->discountCard->type == "price")
		      										$sumPay = $sumPay - $order->discountCard->amount;

		      									elseif($order->discountCard->type == "percent")
		      										$sumPay = $sumPay - ($order->discountCard->amount * $sumPrice)/100 ;
				      						}




				      						// $sum = 0;
				      						// foreach($order->orderitems as $orderitem)
				      						// {
				      						// 	$sum = $sum + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
				      						// }
				      						// if(session()->has("discountCardPrice"))
				      						// 	$sum = $sum + $order->postPrice - session("discountCardPrice");
				      						// else
				      						// 	$sum = $sum + $order->postPrice;
				      						print number_format($sumPay) . " " . $order->local;

				      					@endphp
				      				</div>

				      				<div class="col-md-2 col-sm-12 mb-4 collapse-icon text-danger" style="cursor: pointer;" data-toggle="collapse" data-target="#order{{$order->id}}" aria-expanded="true" aria-controls="order{{$order->id}}" >
				      					<div class="link font-weight-normal">جزئیات  <i class="fa fa-chevron-down" style="font-size: 0.7rem" ></i></div>
				      				</div>
				      				
				      				
				      			</div>
				      		</div>
				      		<div id="order{{$order->id}}" class="card-body collapse" style="font-size: 90%;overflow-x: auto;">
				      			<table class="table w-10" style="font-size: 95%">
				      				<tr>
				      					<th>ردیف</th>
				      					<th>عنوان  محصول</th>
				      					<th>تعداد</th>
				      					<th>مبلغ</th>
				      					<th>تخفیف</th>
				      					<th>پرداختی</th>
				      					
				      				</tr>
				      				@foreach($order->orderitems as $orderitem)
				      					<tr>
				      						<td>{{ $loop->iteration }}</td>
				      						<td>
				      							@php $image = $orderitem->orderitemable->images->first(); @endphp
				      							<img src="{{asset('storage/images/thumbnails/'. $image['name'])}}" alt="" class="img-circle img-size-50 mr-2">
				      							{{ $orderitem->orderitemable->category->title }} طرح {{ $orderitem->orderitemable->color_design->design->title }} رنگ {{ $orderitem->orderitemable->color_design->color->color }}
				      						</td>
				      						<td>{{ $orderitem->count }}</td>
				      						<td>{{ number_format($orderitem->price) }} {{ $order->local }}</td>
				      						<td>{{ number_format($orderitem->offPrice) }} {{ $order->local }}</td>
				      						<td>{{ number_format($orderitem->price - $orderitem->offPrice) }} {{ $order->local }}</td>
				      					</tr>
				      				@endforeach
				      			</table>
				      			@php

		      					@endphp
		      					<div class="row mt-4">
		      						
			      					<div class="col-sm-12 col-md-3 mb-4 text-center">
			      						<span class="text-bold mb-4">جمع کل </span>
			      						<p>{{ number_format($sumPrice) }} {{ $order->local }}</p>
			      					</div>
			      					<div class="col-sm-12 col-md-3 mb-4 text-center">
			      						<span class="text-bold mb-4">جمع تخفیف </span>
			      						<p>{{ number_format($sumOff) }} {{ $order->local }}</p>
			      					</div>
			      					@if($order->discount_card_id != "")
			      						<div class="col-sm-12 col-md-2 mb-4 text-center">
				      						<span class="text-bold mb-4">تخفیف ویژه </span>
				      						<p>
				      							@php  
			      									if ($order->discountCard->type == "price")
			      										print number_format($order->discountCard->amount);
			      									elseif($order->discountCard->type == "percent")
			      										print number_format( ($order->discountCard->amount * $sumPrice)/100 );
			      									
			      								@endphp
				      							{{ $order->local }}
				      						</p>
				      					</div>
			      					@endif
			      					{{-- <div class="col-sm-12 col-md-3 mb-4 text-center">
		      							<span class="text-bold mb-4">هزینه ارسال : </span>
		      							<p>{{ $order->postPrice }} {{ $order->local }}</p>
		      						</div> --}}
			      					<div class="col-sm-12 col-md-4 mb-4 text-center">
		        						<span class="text-bold mb-4">جمع پرداختی به همراه هزینه ارسال  </span>
		    							<p>{{ number_format($sumPay) }} {{ $order->local }}</p>
			      					</div>
			      				</div>

				      			<div class="card-header">
									<div class="card-title"><span>اطلاعات گیرنده</span></div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-3 col-sm-12 mb-4">
											<b>نام : </b> {{ $order->recipient->name }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>نام خانوادگی : </b> {{ $order->recipient->family }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>کدملی : </b> {{ $order->recipient->nationalCode }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>شماره موبایل : </b> {{ $order->recipient->mobile }}
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-9 col-sm-12 mb-4">
											<b>آدرس   : </b> {{ $order->recipient->city->name }} - {{ $order->recipient->subcity->name }} - {{ $order->recipient->address }} - پلاک {{ $order->recipient->houseId }}
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>کد پستی : </b> {{ $order->recipient->zipcode }}
										</div>
									</div>
								</div>

								<div class="card-header">
									<div class="card-title"><span>اطلاعات ارسال سفارش</span></div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4 col-sm-12 mb-4">
											<b>روش ارسال : </b><span>{{ $order->post->title }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4">
											<b>هزینه : </b><span>{{ $order->postPrice }} {{ $order->local }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4">
											<b>مدت زمان :</b><span> حداکثر {{ $order->post->delivery_time }}</span>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 col-sm-12 mb-4" >
											<b>تاریخ ارسال : </b>
											<span>
												@if(isset($order->post_date))
													{{ Verta($order->post_date)->format('%d %B %Y - H:m:s') }}
												@endif
											</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4" >
											<b>کد مرسوله : </b><span>{{ $order->post_code }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4" >
											<b></b><span></span>
										</div>
									</div>
								</div>

								@php
									$payment = $order->payments->filter(function($pay){
							            
							                if ($pay->tracing_code <> '' or $pay->res_code == 0) {
							                    return true;
							                }
							                else
							                    return false;
	   
							        });
									$payment = $payment->first();
								@endphp
								@isset($payment)
									<div class="card-header">
										<div class="card-title"><span>اطلاعات پرداخت به روش  {{ $payment->payment_method->title }}</span></div>
									</div>

									<div class="card-body">
										<div class="row">
											<div class="col-md-5 col-sm-12 mb-4">
												<b>شماره ارجاع یا شماره پیگیری : </b><span>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</span>
											</div>
											<div class="col-md-4 col-sm-12 mb-4">
												<b>تاریخ پرداخت : </b><span>{{ Verta($payment->date)->format('%d %B %Y - H:m:s') }}</span>
											</div>
											<div class="col-md-3 col-sm-12 mb-4">
												<b>پرداختی : </b><span>{{ number_format($payment->price) }} {{ $order->local }}</span>
											</div>

										</div>
									</div>
								@endisset

				      		</div>
				      	</div>
				    @endif
		      	@endforeach
	      	@endisset
	    </div>

	    <div id="unsuccessOrders" class="container tab-pane "><br>
	    	@isset($unsuccessOrders)
		      	@foreach($unsuccessOrders as $order)
	      		{{-- @if($order->status == '2') --}}
			      	<div class="card">
			      		<div class="card-header">
			      			<div class="row p-2" style="font-weight: bold;">

			      				<div class="col-md-3 col-sm-12 mb-4">
			      					کد  فاکتور : 
			      					{{ $order->code }}
			      				</div>

			      				<div class="col-md-3 col-sm-12 mb-4">
			      					تاریخ  : 
			      					{{ Verta($order->created_at)->format('%d %B %Y') }} - {{ $order->created_at->toTimeString() }}
			      				</div>

			      				<div class="col-md-4 col-sm-12 mb-4">
			      					جمع کل : 
			      					@php
			      						$sumOff = 0;
			      						$sumPay = 0;
			      						$sumPrice = 0;
			      						foreach($order->orderitems as $orderitem)
			      						{
			      							$sumPay = $sumPay + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
			      							$sumOff = $sumOff + ($orderitem->offPrice * $orderitem->count);
			      							$sumPrice = $sumPrice + ($orderitem->count * $orderitem->price);
			      						}
			      						$sumPay = $sumPay + $order->postPrice;
			      						if($order->discount_card_id != "")
			      						{
			      							if ($order->discountCard->type == "price")
	      										$sumPay = $sumPay - $order->discountCard->amount;

	      									elseif($order->discountCard->type == "percent")
	      										$sumPay = $sumPay - ($order->discountCard->amount * $sumPrice)/100 ;
			      						}

			      						print number_format($sumPay) . " " . $order->local;

			      					@endphp
			      				</div>

			      				<div class="col-md-2 col-sm-12 mb-4 collapse-icon text-danger" style="cursor: pointer;" data-toggle="collapse" data-target="#order{{$order->id}}" aria-expanded="true" aria-controls="order{{$order->id}}" >
			      					<div class="link font-weight-normal">جزئیات  <i class="fa fa-chevron-down" style="font-size: 0.7rem" ></i></div>
			      				</div>
			      				
			      				
			      			</div>
			      		</div>
			      		<div id="order{{$order->id}}" class="card-body collapse" style="font-size: 90%;overflow-x: auto;">
			      			<table class="table w-10" style="font-size: 95%">
			      				<tr>
			      					<th>ردیف</th>
			      					<th>عنوان  محصول</th>
			      					<th>تعداد</th>
			      					<th>مبلغ</th>
			      					<th>تخفیف</th>
			      					<th>پرداختی</th>
			      					
			      				</tr>
			      				@foreach($order->orderitems as $orderitem)
			      					<tr>
			      						<td>{{ $loop->iteration }}</td>
			      						<td>
			      							@php $image = $orderitem->orderitemable->images->first(); @endphp
			      							<img src="{{asset('storage/images/thumbnails/'. $image['name'])}}" alt="" class="img-circle img-size-50 mr-2">
			      							{{ $orderitem->orderitemable->category->title }} طرح {{ $orderitem->orderitemable->color_design->design->title }} رنگ {{ $orderitem->orderitemable->color_design->color->color }}
			      						</td>
			      						<td>{{ $orderitem->count }}</td>
			      						<td>{{ number_format($orderitem->price) }} {{ $order->local }}</td>
			      						<td>{{ number_format($orderitem->offPrice) }} {{ $order->local }}</td>
			      						<td>{{ number_format($orderitem->price - $orderitem->offPrice) }} {{ $order->local }}</td>
			      					</tr>
			      				@endforeach
			      			</table>
			      			@php

	      					@endphp
	      					<div class="row mt-4">
	      						
		      					<div class="col-sm-12 col-md-3 mb-4 text-center">
		      						<span class="text-bold mb-4">جمع کل </span>
		      						<p>{{ number_format($sumPrice) }} {{ $order->local }}</p>
		      					</div>
		      					<div class="col-sm-12 col-md-3 mb-4 text-center">
		      						<span class="text-bold mb-4">جمع تخفیف </span>
		      						<p>{{ number_format($sumOff) }} {{ $order->local }}</p>
		      					</div>
		      					@if($order->discount_card_id != "")
		      						<div class="col-sm-12 col-md-2 mb-4 text-center">
			      						<span class="text-bold mb-4">تخفیف ویژه </span>
			      						<p>
			      							@php  
		      									if ($order->discountCard->type == "price")
		      										print number_format($order->discountCard->amount);
		      									elseif($order->discountCard->type == "percent")
		      										print number_format( ($order->discountCard->amount * $sumPrice)/100 );
		      									
		      								@endphp
			      							{{ $order->local }}
			      						</p>
			      					</div>
		      					@endif
		      					{{-- <div class="col-sm-12 col-md-3 mb-4 text-center">
	      							<span class="text-bold mb-4">هزینه ارسال : </span>
	      							<p>{{ $order->postPrice }} {{ $order->local }}</p>
	      						</div> --}}
		      					<div class="col-sm-12 col-md-4 mb-4 text-center">
	        						<span class="text-bold mb-4">قابل پرداخت به همراه هزینه ارسال </span>
	    							<p>{{ number_format($sumPay) }} {{ $order->local }}</p>
		      					</div>
		      				</div>

			      			<div class="card-header">
								<div class="card-title"><span>اطلاعات گیرنده</span></div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-3 col-sm-12 mb-4">
										<b>نام : </b> {{ $order->recipient->name }}
									</div>
									<div class="col-md-3 col-sm-12 mb-4">
										<b>نام خانوادگی : </b> {{ $order->recipient->family }}
									</div>
									<div class="col-md-3 col-sm-12 mb-4">
										<b>کدملی : </b> {{ $order->recipient->nationalCode }}
									</div>
									<div class="col-md-3 col-sm-12 mb-4">
										<b>شماره موبایل : </b> {{ $order->recipient->mobile }}
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-9 col-sm-12 mb-4">
										<b>آدرس   : </b> {{ $order->recipient->city->name }} - {{ $order->recipient->subcity->name }} - {{ $order->recipient->address }} - پلاک {{ $order->recipient->houseId }}
									</div>
									<div class="col-md-3 col-sm-12 mb-4">
										<b>کد پستی : </b> {{ $order->recipient->zipcode }}
									</div>
								</div>
							</div>

							<div class="card-header">
								<div class="card-title"><span>اطلاعات ارسال سفارش</span></div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-4 col-sm-12 mb-4">
										<b>روش ارسال : </b><span>{{ $order->post->title }}</span>
									</div>
									<div class="col-md-4 col-sm-12 mb-4">
										<b>هزینه : </b><span>{{ $order->postPrice }} {{ $order->local }}</span>
									</div>
									<div class="col-md-4 col-sm-12 mb-4">
										<b>مدت زمان :</b><span> حداکثر {{ $order->post->delivery_time }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-sm-12 mb-4" >
										<b>تاریخ ارسال : </b>
										<span>
											@if(isset($order->post_date))
												{{ Verta($order->post_date)->format('%d %B %Y - H:m:s') }}
											@endif
										</span>
									</div>
									<div class="col-md-4 col-sm-12 mb-4" >
										<b>کد مرسوله : </b><span>{{ $order->post_code }}</span>
									</div>
									<div class="col-md-4 col-sm-12 mb-4" >
										<b></b><span></span>
									</div>
								</div>
							</div>

							@php
								$payment = $order->payments->filter(function($pay){
						            
						                if ($pay->tracing_code <> '' or $pay->res_code == 0) {
						                    return true;
						                }
						                else
						                    return false;

						        });
								$payment = $payment->first();
							@endphp
							@isset($payment)
								<div class="card-header">
									<div class="card-title"><span>اطلاعات پرداخت به روش  {{ $payment->payment_method->title }}</span></div>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-5 col-sm-12 mb-4">
											<b>شماره ارجاع یا شماره پیگیری : </b><span>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</span>
										</div>
										<div class="col-md-4 col-sm-12 mb-4">
											<b>تاریخ پرداخت : </b><span>{{ Verta($payment->date)->format('%d %B %Y - H:m:s') }}</span>
										</div>
										<div class="col-md-3 col-sm-12 mb-4">
											<b>پرداختی : </b><span>{{ number_format($payment->price) }} {{ $order->local }}</span>
										</div>

									</div>
								</div>
							@endisset

			      		</div>
			      	</div>
			    {{-- @endif --}}
		      	@endforeach
	      	@endisset
	    </div>




  </div>



@endsection


@push('js')
	
<script type="text/javascript">
	$(function () {
		$(".collapse-icon").click(function () {
			if($(this).find("i").hasClass("fa-chevron-up"))
			{
				$(this).find("i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
			}
			else if($(this).find("i").hasClass("fa-chevron-down"))
			{
				$(this).find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
			}

	    });
	})//end
</script>

@endpush