@extends('store-layout')

@push('link')
	<style type="text/css">
		#TopMenuCartIcone{
			display: none;
		}
		.datepicker-grid-view .header {
		    background-color: unset !important;
		    height: unset !important;
		    padding: unset !important;
		}

		#print-header,
		#print-footer{
			display: none;
		}

		@media print {

			#print-header,
			#print-footer{
				display: block;
			}

		  	#header,
		  	#footer,
		  	.back-to-top,
		  	#buttons {
				display: none !important;
		  	}
		  	#print-footer {
			    position: fixed;
			    bottom: 30px;
			    right: 0;
			    left: 0;
		  	}
		}
	</style>
@endpush

@section('title','فاکتور خرید')

@section('main-content')

	<section class="content">
      	<div class="row">
        	<div class="col-12">
        		<div class="text-center" id="print-header">
        			<img src="{{ asset('/storetemplate/dist/img/logo-print.png') }}" alt="Termeh Salari Logo" class="mb-3">
        			<div class="mb-3">
        				<h4 style="display: inline-block;">ترمه سالاری | شکوهی از هنر سه نسل</h4>
        			</div>
        		</div>
        		<div class="card" style="clear: both;">
        			<div class="card-header">
        				<div class="card-title">
        					<span>فاکتور خرید</span>
        				</div>
        			</div>
        			<div class="card-body">
        				<div class="row ">
        					<div class="col-md-6 col-sm-12 mb-4 text-right">
        						<b>کد فاکتور : </b><span>{{ $order->code }}</span>
        					</div>
        					<div class="col-md-6 col-sm-12 mb-4 text-left">
        						<b>تاریخ : </b><span>{{ Verta($order->created_at)->format('%d %B، %Y H:m:s') }}</span>
        					</div>
        				</div>
        				<div class="row">
        					<div class="col-12">
        						<table class="table" style="overflow: scroll;">
									<thead>
										<tr>
											<th>ردیف</th>
					      					<th>عنوان  محصول</th>
					      					<th>تعداد</th>
					      					<th>مبلغ</th>
					      					<th>تخفیف</th>
					      					<th>قابل پرداخت</th>
										</tr>
									</thead>
									<tbody>	
										@foreach($order->orderitems as $orderitem)
					      					<tr>
					      						<td>{{ $loop->iteration }}</td>
					      						<td>
					      							@php
					      								$image = $orderitem->orderitemable->images->first(); 
					      							@endphp
					      							<img src="{{asset('storage/images/thumbnails/'. $image['name'])}}" alt="" class="img-circle img-size-50 mr-2">
					      							{{ $orderitem->orderitemable->category->title }} طرح {{ $orderitem->orderitemable->color_design->design->title }} رنگ {{ $orderitem->orderitemable->color_design->color->color }}
					      						</td>
					      						<td>{{ $orderitem->count }}</td>
					      						<td>{{ number_format($orderitem->price) }} {{ $order->local }}</td>
					      						<td>{{ number_format($orderitem->offPrice) }} {{ $order->local }}</td>
					      						<td>{{ number_format($orderitem->price - $orderitem->offPrice) }} {{ $order->local }}</td>
					      					</tr>
					      				@endforeach
					      				
				      				</tbody>
								</table>
		      					@php
		      						$sumOff = 0;
		      						$sumPay = 0;
		      						$sumPrice = 0;
		      						foreach($order->orderitems as $orderitem)
		      						{
		      							$sumPay = $sumPay + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) ) + $order->postPrice;
		      							$sumOff = $sumOff + ($orderitem->offPrice * $orderitem->count);
		      							$sumPrice = $sumPrice + ($orderitem->count * $orderitem->price);
		      						}
		      						if($order->discount_card_id != ""){
		      							// $sumPay = $sumPay + $order->postPrice - session("discountCardPrice");
		      							if ($order->discountCard->type == "price")
	      									$sumPay = $sumPay + $order->postPrice - $order->discountCard->amount;
      									elseif($order->discountCard->type == "percent")
      										$sumPay = $sumPay + $order->postPrice -  (($order->discountCard->amount * $sumPrice)/100 );
		      						}
		      						else
		      							$sumPay = $sumPay + $order->postPric;
		      					@endphp
		      					<div class="row mt-4">
			      					<div class="col-sm-12 col-md-3 mb-4">
			      						<b>جمع کل : </b>{{ number_format($sumPrice) }} {{ $order->local }}
			      					</div>
			      					<div class="col-sm-12 col-md-3 mb-4">
			      						<b>جمع تخفیف : </b>{{ number_format($sumOff) }} {{ $order->local }}
			      					</div>
			      					@if($order->discount_card_id != "")
				      					<div class="col-sm-12 col-md-3 mb-4">
				      						<b>تخفیف ویژه : </b>{{-- {{ number_format(session("discountCardPrice")) }} {{ $order->local }} --}}
				      						@php 
		      									if ($order->discountCard->type == "price")
		      										print number_format($order->discountCard->amount);
		      									elseif($order->discountCard->type == "percent")
		      										print number_format( ($order->discountCard->amount * $sumPrice)/100 );
		      									
		      								@endphp
		      								{{ $order->local }}
				      					</div>
				      				@endif
			      					<div class="col-sm-12 col-md-3 mb-4">
		        						<b>جمع پرداختی به همرا هزینه ارسال : </b>
	        							{{ number_format($sumPay) }} {{ $order->local }}
			      					</div>
			      				</div>
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
						@php
							$payment = $order->payments()->where(function($query) {
            					$query->whereNotNull('tracing_code')
                  				->orWhere('res_code','0');
        					})
            				->first();
            				//dd($payment);
						@endphp
						@isset($payment)
							<div class="card-header">
								<div class="card-title"><span>اطلاعات پرداخت به روش  {{ $payment->payment_method->title }}</span>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-4 col-sm-12 mb-4">
										<b>شماره ارجاع یا شماره پیگیری : </b><span>{{ $payment->tracing_code  ?? $payment->saleReferenceId }}</span>
									</div>
									<div class="col-md-4 col-sm-12 mb-4">
										<b>تاریخ پرداخت : </b><span>{{ Verta($payment->date)->format('%d %B، %Y H:m:s') }}</span>
									</div>
									<div class="col-md-4 col-sm-12 mb-4">
										<b>پرداختی : </b><span>{{ number_format($payment->price) }} {{ $order->local }}</span>
									</div>
								</div>
							</div>
						@endisset

						<div class="card-header">
							<div class="card-title"><span>اطلاعات ارسال سفارش</span></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 col-sm-12 mb-4">
									<b>روش ارسال : </b><span>{{ $order->post->title }}</span>
								</div>
								<div class="col-md-4 col-sm-12 mb-4">
									<b>هزینه ارسال : </b><span>{{ $order->postPrice }} {{ $order->local }}</span>
								</div>
								<div class="col-md-4 col-sm-12 mb-4">
									<b>مدت زمان ارسال :</b><span> حداکثر {{ $order->post->delivery_time }}</span>
								</div>
							</div>
						</div>	

        			</div>
        			
        		</div>
        		<div class="col-12" id="print-footer">
        			<div class="float-right">
	        			<p style="line-height: 45px">
	        				فروشگاه مرکزی : میدان امیرچقماق | تلفن: 37 06 3626 035
	        				<br>
	        				فروشگاه شماره2 : جنب شیرینی سازی حاج خلیفه رهبر .سرای ترمه | تلفن: 80 38 3622 035

	        			</p>
	        		</div>
	        		<div class="float-left text-left" style="direction: ltr">
	        			<p>
	        				<i class="fas fa-globe-asia"></i> http://TermehSalari.com <br>
	        				<i class="far fa-envelope"></i> Info@TermehSalari.com <br>
	        				<i class="fab fa-instagram"></i> https://www.instagram.com/termehsalari <br>
	        				<i class="far fa-paper-plane"></i> <i class="fab fa-whatsapp"></i> 09134577500
	        				
	        			</p>
	        		</div>

        		</div>
        		<div id="buttons" style="margin-bottom: 40px;">
        			<a href="#" class="btn btn-success btn-flat printPage">چاپ صفحه</a>

        			<a href="{{ route('homeStore.index') }}" class="btn btn-flat btn-primary">صفحه اصلی فروشگاه </a>

        			<a href="{{ route('user.myOrders') }}" class="btn btn-flat btn-secondary">مدیریت سفارش ها</a>
        		</div>
        		
        		

        	</div>
		</div>
	</section>
@endsection

@push('js')
	<script type="text/javascript">
		$(function () {
			$('a.printPage').click(function(event){
				event.preventDefault();
	           	window.print();
	           	return false;
			});
		});//end
	</script>
@endpush
