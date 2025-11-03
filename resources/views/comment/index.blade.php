@extends('admin-layout')

@section('title','لیست نظرات کاربران')

@push('link')
<!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.css')}}">
  {{-- Rating --}}
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/css-stars.css')}}">
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css')}}">
	<!-- iCheck for checkboxes and radio inputs -->
  	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
@endpush

@section('main-content')
	<section class="content">
        <div class="col-12">
			<div class="card">
            <div class="card-header">
              	<h3 class="card-title">
	              	<span>نظرات کاربران</span>
	          	</h3>
            </div>
            <div class="card-body">
              <table id="dataTable-table" class="table table-striped display nowrap dataTable" cellspacing="0" style="width:100%;">
                <thead>
	                <tr>
	                	<th class="no-sort">
		                    <input id="" type="checkbox" data-value = "All" class="flat-red checkAll">
		                </th>
						<th class="no-sort">ردیف</th>
						<th>عنوان محصول</th>
						<th>نام کاربر</th>
						<th>تاریخ</th>
						<th>نظرات</th>
						<th class="no-sort">امتیاز</th>
						<th>انتشار/ عدم انتشار</th>
	                </tr>
                </thead>
                <tbody>
                	
                @foreach($comments as $key=>$comment)
	                <tr>
	                	<td>
		                    <input type="checkbox" data-value="{{$comment->id}}" class="flat-red checkbox">
	                	</td>
						<td>{{$loop->iteration}}</td>
						<td>
							<img src="{{asset('storage/images/thumbnails/'. $comment->commentable->images->first()->name)}}" alt="" class="img-circle img-size-50 mr-2">
							{{$comment->commentable->category->title}} طرح {{$comment->commentable->color_design->design->title}} رنگ {{$comment->commentable->color_design->color->color}}</td>
						<td>{{$comment->user->name}}  {{$comment->user->family}}</td>
						<th>{{ Verta($comment->created_at)->format('%d %B %Y') }}</th>
						<td>
							<a class="text-info" href="#" data-toggle="modal" data-target="#commentText{{$key}}" >
								{{Str::limit($comment->text,50)}}
							</a>

							<div class="modal fade" id="commentText{{$key}}" tabindex="-1" role="dialog" aria-labelledby="commentTextLabel" aria-hidden="true">
	                            <div class="modal-dialog modal-dialog-centered" role="document">
	                                <div class="modal-content">
	                                    <div class="modal-header">
	                                        <h5 class="modal-title" id="commentTextLabel">
	                                        	{{$comment->user->name}}  {{$comment->user->family}}
	                                        </h5>
	                                    </div>
	                                    <div class="modal-body">
	                                        <p>{{$comment->text}}</p>

	                                    </div>
	                                    <div class="modal-footer">
	                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>

						</td>
						<td>
							<div class="br-wrapper br-theme-fontawesome-stars float-left">
								<select class="showGrade{{$key}}" data-value="{{$comment->user->grades
									->where('gradeable_id',$comment->commentable_id)
									->where('gradeable_type',$comment->commentable_type)
									->first()->grade ?? '0'}}"> <!-- now hidden -->
								    <option value="1">1</option>
								    <option value="2">2</option>
								    <option value="3">3</option>
								    <option value="4">4</option>
								    <option value="5">5</option>
								</select>
			              	</div>
						</td>
						<td>
							@if($comment->status == 0)
								<a class="changeStatuse" href="#" data-id="{{$comment->id}}"><i class="fas fa-close danger-color"></i></a> 
							@else
								<a class="changeStatuse" href="#" data-id="{{$comment->id}}"><i class="fas fa-check success-color"></i> </a>
							@endif
						</td>
	                </tr>
	            @endforeach
                </tbody>

                <tfoot>
                <tr>
                	<th></th>
					<th>ردیف</th>
					<th>عنوان محصول</th>
					<th>نام کاربر</th>
					<th>تاریخ</th>
					<th>نظرات</th>
					<th>امتیاز</th>
					<th>انتشار/ عدم انتشار</th>
                </tr>
                </tfoot>
              </table>
              <div class="buttons">
              	<a href="" id="changeStatuse_group" class="btn btn-primary btn-flat">{{-- <i class="fas fa-view"></i>  --}}انتشار/ عدم انتشار</a>
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
	<script src="{{asset('/storetemplate/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
	{{-- <script src="{{asset('/storetemplate/dist/js/dataTable.js')}}"></script> --}}
	{{-- jqueryBarRating --}}
	<script src="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/iCheck-custom.js')}}"></script>
	<!-- page script -->
	<script>
	$(function () {
		//------------------------------Data Table----------------------------------
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
			       	// { "width": "40%", "targets": 6 }
		       	],
		       	"createdRow": function ( row, data, index ) {
		            if ( data[5]) {
		            	var rate = $('td', row).eq(5).find("[class*='showGrade']").data('value');
		                $('td', row).eq(5).find("select[class*='showGrade']").barrating({
						 	theme:'fontawesome-stars-o',
							initialRating: rate,
						 	readonly:true,
						});
		            }
		        }
		    });

//-----------------------change Statuse---------------------------
		$(document).on('click', '.changeStatuse', function(event){
			event.preventDefault();
			event.stopPropagation();
			var url = "{{url('/comment/changeStatus')}}";
			var id = $(this).data("id");
			var $thiz = $(this);
			$.ajax({
			    type: 'GET',
			    url: url +"/"+id ,
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
//-----------------------------change Statuse group--------------------------------
		$('#changeStatuse_group').click(function(event){
			event.preventDefault();
			event.stopPropagation();
			var items = [];
			var url = "{{route('comment.chnageStatusGroup')}}"
	  		$("#dataTable-table").find("div[aria-checked='true']").children("input").each(function(index){
				items[index] = $(this).data("value");
				// $(this).closest('tr').fadeOut('slow');
			});

			// console.log(items);
		    $.ajax({
	            type:'POST',
	            url: url,
	            data: {
	              _token: '<?php echo csrf_token() ?>', // this is optional cause you already added it header
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
							var $thiz = $(this).parents("tr").find("a[class='changeStatuse']").children("i");
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
	    
	  });
	</script>
@endpush