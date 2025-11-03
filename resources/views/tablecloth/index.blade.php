@extends('admin-layout')

@section('title','پنل مدیریت | محصولات رومیزی')

@push('link')
<!-- DataTables -->
  <link rel="stylesheet" href="{{asset('../storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
{{-- Rating --}}
<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/css-stars.css')}}">
<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css')}}">
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

			<div class="card">
            <div class="card-header">
              	<a href="{{ route('tablecloth.create') }}" class="pr-3 pl-3 pt-2 pb-2 btn btn-flat btn-danger float-left " title="محصول جدید">+</a>
              	<h3 class="card-title float-right">
              		<span>
              			لیست محصولات رومیزی
              		</span>
              	</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="dataTable-table" class="table table-striped display nowrap dataTable" style="width:100%;text-align: center;" cellspacing="0">
                <thead>
	                <tr>
	                	<th class="no-sort">
	                		<label>
		                    	<input type="checkbox" data-value = "All" class="flat-red checkAll">
		                  	</label>
		                </th>
						<th class="no-sort">ردیف</th>
						<th>کد</th>
						{{-- <th>عنوان</th> --}}
						<th>دسته بندی</th>
						<th>طرح</th>
						<th>رنگ</th>
						<th>قیمت (تومان)</th>
						<th>تخفیف</th>
						<th>موجودی</th>
						<th class="no-sort">امتیاز</th>
						<th>نمایش</th>
						<th>کپی</th>
						<th class="no-sort">جزئیات</th>
						<th class="no-sort">ویرایش</th>
						<th class="no-sort">نظرات</th>
						<th class="no-sort">حذف</th>
	                </tr>
                </thead>
                <tbody>
                	
                @foreach($tablecloths as $key=>$tablecloth)
                {{-- {{ dd($tablecloth) }} --}}
	                <tr>
	                	<td>
	                		<label>
		                    	<input type="checkbox" data-value = "{{$tablecloth->id}}" class="flat-red checkbox">
		                  	</label>
	                	</td>
						<td>{{$loop->iteration}}</td>
						<td>{{$tablecloth->code}}</td>
						<td>
							@if($tablecloth->images->first())
							@php
								$image = $tablecloth->images->first();
							@endphp
							
							<img src="{{ asset('storage/images/thumbnails/'. $tablecloth->images->first()->name)}}" alt="" class="img-circle img-size-50 mr-2">

							@endif
							{{ $tablecloth->title }}
						</td>
						{{-- <td>{{$tablecloth->category->title}}</td> --}}
						<td>{{ $tablecloth->color_design->design->title }}</td>
						<td>
							@php
								$prices = $tablecloth->prices->where('local','تومان')->first();
								$designColor = $tablecloth->color_design->color->color; 
								print $designColor; 
							 @endphp
						</td>

						<td>{{ number_format($prices->price) }}</td>
						<td>
							@if($prices->offPrice > 0)
								@if($prices->offType == 'مبلغ')
									{{number_format($prices->offPrice)}} 
									<small class="badge badge-danger">{{ round(($prices->offPrice * 100) / $prices->price , 1) }}%</small>

								@elseif($prices->offType == 'درصد')
									{{ number_format(($prices->offPrice * $prices->price) / 100) }} 
									<small class="badge badge-danger">{{ $prices->offPrice }}%</small>
									  
								@endif
							@endif
						</td>
						<td>{{$tablecloth->quantity}}</td>
						<td>
							<div class="br-wrapper br-theme-fontawesome-stars float-left">
								{{-- {{$tablecloth->grades->avg('grade') ?? '0'}} --}}
								<select class="showGrade{{$key}}" data-value="{{ $tablecloth->grades->avg('grade') ?? '0' }}"> 
								    <option value="1">1</option>
								    <option value="2">2</option>
								    <option value="3">3</option>
								    <option value="4">4</option>
								    <option value="5">5</option>
								</select>
			              	</div>
						</td>
						<td>
							@if($tablecloth->visibility == 0)
								<a class="changeVisibility" href="#" data-id="{{$tablecloth->id}}"><i class="fas fa-close danger-color"></i></a> 
							@else
								<a class="changeVisibility" href="#" data-id="{{$tablecloth->id}}"><i class="fas fa-check success-color"></i> </a>
							@endif
						</td>
						<td>
							{{-- <a href="{{ route('tablecloth.duplicate',[$tablecloth]) }}"><i class="fas fa-copy text-primary"></i></a> --}}
							<a href="{{ route('tablecloth.duplicate',[$tablecloth]) }}" class="btn btn-outline-secondary btn-flat btn-sm"><i class="fas fa-copy"></i> کپی  </a>
						</td>
						<td><a href="{{route('tablecloth.show',[$tablecloth])}}" target="blank" class="btn btn-outline-info btn-flat btn-sm"><i class="fas fa-info-circle"></i> جزئیات </a></td>
						<td><a href="{{route('tablecloth.edit',[$tablecloth])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-edit"></i> ویرایش </a></td>
						<td><a href="{{route('comment.product',['Tablecloth',$tablecloth->id])}}" class="btn btn-outline-primary btn-flat btn-sm"><i class="fas fa-comment"></i> نظرات </a></td>

						<td>
							<form class="del-form" action="{{route('tablecloth.destroy', [$tablecloth])}}" method="post">
								@csrf
								@method('delete')
								<a href="#" data-id="{{$tablecloth->id}}" data-model="Tablecloth" class="btn btn-outline-danger btn-flat btn-sm delete"><i class="fas fa-trash-alt"></i> حذف </a>
							</form>
						</td>
	                </tr>
	            @endforeach
                </tbody>

                <tfoot>
	                <tr>
	                	<th></th>
	                  	<th>ردیف</th>
	                  	<th>کد</th>
						{{-- <th>عنوان</th> --}}
						<th>دسته بندی</th>
						<th>طرح</th>
						<th>رنگ</th>
						<th>قیمت (تومان)</th>
						<th>تخفیف</th>
						<th>موجودی</th>	
						<th>امتیاز</th>
						<th>نمایش</th>
						<th>کپی</th>
						<th>جزئیات</th>
						<th>ویرایش</th>
						<th>نظرات</th>
						<th>حذف</th>
	                </tr>
                </tfoot>
              </table>
              <div class="buttons">
              	<a href="" id="changeVisibilityGroup" class="btn btn-primary btn-flat">نمایش / عدم نمایش</a>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
           </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
	<!-- DataTables -->
	<script src="{{asset('/storetemplate/plugins/datatables/jquery.dataTables.js')}}"></script>
	{{-- <script src="{{asset('/storetemplate/dist/js/dataTable.js')}}"></script> --}}
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script>
	{{-- jqueryBarRating --}}
	<script src="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>
	<!-- page script -->
