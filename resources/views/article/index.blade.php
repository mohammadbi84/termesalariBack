@extends('admin-layout')

@section('title','لیست صفحات داخلی')

@push('link')
	<!-- DataTables -->
  	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
@endpush

@section('main-content')
	<section class="content">
		<div class="row">
	        <div class="col-12">
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
		    </div>
		</div>
		<div class="card">
			<div class="card-header">
				<a href="{{ route('article.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="محصول جدید">+</a>
				<div class="card-title float-right"><span>صفحات داخلی</span></div>
			</div>
			<div class="card-body">
				<table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0">
					<thead>
						<tr>
							<th class="no-sort">ردیف</th>
							<th>عنوان</th>
							<th>لینک</th>
							<th>نمایش</th>
							<th class="no-sort">ویرایش</th>
							<th class="no-sort">حذف</th>
						</tr>
					</thead>
					<tbody>
						@foreach($articles as $article)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>
                                {{ $article->title }}
							</td>
							<td>
                                {{ route('article.show',[$article]) }}
							</td>
							<td>
                                <a href="{{ route('article.show',[$article]) }}" class="btn btn-outline-success btn-flat btn-sm"><i class="fas fa-eye"></i> نمایش </a>
                            </td>
							<td>
								<a href="{{route('article.edit',[$article])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش </a>
							</td>
							<td>
								<form class="del-form" action="{{route('article.destroy', [$article])}}" method="post">
									@csrf
									@method('delete')
									{{-- <input type="submit" class="btn btn-outline-danger btn-flat delete" value="حذف " name="submit"> --}}
									<a href="#" class="btn btn-outline-danger btn-flat btn-sm delete"><i class="fas fa-trash-alt"></i> حذف </a>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>
@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	{{-- <script src="{{asset('/storetemplate/dist/js/dataTable.js')}}"></script> --}}
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script>
	<script>
		$(function () {
			$(document).on('click', '.delete', function(event){
				event.preventDefault();
				// event.stopPropagation();
				var $thiz = $(this);
				swal({
				  	title: "آیا از حذف این صفحه مطمئن هستید؟",
				  	text: "با انجام این کار، این صفحه حذف خواهد شد.",
				  	icon: "warning",
				   	buttons: ["انصراف","حذف"],
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
						// title = "عملیات با موفقیت انجام شد.";
						// swal(title, data.message,data.res);
						// thiz.closest("tr").fadeOut('slow');
				        // $thiz.unbind('click').click();
				        $thiz.parent('.del-form').submit()
			        }
				});
			});

			$('#dataTable-table').DataTable({
		        "language": {
		            "paginate": {
		                "next": "بعدی",
		                "previous" : "قبلی",
		            },
		            // "searchPanes":{
		            // 	"count":'{total} found',
		            // 	"countFiltered": '{shown} ({total})',
		            // },
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
		       	// "saerchPanes":{
		       	// 	"viewTotal":true,
		       	// },
		       	// "dom":'Pfrtip'


		    });

		});
	</script>
@endpush
