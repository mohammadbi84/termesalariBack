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

@section('title','پرداخت های من')
@section("card-title","تاریخچه پرداخت ها")
	


@push('link')
<!-- DataTables -->
  <link rel="stylesheet" href="{{asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush

@section("user-content")
	{{-- <section class="content">
      	<div class="row">
	        <div class="col-12">
				<div class="card">
		            <div class="card-header">
		              	<h3 class="card-title float-right">
		              		<span>
		              			لیست پرداخت ها
		              		</span>
		              	</h3>
		            </div>
		            
		            <div class="card-body"> --}}
			            <table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0">
			            	<thead>
				                <tr>
									<th class="no-sort">ردیف</th>
									<th>روش پرداخت</th>
									<th>شماره ارجاع یا تراکنش</th>
									<th>مبلغ (تومان)</th>
									<th>تاریخ </th>
									<th>کد فاکتور</th>
									<th>توضیحات</th>
				                </tr>
			                </thead>

			                <tbody>	
				                @foreach($listPayments as $key=>$payment)
				                	{{-- {{ dd($payment) }} --}}
					                <tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $payment->payment_method->title }}</td>
										<td>{{ $payment->tracing_code ?? $payment->saleReferenceId }}</td>
										<td>{{ number_format($payment->price) }}</td>
										<td>{{ Verta($payment->date)->format('%d %B %Y H:m:s') }}</td>
										<td><a href="{{ route('user.myOrder',[$payment->order]) }}">{{ $payment->order->code }}</a></td>
										<td>{{ $payment->description }}</td>
					                </tr>
					            @endforeach
			                </tbody>

			                <tfoot>
				                <tr>
				                	<th class="no-sort">ردیف</th>
									<th>روش پرداخت</th>
									<th>شماره ارجاع یا تراکنش</th>
									<th>مبلغ</th>
									<th>تاریخ </th>
									<th>کد فاکتور</th>
									<th>توضیحات</th>
				                </tr>
			                </tfoot>
			            </table>
		            {{-- </div> --}}
		            <!-- /.card-body -->
	          	{{-- </div> --}}
	          <!-- /.card -->
	        {{-- </div> --}}
	        <!-- /.col -->
	    {{-- </div> --}}
	    <!-- /.row -->
    {{-- </section> --}}
    <!-- /.content -->
@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<script>
$(function(){

	$('#dataTable-table').DataTable({
        "language": {
            "paginate": {
                "next": "بعدی",
                "previous" : "قبلی",
            },
            "decimal": ",",
            "thousands": ".",
            "search" : "جستجو : ",
            "lengthMenu":'نمایش   <select>'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">همه</option>'+
                '</select> سطر' ,

        },
		"info" : false,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"autoWidth": true,
		"scrollX": true,
       	"responsive": true,
       	"order":[],
       	"columnDefs":[
	       	{ "targets":'no-sort',"orderable":false,},
       	],	
	});
})//End

</script>
@endpush