<script>
$(function(){
//------------------------Data Table--------------------------
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
		       	{ "width": "10%", "targets": 9 }
	       	],
	       	"createdRow": function ( row, data, index ) {
	            if ( data[9]) {
	            	var rate = $('td', row).eq(9).find("[class*='showGrade']").data('value');
	                $('td', row).eq(9).find("[class*='showGrade']").barrating({
					 	theme:'fontawesome-stars-o',
						initialRating: rate,
					 	readonly:true,
					});
	            }
	        }

	    });
//-------------------Show Grade-----------------------------
	{{-- @foreach($tablecloths as $key=>$tablecloth)
		$('.showGrade{{$key}}').barrating({
		 	theme:'fontawesome-stars-o',
			initialRating: "{{$tablecloth->grades->avg('grade') ?? '0'}}",
		 	readonly:true,
		});
	@endforeach --}}
//-------------------Delete Product------------------
	$(document).on('click', '.delete', function(event){
		event.preventDefault();
		var id = $(this).data("id");
		var model = $(this).data("model");
		var thiz = $(this);
		var addr = thiz.parents('.del-form').attr('action');
		swal({
		  title: "آیا از حذف این محصول مطمئن هستید؟",
		  text: "این کار غیر قابل بازگشت می باشد.",
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
		              _token: '<?php echo csrf_token() ?>', // this is optional cause you already added it header
		              _method : 'DELETE',
		              id: id ,
		              model: model ,
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
				        	thiz.closest("tr").fadeOut('slow');
				        }
				        swal(title, data.message,data.res);
		            }
	        	});
			    // swal("Poof! Your imaginary file has been deleted!", {
			    //   icon: "success",
			    // });
			}
		  // else {
		  //   swal("Your imaginary file is safe!");
		  // }
		});
	});
	//-----------------------change Statuse---------------------------
	$(document).on('click', '.changeVisibility', function(event){
		event.preventDefault();
		var url = "{{ route('tablecloth.changeVisibility') }}";
		var id = $(this).data("id");
		var $thiz = $(this);
		$.ajax({
		    type: 'POST',
		    url: url ,
		    data: {
              	_token: '<?php echo csrf_token() ?>',
              	id: id,
            },
		    success: function(data){
		    	// $("body").html(data);
		        // console.log(data);
		        var $i = $thiz.children("i");
		        if($i.hasClass("fa-check"))
		        {
		        	$i.removeClass("fa-check success-color");
		        	$i.addClass("fa-close danger-color");
		        }
		        else if ($i.hasClass("fa-close"))
		        {
		        	$i.removeClass("fa-close danger-color");
		        	$i.addClass("fa-check success-color");
		        }
	
		        if(data.res == "error")
		        {
		        	title = "خطا  در اجرای عملیات" ;
		        }
		        else if(data.res == "success")
		        {
		        	title = "عملیات با موفقیت انجام شد.";
		        }
		        swal(title, data.message,data.res);
		    }
		});
	});
//----------change Statuse group--------------------------------
	$('#changeVisibilityGroup').click(function(event){
		event.preventDefault();
		var items = [];
		var url = "{{ route('tablecloth.changeVisibilityGroup') }}"
  		$("#dataTable-table").find("div[aria-checked='true']").children("input").each(function(index){
			items[index] = $(this).data("value");
			// $(this).closest('tr').fadeOut('slow');
		});

		// console.log(items);
	    $.ajax({
            type:'POST',
            url: url,
            data: {
              	_token: '<?php echo csrf_token() ?>',
              	items: items,
            },
            success:function(data){
               if(data.res == "error")
		        {
		        	title = "خطا  در اجرای عملیات" ;
		        }
		        else if(data.res == "success")
		        {
		        	title = "عملیات با موفقیت انجام شد.";
		        	$("#dataTable-table").find("div[aria-checked='true']").each(function(index)
		        	{
		        		$(this).find('.icheckbox_flat-blue').iCheck('uncheck');
						$(this).removeClass("bg-skyblue");
						var $thiz = $(this).parents("tr").find("a[class='changeVisibility']").children("i");
						if($thiz.hasClass("fa-check"))
				        {
				        	$thiz.removeClass("fa-check success-color");
				        	$thiz.addClass("fa-close danger-color");
				        }
				        else if ($thiz.hasClass("fa-close"))
				        {
				        	$thiz.removeClass("fa-close danger-color");
				        	$thiz.addClass("fa-check success-color");
				        }
						
					});
		        }
		        swal(title, data.message,data.res);
            }
        });
	});


})//End

</script>
@endpush