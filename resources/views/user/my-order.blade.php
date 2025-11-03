@extends("user.user-layout")

@push('user-link')
	<style type="text/css">
		a.nav-link.active{
			border: 0;
			border-bottom: 1px solid #aaaaaa !important;
			color: #aaaaaa !important;
		}

		a.nav-link.active >i{
			color: #aaaaaa;
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

@section('title','جزئیات سفارش')
@section("card-title","جزئیات سفارش")
	


@push('link')

@endpush

@section("user-content")
{{-- @dd($order) --}}
	<div class="row m-4" style="font-weight: bold;">
		<div class="col-md-6 col-sm-12 text-right">
			کد  فاکتور : 
			{{ $order->code }}
		</div>

		<div class="col-md-6 col-sm-12 text-left">
			تاریخ  : 
			{{ Verta($order->created_at)->format('%d %B %Y') }} - {{ $order->created_at->toTimeString() }}
		</div>
	</div>
	<div id="order{{$order->id}}" class="card-body" style="font-size: 90%;overflow-x: auto;">
		<table class="table w-10" style="font-size: 95%">
			<tr>
				<th>ردیف</th>
				<th>عنوان  محصول</th>
				<th>تعداد</th>
				<th>مبلغ</th>
				<th>تخفیف</th>
				<th>قابل پرداخت</th>
				
			</tr>
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
		</table>
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
		<div class="row mt-4">

			<div class="col-sm-12 col-md-3 mb-4 text-center">
				<b>جمع کل </b>
				<p>{{ number_format($sumPrice) }} {{ $order->local }}</p>
			</div>
			<div class="col-sm-12 col-md-3 mb-4 text-center">
				<b>جمع تخفیف </b>
				<p>{{ number_format($sumOff) }} {{ $order->local }}</p>
			</div>
			@if($order->discount_card_id != "")
				<div class="col-sm-12 col-md-3 mb-4 text-center">
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
			<div class="col-sm-12 col-md-3 mb-4 text-center">
			<b>جمع پرداختی به همراه هزینه ارسال </b>
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
						{{ Verta($order->post_date)->format('%d %B، %Y H:m:s') }}
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
				<div class="col-md-4 col-sm-12 mb-4">
					<b>شماره ارجاع یا شماره پیگیری : </b><span>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</span>
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

		<button  onclick="history.back()" class="btn btn-secondary btn-flat float-right">بازگشت</button>

	</div>
@endsection

@push('js')

<script>
$(function(){

})//End

</script>
@endpush