@extends('admin-layout')

@section('title','لیست گیرندگان')

@push('link')
	<!-- DataTables -->
 	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
 	<!-- iCheck for checkboxes and radio inputs -->
	{{-- <link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}"> --}}
@endpush

@section('main-content')
	<section class="content">
	    <div class="row">
	    	<div class="col-12">
	    		<div class="card">
		            <div class="card-header">
		              	<h3 class="card-title float-right"><span>لیست گیرندگان</span></h3>
		            </div>
		            <!-- /.card-header -->
		            <div class="card-body">
		              	<table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0">
			                <thead>
				                <tr>
				                	{{-- <th class="no-sort">
					                    <input type="checkbox" data-value = "All" class="flat-red checkAll">
					                </th> --}}
									<th class="no-sort">ردیف</th>
									<th>نام و نام خانوادگی</th>
									<th>کد ملی</th>
									<th>موبایل</th>
									<th>نام شهر</th>
									<th>نام شهرستان</th>
									<th>آدرس</th>
									<th>کد پستی</th>
									<th class="no-sort">جزئیات</th>
				                </tr>
			                </thead>
			                <tbody>	
				                @foreach($recipients as $recipient)
				                {{-- {{ dd($recipient) }} --}}
					                <tr>
					                	{{-- <td>
						                    <input type="checkbox" data-value ="{{ $recipient->id }}" class="flat-red checkbox">
					                	</td> --}}
										<td class="no-sort">{{ $loop->iteration }}</td>
										<td>{{ $recipient->name }} {{ $recipient->family }}</td>
										<td>{{ $recipient->nationalCode }}</td>
										<td>{{ $recipient->mobile }}</td>
										<td>{{ $recipient->city->name }}</td>
										<td>{{ $recipient->subcity->name }}</td>
										<td>{{ $recipient->address }} @isset($recipient->houseId)پلاک {{ $recipient->houseId }} @endisset</td>
										<td>{{ $recipient->zipcode }}</td>
										<td><a href="{{ route('recipient.show',[$recipient]) }}" class="btn btn-sm btn-outline-info btn-flat"><i class="fas fa-info-circle" style=""></i> جزئیات </a></td>
					                </tr>
					            @endforeach
			                </tbody>

			                <tfoot>
				                <tr>
				                	<th>ردیف</th>
									<th>نام و نام خانوادگی</th>
									<th>کد ملی</th>
									<th>موبایل</th>
									<th>نام شهر</th>
									<th>نام شهرستان</th>
									<th>آدرس</th>
									<th>کد پستی</th>
									<th>جزئیات</th>
				                </tr>
			                </tfoot>
		            	</table>
		            	{{-- <a href="#" id="changeStatuseGroup" class="btn btn-primary btn-flat">تغییر وضعیت</a> --}}

		            </div>
		            <!-- /.card-body -->
	          	</div>
	          	<!-- /.card -->

	    	</div>
	    </div>
	</section>
@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	{{-- <script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script> --}}
	<script>
		$(function () {

//------------------------------Data Table--------------------------
		    $('.dataTable').DataTable({
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
			       	// { "width": "10%", "targets": 9 }
		       	],
		    });


		})//END
	</script>

@endpush