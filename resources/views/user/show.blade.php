@extends('admin-layout')

@section('title',"$user->name $user->family")

@push('link')
	

@endpush

@section('main-content')
	<section class="content">
      	<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12">
					<!-- Profile Image -->
		            <div class="card @if($user->isActive == 1) card-primary @else card-danger @endif card-outline">
						<div class="card-body box-profile">
							<div class="text-center">
							  <img class="profile-user-img img-fluid img-circle"
							       src="{{ asset('/storetemplate/dist/img/'.$user->image) }}"
							       alt="User profile picture">
							</div>

							<h3 class="profile-username text-center">{{ $user->name }} {{ $user->family }}</h3>

							<p class="text-muted text-center">
								@if($user->role == 'user')
									کابر عادی
								@else
									<span class="text-danger">مدیر سایت</span>
								@endif
							</p>

							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item">
									<b>نظرات : </b> <a class="float-left">{{ number_format($user->comments->count()) }}</a>
								</li>
								<li class="list-group-item">
									<b>سفارشات موفق : </b> <a class="float-left">
										{{ $orders->count() }}
										{{-- @php 
											$sum = 0;
											$total = 0;
											$price = 0;
											$off = 0;
											foreach($user->orders as $order)
											{
												foreach ($order->orderitems as $orderitem) {
													$sum = $sum + $orderitem->count;
													$prices = $orderitem->orderitemable->prices->where('local',$order->local)->first();
													$price = $price + ($prices->price * $orderitem->count);
													$off = $off + ($prices->offPrice * $orderitem->count);
													$total = $price - $off;
												}
												$total = $total + $order->post->price;
											}
											print number_format($sum);
										@endphp --}}
										@php
											$total = 0;
											// dd($payment);
											foreach($orders as $order)
											{
												$payment = $order->payments->first();
												// dd($payment->price);
												$total = $total + $payment->price;
											}
										@endphp
									</a>
								</li>
								<li class="list-group-item">
									<b>ارزش سفارشات(تومان) : </b> <a class="float-left">{{ number_format($total) }}</a>
								</li>
							</ul>
							@if($user->isActive == 1)
								<div class="alert alert-info text-center" style="padding: 0.5rem 1.25rem;">وضعیت: فعال  است</div>
							@else
								<div class="alert alert-danger text-center" style="padding: 0.45rem 1.25rem;">وضعیت: غیرفعال  است</div>
							@endif
							<a href="{{ route('user.index') }}" class="btn btn-secondary btn-flat btn-block">بازگشت</a>
						</div>
						<!-- /.card-body -->
		            </div>
		            <!-- /.card -->
				</div>
				<div class="col-lg-9 col-md-9 col-sm-12">
					<div class="card">
						<div class="card-body">
							<nav class="nav nav-pills">
							    <a href="#userDetail" class="nav-item nav-link active" data-toggle="tab">جزئیات</a>
							    <a href="#activiteis" class="nav-item nav-link" data-toggle="tab">فعالیت ها</a>
							    <a href="#orders" class="nav-item nav-link" data-toggle="tab">سفارش ها</a>
							</nav>

							<!-- Tab panes -->
							<div class="tab-content">

								<div id="userDetail" class="container tab-pane active row">
									<h6 class="col-12 text-danger mb-3 mt-3">اطلاعات حساب شخصی</h6>
									<hr>
									<div class="row">
										<div class="col-md-6 col-sm-12 mb-3">
											<span class="text-bold">نام و نام خانوادگی:</span> {{ $user->name }} {{ $user->family }}
										</div>
										<div class="col-md-6 col-sm-12 mb-3">
											<span class="text-bold">کدملی: </span> {{ $user->nationalCode }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-12 mb-3">
											<span class="text-bold">تاریخ تولد: </span> {{ verta($user->birthday)->format('%d %B، %Y') }}
										</div>
										<div class="col-md-6 col-sm-12 mb-3">
											<span class="text-bold">شماره تلفن همراه: </span> {{ $user->mobile }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-12 mb-3">
											<span class="text-bold">آدرس پست الکترونیک: </span> {{ $user->email }}
										</div>
									</div>
									@if($user->companyName != "")
										<h6 class="col-12 text-danger mb-3 mt-5">اطلاعات حقوقی</h6>
										<hr>
										<div class="row">
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">نام شرکت یا سازمان: </span> {{ $user->companyName }}
											</div>
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">کد اقتصادی: </span> {{ $user->companyEconomyID }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">شناسه ملی: </span> {{ $user->companyNationalID }}
											</div>
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">شناسه ثبت: </span> {{ $user->companyRegistrationID }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">نام استان : </span> {{ $user->city->name }}
											</div>
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">نام شهر: </span> {{ $user->subcity->name }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">شماره تلفن ثابت: </span> {{ $user->companyTel }}
											</div>
											<div class="col-md-6 col-sm-12 mb-3">
												<span class="text-bold">آدرس سایت: </span> {{ $user->companySite }}
											</div>
										</div>
									@endif
								</div>

								<div id="activiteis" class="container tab-pane row">
									<ul class="timeline timeline-inverse">
										@if($user->comments->count() > 0)
					                    	<!-- timeline time label -->
	                      					<li class="time-label mt-3">
	                        					<span class="bg-danger">نظرات</span>
	                     		 			</li>
	                      					<!-- /.timeline-label -->
											@foreach($user->comments as $comment)
						                      	<!-- timeline item -->
												<li>
													<i class="fa fa-comments bg-warning"></i>
													<div class="timeline-item">
													  	<span class="time float-left">{{ verta($comment->created_at)->format('%d %B، %Y') }}<i class="fa fa-clock-o mr-1"></i></span>

													  	<h3 class="timeline-header"><a href="#">
													  		<img class="img-circle ml-2" style="width: 8%;height: 8%;" src="{{ asset('storage/images/thumbnails/'.$comment->commentable->images->first()->name) }}" alt="User Image">{{ $comment->commentable->category->title }} طرح {{ $comment->commentable->color_design->design->title }} رنگ {{ $comment->commentable->color_design->color->color }} با  کد {{ $comment->code }}</a></h3>

													  	<div class="timeline-body">{{ $comment->text }}</div>
													  	{{-- <div class="timeline-footer">
													    	<a href="#" class="btn btn-primary btn-sm">Read more</a>
													    	<a href="#" class="btn btn-danger btn-sm">Delete</a>
													  	</div> --}}
													</div>
												</li>
												<!-- END timeline item -->
											@endforeach
										@endif

										@if(isset($userMessages) and ($userMessages->count() > 0))
											<!-- timeline time label -->
	                      					<li class="time-label mt-5">
	                        					<span class="bg-danger">پیام ها</span>
	                     		 			</li>
	                      					<!-- /.timeline-label -->
											@foreach($userMessages as $userMessage)
												<!-- timeline item -->
												<li>
													<i class="fa fa-envelope bg-primary"></i>
													<div class="timeline-item">
													  	<div class="time float-none" style=" height: 1rem"><i class="fa fa-clock-o ml-1"></i>{{ verta($userMessage->created_at)->format('%d %B، %Y') }}</div>
													  	<br>

													  	{{-- <h3 class="timeline-header"><a href="#"></a></h3> --}}

													  	<div class="timeline-body" style="border-top-color: #ddd;border-top: 1px solid rgba(0,0,0,.125); ">
													  		<p>{{ $userMessage->subject }}</p>
													  		<p>{{ $userMessage->message }}</p>
													  	</div>
													</div>
												</li>
												<!-- END timeline item -->
											@endforeach
										@endif

  										@if($user->comments->count() > 0 or (isset($userMessages) and $userMessages->count() > 0))
					                      	<!-- END timeline item -->
					                      	<li>
					                        	<i class="fa fa-clock-o bg-gray"></i>
					                      	</li>
				                      	@endif
				                      	
				                    </ul>
								</div>

								<div id="orders" class="container tab-pane mb-3 row">
									
									@foreach($orders->sortbyDesc('created-at') as $order)
										
										<div class="card mt-4">
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

								      				<div class="col-md-3 col-sm-12 mb-4">
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

								      				<div class="col-md-2 col-sm-12 mb-4 collapse-icon text-danger text-left" style="cursor: pointer;" data-toggle="collapse" data-target="#order{{$order->id}}" aria-expanded="true" aria-controls="order{{$order->id}}" >
								      					<div class="link font-weight-normal ml-2">جزئیات  <i class="fa fa-chevron-down" style="font-size: 0.7rem" ></i></div>
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
													$payment = $order->payments()->where(function($query) {
											                 $query->where('tracing_code','<>','')
											                     ->orWhere('res_code','0');
											            })->first();
													//dd($payment);
												@endphp
												@if($payment != '')

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
												@endif

								      		</div>
								      	</div>


									@endforeach

								</div>{{-- Orders --}}

							</div>{{-- tab-content --}}

						</div>

					</div>
				</div>

		    </div>
	      	<!-- /.row -->
	    </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
	<script>
		$(function () {


		})
	</script>

@endpush