@extends('admin-layout')

@section('title','داشبورد')

@push('link')
	
@endpush

@section('main-content')
{{-- {{ dd($currentYearData) }} --}}
	<section class="content">
	    <div class="row">
	    	<div class="col-12">
				<div class="card">
		            <div class="card-header">
		              	<h3 class="card-title float-right"><span>داشبورد</span></h3>
		            </div>
		            <!-- /.card-header -->
		            <div class="card-body">
		            	<div class="row">
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-info">
									<div class="inner">
										<h3 class="text-center">{{ $countComments }}</h3>
										<p>نظرات ثبت شده</p>
									</div>
								  	<div class="icon">
								    	<i class="ion ion-bag"></i>
								  	</div>
								  	<a href="{{ route('comment.index') }}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-success">
								  	<div class="inner">
								    	<h3 class="text-center">{{ $countOrderitems }}</h3>
								    	<p>تعداد کالای فروخته شده</p>
								  	</div>
								  	<div class="icon">
								   		<i class="ion ion-stats-bars"></i>
								  	</div>
								  	<a href="{{ route('order.index') }}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
							<!-- small box -->
								<div class="small-box bg-warning">
							  		<div class="inner">
							    	<h3 class="text-center">{{ $countUsers }}</h3>
							    	<p>کاربران ثبت شده</p>
							  	</div>
							  	<div class="icon">
							   		<i class="ion ion-person-add"></i>
							  	</div>
							  	<a href="{{ route('user.index') }}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
							<!-- small box -->
								<div class="small-box bg-danger">
							  		<div class="inner">
							    		<h3 class="text-center">{{ $countNewsletters }}</h3>
							    		<p>اعضای خبرنامه</p>
							  		</div>
							  		<div class="icon">
							    		<i class="ion ion-pie-graph"></i>
							  		</div>
							  		<a href="{{ route('newsletter.index') }}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
								</div>
							</div>
							<!-- ./col -->
							</div>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="row">
          	<div class="col-md-12">
            	<div class="card">
	              	<div class="card-header" style="padding: .75rem 1.25rem;">
	                	<h5 class="card-title">گزارش ماهیانه</h5>
	                	<div class="card-tools">
	                  		<button type="button" class="btn btn-tool" data-widget="collapse">
	                    		<i class="fa fa-minus"></i>
	                  		</button>
	                  		{{-- <div class="btn-group">
	                    		<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
	                      			<i class="fa fa-wrench"></i>
	                    		</button>
	                    		<div class="dropdown-menu dropdown-menu-left" role="menu">
	                      			<a href="#" class="dropdown-item">منو اول</a>
	                      			<a href="#" class="dropdown-item">منو دوم</a>
	                      			<a href="#" class="dropdown-item">منو سوم</a>
	                      			<a class="dropdown-divider"></a>
	                      			<a href="#" class="dropdown-item">لینک</a>
	                    		</div>
	                  		</div> --}}
	                  		<button type="button" class="btn btn-tool" data-widget="remove">
	                    		<i class="fa fa-times"></i>
	                  		</button>
	                	</div>
	              	</div>
	              	<!-- /.card-header -->
	              	<div class="card-body">
	                	<div class="row">
	                		<div class="col-md-3 col-sm-12">
			                    <p class="text-center">
			                      <strong>میزان پیشرفت اهداف</strong>
			                    </p>

	                    		<div class="progress-group">
	                      			محصولات اضافه شده 
		                      		<span class="float-left"><b>{{ $countProducts }}</b>/۲۰۰</span>
		                      		<div class="progress progress-sm">
		                        		<div class="progress-bar bg-primary" style="width: 80%"></div>
		                      		</div>
	                    		</div>
	                    		<!-- /.progress-group -->

			                    <div class="progress-group">
			                      	سفارش ثبت شده
			                      	<span class="float-left"><b>{{ $countOrders }}</b>/۴۰۰</span>
			                      	<div class="progress progress-sm">
			                        	<div class="progress-bar bg-danger" style="width: 75%"></div>
			                      	</div>
			                    </div>

			                    <!-- /.progress-group -->
			                    <div class="progress-group">
			                      	<span class="progress-text">اقلام فروخته شده</span>
			                      	<span class="float-left"><b>{{ $countOfTypeProducts }}</b>/۸۰۰</span>
			                      	<div class="progress progress-sm">
			                        	<div class="progress-bar bg-success" style="width: 60%"></div>
			                      	</div>
			                    </div>

			                    <!-- /.progress-group -->
			                    <div class="progress-group">
			                      کاربر ثبت شده
			                      	<span class="float-left"><b>{{ $countUsers }}</b>/۵۰۰</span>
			                      	<div class="progress progress-sm">
			                        	<div class="progress-bar bg-warning" style="width: 50%"></div>
			                      	</div>
			                    </div>
	                    		<!-- /.progress-group -->
	                  		</div>
	                  		<!-- /.col -->
	                  		<div class="col-md-9 col-sm-12 w-90">
			                    <p class="text-center">
			                      <strong></strong>
			                    </p>

	                    		<div class="chart" style="text-align: left">
	                      			<!-- Sales Chart Canvas -->
	                      			<canvas id="salesChart" style="height: 225px;width: 750px"></canvas>
	                    		</div>
	                    		<!-- /.chart-responsive -->
	                  		</div>
	                  		<!-- /.col -->
	                	</div>
                	<!-- /.row -->
              		</div>
              		<!-- ./card-body -->
              		<div class="card-footer">
                		<div class="row">
                  			<div class="col-sm-3 col-6">
                    			<div class="description-block border-left">
                      				{{-- <span class="description-percentage text-success"><i class="fa fa-caret-up"></i> ۱۷%</span> --}}
                      				<h5 class="description-header">تومان {{ number_format($sumPrice) }}</h5>
                      				<span class="description-text">فروش کل</span>
                    			</div>
                    			<!-- /.description-block -->
                  			</div>
                  			<!-- /.col -->
                  			<div class="col-sm-3 col-6">
                    			<div class="description-block border-left">
                      				{{-- <span class="description-percentage text-warning"><i class="fa fa-caret-left"></i> ۰%</span> --}}
                      				<h5 class="description-header">تومان {{ number_format($sumOff) }}</h5>
                      				<span class="description-text">تخفیف کل</span>
                    			</div>
                    			<!-- /.description-block -->
                  			</div>
                  			<!-- /.col -->
                  			<div class="col-sm-3 col-6">
                    			<div class="description-block border-left">
                      				{{-- <span class="description-percentage text-success"><i class="fa fa-caret-up"></i> ۲۰%</span> --}}
                      				<h5 class="description-header">تومان {{ number_format($sumPrice - $sumOff) }}</h5>
                      				<span class="description-text">پرداختی کل</span>
                    			</div>
                    			<!-- /.description-block -->
                  			</div>
                  			<!-- /.col -->
                  			<div class="col-sm-3 col-6">
                    			<div class="description-block">
                      				{{-- <span class="description-percentage text-danger"><i class="fa fa-caret-down"></i> ۱۸%</span> --}}
                      				<h5 class="description-header">{{ $countOrderitems }}</h5>
                      				<span class="description-text">کالای به فروش رفته</span>
                    			</div>
                    			<!-- /.description-block -->
                  			</div>
                		</div>
               			<!-- /.row -->
              		</div>
              		<!-- /.card-footer -->
            	</div>
            	<!-- /.card -->
          	</div>
          	<!-- /.col -->
        </div>

        <div class="row">
        	
        	<div class="col-md-6 col-sm-12">
        		<!-- USERS LIST -->
                <div class="card">
                  	<div class="card-header" style="padding: .75rem 1.25rem;">
	                    <h3 class="card-title">آخرین اعضا</h3>
	                    <div class="card-tools">
	                      	<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                      	</button>
	                      	<button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
	                      	</button>
	                    </div>
                  	</div>
                  	<!-- /.card-header -->
                  	<div class="card-body p-0">
	                    <ul class="users-list clearfix">
	                    	@foreach($lastUsers as $lastUser)
		                      	<li title="{{ $lastUser->name }} {{ $lastUser->family }}">
		                        	
		                        	<a class="users-list-name " href="{{ route('user.show',[$lastUser]) }}">
		                        		<img src="{{ asset('storetemplate/dist/img/' . $lastUser->image) }}" class="w-50" alt="User Image">
		                        		<div class="mt-2">{{ $lastUser->name }} {{ $lastUser->family }}</div>
		                        	</a>

		                        	<span class="users-list-date">{{ Verta($lastUser->created_at)->format('%d %B %Y') }}</span>
		                      	</li>
	                      	@endforeach
	                    </ul>
	                    <!-- /.users-list -->
                  	</div>
                  	<!-- /.card-body -->
                  	<div class="card-footer text-center">
                    	<a href="{{ route("user.index") }}">مشاهده همه کاربران</a>
                  	</div>
                  	<!-- /.card-footer -->
                </div>
                <!--/.card -->
        	</div>

            <div class="col-md-6 col-sm-12">
            	<!-- TABLE: LATEST ORDERS -->
	            <div class="card">
					<div class="card-header border-transparent" style="padding: .75rem 1.25rem">
						<h3 class="card-title">آخرین سفارش های موفق</h3>
						<div class="card-tools">
						  	<button type="button" class="btn btn-tool" data-widget="collapse">
						    	<i class="fa fa-minus"></i>
						  	</button>
						  	<button type="button" class="btn btn-tool" data-widget="remove">
						    	<i class="fa fa-times"></i>
						  	</button>
						</div>
					</div>
					<!-- /.card-header -->
	              	<div class="card-body p-0">
		                <div class="table-responsive">
							<table class="table m-0">
								<thead>
									<tr class="text-center">
									  	<th>کد فاکتور</th>
									  	<th>تاریخ</th>
									  	<th>نام و نام خانوادگی</th>
									  	<th>پرداختی</th>
									  	<th>وضعیت</th>
									</tr>
								</thead>
								<tbody>
									@foreach($lastOrders as $key=>$lastOrder)
									{{-- {{ dd($lastOrder) }} --}}
										<tr class="text-center">
											<td><a href="{{ route('order.show',[$lastOrder]) }}">{{ $lastOrder->code }}</a></td>
											<td>{{ Verta($lastOrder->created_at)->format('%d %B %Y') }}</td>
											<td>{{ $lastOrder->user->name }} {{ $lastOrder->user->family }}</td>
											<td>
												@php
													$sum = 0;
													foreach($lastOrder->orderitems as $orderitem)
													{
														$sum = $sum + ($orderitem->count * ($orderitem->price - $orderitem->offPrice) );
						      						}
						      						$sum = $lastOrder->postPrice + $sum;
						      						print number_format($sum) . " " . $lastOrder->local;
												@endphp
											</td>
											<td>
												@if($lastOrder->status == 0)
													<span class="badge badge-secondary">بررسی نشده</span>
													 
												@elseif($lastOrder->status == 1 and $lastOrder->post_code == "")
													<span class="badge badge-warning">تائید شد</span>
													
												@elseif($lastOrder->status == 2)
													<span class="badge badge-danger">رد شد</span>

												@elseif($lastOrder->post_code != "")
													<span class="badge badge-success">ارسال شد</span>

												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
		                </div>
		                <!-- /.table-responsive -->
	              	</div>
	              	<!-- /.card-body -->
	              	<div class="card-footer clearfix  text-center">
	                	<a href="{{ route('order.index') }}">مشاهده همه سفارش ها</a>
	              	</div>
	              	<!-- /.card-footer -->
	            </div>
	            <!-- /.card -->
            </div>
        </div><!-- row -->

        <div class="row">

        	<div class="col-md-12 col-sm-12">
                <!-- TABLE: BEST ORDERS -->
	            <div class="card">
					<div class="card-header border-transparent" style="padding: .75rem 1.25rem">
						<h3 class="card-title">پرفروش ترین ها</h3>
						<div class="card-tools">
						  	<button type="button" class="btn btn-tool" data-widget="collapse">
						    	<i class="fa fa-minus"></i>
						  	</button>
						  	<button type="button" class="btn btn-tool" data-widget="remove">
						    	<i class="fa fa-times"></i>
						  	</button>
						</div>
					</div>
					<!-- /.card-header -->
	              	<div class="card-body p-0">
		                <div class="table-responsive">
							<table class="table m-0">
								<thead>
									<tr class="text-center">
									  	<th>کد محصول</th>
									  	<th>عنوان</th>
									  	<th>درخواست</th>
									  	<th>موجودی</th>
									</tr>
								</thead>
								<tbody>
									@foreach($topRequests as $topRequest)
									{{-- {{ dd($topRequest->orderitemable) }} --}}
										<tr class="text-center">
											<td>{{ $topRequest->orderitemable->code }}</td>
											<td class="text-right">
												<a href="{{ route('tablecloth.show',[$topRequest->orderitemable->id]) }}" style="color:black;">
													<img src="{{asset('storage/images/thumbnails/'. $topRequest->orderitemable->images->first()->name)}}" alt="" class="img-circle img-size-50 mr-2">
													{{ $topRequest->orderitemable->category->title }} طرح {{ $topRequest->orderitemable->color_design->design->title }} رنگ {{ $topRequest->orderitemable->color_design->color->color }}
												</a>
											</td>
											<td>{{ $topRequest->sum }}</td>
											<td>{{ $topRequest->orderitemable->quantity }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
		                </div>
		                <!-- /.table-responsive -->
	              	</div>
	              	<!-- /.card-body -->
	              	<div class="card-footer clearfix  text-center">
	                	{{-- <a href="{{ route('order.index') }}">مشاهده همه سفارش ها</a> --}}
	              	</div>
	              	<!-- /.card-footer -->
	            </div>
	            <!-- /.card -->
            </div>

           {{-- <div class="col-md-7 col-sm-12">
	             <div class="card">
	              	<div class="card-header " style="padding: .75rem 1.25rem;">
	                	<div class="d-flex justify-content-between">
		                  	<h3 class="card-title">فروش</h3>
		                  	<a href="javascript:void(0);">مشاهده گزارش</a>
		                </div>
	              	</div>
	              	<div class="card-body">
		                <div class="d-flex">
		                  	<p class="d-flex flex-column">
		                    	<span class="text-bold text-lg">تومان 18,230.00</span>
		                    	<span>فروش در طول زمان</span>
		                  	</p>
		                  	<p class="mr-auto d-flex flex-column text-right">
		                    	<span class="text-success">
		                      	<i class="fa fa-arrow-up"></i> 33.1%
		                    	</span>
		                    	<span class="text-muted">از ماه گذشته</span>
		                  	</p>
		                </div>
		                <!-- /.d-flex -->

		                <div class="position-relative mb-4">
		                  	<canvas id="sales-chart" height="200"></canvas>
		                </div>

		                <div class="d-flex flex-row justify-content-end">
		                  	<span class="ml-2">
		                    	<i class="fa fa-square text-primary"></i> امسال
		                  	</span>

		                  	<span>
		                    	<i class="fa fa-square text-gray"></i> سال گذشته
		                  	</span>
		                </div>
	              	</div>
	            </div> 
	            <!-- /.card -->
          	</div> --}}

        </div><!-- row -->


	</section>
@endsection

@push('js')
	<!-- ChartJS 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/chartjs-old/Chart.min.js')}}"></script>
	{{-- <script src="{{asset('/storetemplate/plugins/chart.js/Chart.min.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/chart.js/Chart.bundle.min.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/chart.js/src/plugins/plugin.filler.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/chart.js/src/plugins/index.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/chart.js/src/plugins/plugin.legend.js')}}"></script>
	<script src="{{asset('/storetemplate/plugins/chart.js/src/plugins/plugin.title.js')}}"></script> --}}
	<script>
		$(function () {

			// var ctx = document.getElementById("salesChart").getContext("2d");

			// new Chart(ctx, {
			//     data: {
			//         datasets: [
			//             {fill: 'origin'},   // 0: fill to 'origin'
			//             {fill: '-1'},       // 1: fill to dataset 0
			//             {fill: 1},          // 2: fill to dataset 1
			//             {fill: false},      // 3: no fill
			//             {fill: '-2'}        // 4: fill to dataset 2
			//         ]
			//     },
			//     options: {
			//         plugins: {
			//             filler: {
			//                 propagate: true
			//             }
			//         }
			//     }
			// })




			'use strict'

			  var salesChartCanvas = $('#salesChart').get(0).getContext('2d')

			  var salesChart       = new Chart(salesChartCanvas)

			  var salesChartData = {
			  	type: 'logarithmic',

			    labels  : ['اسفند', 'بهمن', 'دی', 'آذر', 'آبان', 'مهر', 'شهریور', 'مرداد', 'تیر', 'خرداد', 'اردیبهشت', 'فروردین' ],
			    datasets: [
			      {
			        label               : '',
			        fillColor           : '#dee2e6',
			        strokeColor         : '#ced4da',
			        pointColor          : '#ced4da',
			        pointStrokeColor    : '#c1c7d1',
			        pointHighlightFill  : '#fff',
			        pointHighlightStroke: 'rgb(220,220,220)',
			        data                : @php echo json_encode($currentYearData); @endphp
			      },
			      {
			        label               : '',
			        fillColor           : 'rgba(0, 123, 255, 0.9)',
			        strokeColor         : 'rgba(0, 123, 255, 1)',
			        pointColor          : '#3b8bba',
			        pointStrokeColor    : 'rgba(0, 123, 255, 1)',
			        pointHighlightFill  : '#fff',
			        pointHighlightStroke: 'rgba(0, 123, 255, 1)',
			        data                : @php echo json_encode($oldYearData); @endphp
			      }
			    ]

			  }

			  var salesChartOptions = {
			    //Boolean - If we should show the scale at all
			    showScale               : true,
			    //Boolean - Whether grid lines are shown across the chart
			    scaleShowGridLines      : false,
			    //String - Colour of the grid lines
			    scaleGridLineColor      : 'rgba(0,0,0,.05)',
			    //Number - Width of the grid lines
			    scaleGridLineWidth      : 1,
			    //Boolean - Whether to show horizontal lines (except X axis)
			    scaleShowHorizontalLines: true,
			    //Boolean - Whether to show vertical lines (except Y axis)
			    scaleShowVerticalLines  : true,
			    //Boolean - Whether the line is curved between points
			    bezierCurve             : true,
			    //Number - Tension of the bezier curve between points
			    bezierCurveTension      : 0.3,
			    //Boolean - Whether to show a dot for each point
			    pointDot                : true,
			    //Number - Radius of each point dot in pixels
			    pointDotRadius          : 2,
			    //Number - Pixel width of point dot stroke
			    pointDotStrokeWidth     : 1,
			    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
			    pointHitDetectionRadius : 20,
			    //Boolean - Whether to show a stroke for datasets
			    datasetStroke           : true,
			    //Number - Pixel width of dataset stroke
			    datasetStrokeWidth      : 2,
			    //Boolean - Whether to fill the dataset with a color
			    datasetFill             : true,
			    //String - A legend template
			    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%=datasets[i].label%></li><%}%></ul>',
			    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			    maintainAspectRatio     : false,
			    //Boolean - whether to make the chart responsive to window resizing
			    responsive              : false,
			 //    yAxes: [{
    // 				type: 'logarithmic',
				//     ticks: {
				//          min: 0,
				//          max: 1000000,
				//          callback: function (value, index, values) {
				//          	console.log("xfsfs");
				//              if (value === 1000000) return "1M";
				//              if (value === 100000) return "100K";
				//              if (value === 10000) return "10K";
				//              if (value === 1000) return "1K";
				//              if (value === 100) return "100";
				//              if (value === 10) return "10";
				//              if (value === 0) return "0";
				//              return null;
				//          }
				//     }
				// }]
			}


			  //Create the line chart
			  salesChart.Line(salesChartData, salesChartOptions)


		})//END
	</script>

@endpush