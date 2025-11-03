<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="direction: rtl;font-family: system-ui;">
	{{-- <div class="container"> --}}
		<table align="center" style="width: 99%;direction: rtl;font-family: system-ui;" >
			<caption>
				<h1 style="text-align: center;" ><img style="border-left: 3px solid #18d26e;padding-left: 10px;vertical-align: middle;" src="{{ asset('/hometemplate/img/logo.png') }}">
					<span style="padding-right: 20px">فروشگاه ترمه سالاری </span>
				</h1>
				<h2 style="font-size: 122%;text-align: center;">
				نمایشگاهی بزرگ و جذاب از ترمه های نفیس یزد
				</h2>
				<h3>فاکتور خرید</h3>
			</caption>
			<tr style="height: 40px !important;">
				<td style="font-weight: bold;background-color: #f6f5f5;height: 50px;direction: rtl;text-align: right;">
					<span style="float: right;"><b>کد فاکتور : </b>{{ $order->code }}</span>
					<span style="float: left"><b>تاریخ : </b>{{ Verta($order->created_at)->format('%d %B، %Y H:m:s') }}</span></span>
				</td>
			</tr>
			<tr style="clear: both;height: 40px !important;">
				<td>
					<table style="width: 100%; text-align: center;width: 100%;direction: rtl;font-family: system-ui;" align="center">
						<thead>
							<tr style="height: 40px !important;">
								<th>ردیف</th>
								<th>عنوان محصول	</th>
								<th>تعداد</th>
								<th>مبلغ</th>
								<th>تخفیف</th>
								<th>قابل پرداخت</th>
							</tr>
						</thead>
						<tbody>
							@foreach($order->orderitems as $orderitem)
								<tr style="height: 40px !important;">
									<td>{{ $loop->iteration }}</td>
									<td style="text-align: right;">
										@php
		      								$image = $orderitem->orderitemable->images->first();
		      							@endphp
		      							<img src="{{asset('storage/images/thumbnails/'. $image['name'])}}" alt="" style="width: 10%;margin-left: 10px;border-radius: 50%;vertical-align: middle;">
					      				{{ $orderitem->orderitemable->category->title }} طرح {{ $orderitem->orderitemable->color_design->design->title }} رنگ {{ $orderitem->orderitemable->color_design->color->color }}
									</td>
									<td>{{ $orderitem->count }}</td>
									<td>
										{{ number_format($orderitem->price) }} {{ $order->local }}
									</td>
									<td>
										{{ number_format($orderitem->offPrice) }} {{ $order->local }}
									</td>
									<td>
										{{ number_format($orderitem->price - $orderitem->offPrice) }} {{ $order->local }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</td>
			</tr>
			<tr style="height: 40px !important;">
				<td>
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

  						if($order->discount_card_id != "")
      						{
      							if ($order->discountCard->type == "price")
										$sumPay = $sumPay - $order->discountCard->amount + $order->postPrice;

								elseif($order->discountCard->type == "percent")
									$sumPay = $sumPay - (($order->discountCard->amount * $sumPrice)/100) + $order->postPrice;
      						}
      					elseif($order->discount_card_id == "")
      							$sumPay = $sumPay + $order->postPrice;
  					@endphp
  					<div style="text-align: center;float: right;width: 25%">
  						<b>جمع کل </b>
  						<p>{{ number_format($sumPrice) }} {{ $order->local }}</p>
  					</div>
  					<div style="text-align: center;float: right;width: 25%">
  						<b>جمع تخفیف </b>
  						<p>{{ number_format($sumOff) }} {{ $order->local }}</p>
  					</div>
  					@if($order->discount_card_id != "")
      					<div style="text-align: center;float: right;width: 25%">
      						<b>تخفیف ویژه </b>
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
  					<div style="text-align: center;float: right;width: 25%">
						<b>جمع پرداختی به همرا هزینه ارسال </b>
						<p>{{ number_format($sumPay) }} {{ $order->local }}</p>
  					</div>
				</td>
			</tr>
			<tr style="height: 40px !important;">
				<td style="font-weight: bold;background-color: #f6f5f5;height: 50px;direction: rtl;text-align: right;">
					اطلاعات گیرنده
				</td>
			</tr>
			<tr style="height: 40px !important;">
				<td>
					<table style="width: 100%; text-align: right;direction: rtl;font-family: system-ui;">
						<tr style="height: 40px !important;">
							<td><b>نام : </b> {{ $order->recipient->name }}</td>
							<td><b>نام خانوادگی : </b> {{ $order->recipient->family }}</td>
							<td><b>کدملی : </b> {{ $order->recipient->nationalCode }}</td>
							<td><b>شماره موبایل : </b> {{ $order->recipient->mobile }}</td>
						</tr>
						<tr style="height: 40px !important;">
							<td colspan="3">
								<b>آدرس   : </b> {{ $order->recipient->city->name }} - {{ $order->recipient->subcity->name }} - {{ $order->recipient->address }} - پلاک {{ $order->recipient->houseId }}
							</td>
							<td><b>کد پستی : </b> {{ $order->recipient->zipcode }}</td>
						</tr>
					</table>
				</td>
			</tr>
			@php
				$payment = $order->payments()->where('tracing_code','<>','')->orWhere('res_code','0')->first();
				// dd($payment->count);
			@endphp
			@isset($payment)
				<tr style="height: 40px !important;">
					<td style="font-weight: bold;background-color: #f6f5f5;height: 50px;direction: rtl;text-align: right;">
						اطلاعات پرداخت به روش  {{ $payment->payment_method->title }}
					</td>
				</tr>
				<tr style="height: 40px !important;">
					<td>
						<div style="margin-bottom: 15px;float: right;width: 33%;margin-top: 15px;">
							<b>شماره ارجاع یا شماره پیگیری : </b><span>{{ $payment->tracing_code  ?? $payment->saleReferenceId }}</span>
						</div>
						<div style="margin-bottom: 15px;float: right;width: 33%;margin-top: 15px;">
							<b>تاریخ پرداخت : </b><span>{{ Verta($payment->date)->format('%d %B، %Y H:m:s') }}</span>
						</div>
						<div style="margin-bottom: 15px;float: right;width: 33%;margin-top: 15px;">
							<b>پرداختی : </b><span>{{ number_format($payment->price) }} {{ $order->local }}</span>
						</div>
					</td>
				</tr>
			@endisset
			
			<tr style="height: 40px !important;">
				<td style="font-weight: bold;background-color: #f6f5f5;height: 50px;direction: rtl;text-align: right;">
					اطلاعات ارسال سفارش
				</td>
			</tr>
			<tr style="height: 40px !important;">
				<td>
					<div style="margin-bottom: 15px;float: right;width: 33%;margin-top: 15px;">
						<b>روش ارسال : </b><span>{{ $order->post->title }}</span>
					</div>
					<div style="margin-bottom: 15px;float: right;width: 33%;margin-top: 15px;">
						<b>هزینه ارسال : </b><span>{{ $order->postPrice }} {{ $order->local }}</span>
					</div>
					<div style="margin-bottom: 15px;float: right;width: 33%;margin-top: 15px;">
						<b>مدت زمان ارسال :</b><span> حداکثر {{ $order->post->delivery_time }}</span>
					</div>
				</td>
			</tr>
			
			<tr style="height: 40px !important;">
				<td>
					<p style="margin-top: 70px;direction: rtl; text-align: justify;">
						با سپاس از اعتماد و خرید شما از فروشگاه ترمه سالاری، بهترین ها را برای شما آرزومندیم. در صورت داشتن هر گونه سوال و یا راهنمایی، می توانید با ما در ارتباط باشید:
					</p>
				</td>
			</tr>

			<tr style="direction: ltr; height: 40px !important;text-align: left;">
				<td>
					<div style="float: left;width: 33%;">
						<img src="{{ asset('storetemplate/dist/img/phone.png') }}" style="vertical-align: middle;">
						<span> 035 3622 38 80</span>
					</div>
					<div style="float: left;width: 33%;">
						<img src="{{ asset('storetemplate/dist/img/instagram.png') }}" style="vertical-align: middle;">
						<span> https://www.instagram.com/termehsalari</span>
					</div>
					<div style="float: left;width: 33%;">
						<img src="{{ asset('storetemplate/dist/img/telegram.png') }}" style="vertical-align: middle;">
						<span> https://telegram.me/termeh_salari</span>
					</div>
			</tr>
			<tr style="direction: ltr; height: 40px!important;text-align: left;">
				<td>
					<div style="float: left;width: 33%;">
						<img src="{{ asset('storetemplate/dist/img/whatsApp.png') }}" style="vertical-align: middle;">
						<span> 0913 457 7500</span>
					</div>
					<div style="float: left;width: 33%;">
						<img src="{{ asset('storetemplate/dist/img/mail.png') }}" style="vertical-align: middle;">
						<span> Info@TermehSalari.com</span>
					</div>
				</td>
			</tr>
			
		</table>
	{{-- </div> --}}

</body>
</html>