@extends('admin-layout')

@section('title','جزئیات گیرنده ')

@push('link')
	<!-- DataTables -->
 	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
 	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
@endpush

@section('main-content')
	<section class="content">
	    <div class="row">
	    	<div class="col-12">
	    		<div class="card">
					<div class="card-header">
						<div class="card-title"><span>{{ $recipient->name }} {{ $recipient->family }}</span></div>
					</div>	
					<div class="card-body">
						{{-- {{ dd($orders) }} --}}
						<table class="table">
		      				<tr>
		      					<th>ردیف</th>
		      					<th>کد فاکتور</th>
		      					<th>تاریخ</th>
		      					<th>سفارش دهنده</th>
		      					<th>تعداد</th>
		      					<th>جمع کل</th>
		      					<th>تخفیف</th>
		      					<th>پرداختی</th>
		      					<th>جزئیات</th>		      					
		      				</tr>
		      				@foreach($orders as $order)
		      					<tr>
		      						<td>{{ $loop->iteration }}</td>
		      						<td>{{ $order->code }}</td>
		      						<th>{{ Verta($order->created_at)->format('%d %B %Y') }}</th>
		      						<td>{{ $order->user->name }} {{ $order->user->family }}</td>
		      						@php 
										$count = 0;
										$total = 0;
										$price = 0;
										$off = 0;
										foreach ($order->orderitems as $orderitem) {
											$count = $count + $orderitem->count;
											$prices = $orderitem->orderitemable->prices->where('local',$order->local)->first();
											$price = $price + ($prices->price * $orderitem->count);
											$off = $off + ($prices->offPrice * $orderitem->count);
											$total = $price - $off;
										}
										$pay = $total + $order->post->price;
									@endphp
									<td>{{ $count }}</td>
									<td>{{ number_format($total) }} {{ $order->local }}</td>
		      						<td>{{ (number_format($off)) ?? "-" }} {{ $order->local }}</td>
		      						<td>{{ number_format($pay) }} {{ $order->local }}</td>
		      						<td><a href="{{ route('order.show',[$order]) }}" class="btn btn-sm btn-outline-info btn-flat"><i class="fas fa-info-circle" style=""></i> جزئیات </a></td>
		      					</tr>
		      				@endforeach
		      			</table>
		      			<a href="{{ route('recipient.index') }}" class="btn btn-secondary btn-flat float-left">بازگشت</a>
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
	<script>
		$(function () {



		})//END
	</script>

@endpush