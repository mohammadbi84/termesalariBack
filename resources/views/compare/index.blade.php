@extends('store-layout')

@section('title',"لیست مقایسه")

@push('link')
	{{-- Rating --}}
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/css-stars.css')}}">
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
	<link rel="stylesheet" href="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css')}}">

	<style type="text/css">
		main#main{
			width: 100% !important;
		    padding-right: 0px !important;
		    padding-left: 0px !important;
			overflow-x: auto;
		}

		main>.container-fluid{
			padding-right: 0px !important;
			padding-left: 0px !important;
			margin-right: 0px !important;
			margin-left: 0px !important;
		}

		#main ul>li{
			width: 270px;
		}

		.card-body{
			/*overflow-x: auto;*/
		}

		.fixed-header {
		    position: fixed;
		    top: 52px;
		    left: 0;
		    z-index: 999;
		    /*width: 100%; */
		}


		ul#header-compare{
			/*position: -webkit-sticky;
	    	position: sticky;
	    	top: 92px;*/
	    	/*overflow-x: auto; */
	    	/*overflow-y: visible;*/
	    	background-color: white;
	    	height: 290px;
	    	border: 1px solid lightgrey;
		}

		/*ul#data-compare{
			display: flex;
			list-style: none;
			flex-wrap: nowrap;
		}*/

		ul#header-compare,
		ul#data-compare{
	    	width: 100%;
	    	flex-wrap: nowrap;
		}

		ul#header-compare>li,
		ul#data-compare>li{
			box-sizing: border-box;
			text-align: center;
			font-size: 0.9rem;
			border-right: 1px solid lightgray;
		}

		ul#header-compare>li{
			/*height: 100%;*/
			/*box-sizing: border-box;
			text-align: center;
			font-size: 0.9rem;*/
			/*margin: 0 auto;*/
			padding-top: 35px;
			padding: 35px 5px 5px 5px;
			position: relative;
			/*border-right: 1px solid lightgray;*/
		}

		ul#header-compare>li:first-child{
			border-right: 0px;
		}

		ul#data-compare>li{
			width: 100%;
		}

		.owl-theme .owl-nav [class*=owl-] {
			background: transparent !important;
			color: lightgray !important;
			top: 50%;
			transform: translateY(-50%);
		}
		.owl-prev {
		    right: -35px !important;
		}

		#header-compare .close{
			font-size: 0.8rem;
			font-weight: normal;
			color: #797676;
			background-color: #eeeeee;
			border-radius: 50%;
			-webkit-border-radius: 50%;
			padding: 10px;
			position: absolute;
			top: 2px;
			right: 2px;
		}

		.info>p{
			/*height: 40px;*/
			overflow: hidden;
		}

		h5{
			color: #4d4d4d;
		    font-size: 19px;
		    font-size: 1.357rem;
		    line-height: 1.158;
		    margin-bottom: 25px;
		    margin-top: 25px;
		    position: relative;
		    padding-right: 19px;
		}

		h5:before {
		    content: "";
		    position: absolute;
		    right: 0;
		    bottom: 3px;
		    width: 0;
		    height: 0;
		    border-color: transparent #00bfd6 transparent transparent;
		    border-style: solid;
		    border-width: 7px 7px 7px 0;
		}

		.compare-list-title{
			/*-webkit-box-flex: 0;*/
		    /*flex: 0 0 100%;*/
		    max-width: 100%;
		    font-size: 13px;
		    font-size: .929rem;
		    line-height: 1.692;
		    padding: 9px 26px;
		    background-color: #eaeaea;
		    font-weight: 700;
		}

		.compare_list_value:first-child {
		    border-right: none;
		}

		.compare_list_title{
			-ms-flex: 0 0 100%;
		    -webkit-box-flex: 0;
		    flex: 0 0 100%;
		    max-width: 100%;
		    font-size: 13px;
		    font-size: .929rem;
		    line-height: 1.692;
		    padding: 9px 26px;
		    background-color: #eaeaea;
		    font-weight: 700;
		    text-align: right !important;
		}

		.compare_list_value{
			/*-webkit-box-flex: 0;*/
		    /*flex: 0 0 25%;*/
		    /*max-width: 25%;*/
		    border-right: 1px solid #e4e4e4;
		    display: flex;
		    flex-wrap: nowrap;
		    width: 100%;
		}

		li.compare_list_value>div{
			box-sizing: border-box;
			/*text-align: justify !important;*/
			font-size: 0.9rem;
			border-right: 1px solid lightgray;
			margin: 10px 0;
			padding: 5px 5px 5px 5px;
			width: 270px;
		}

		li.compare_list_value>div:first-child{
			border-right: 0px;
		}

	</style>
@endpush

@section('main-content')
	{{-- <div class="row"> --}}
	    {{-- <div class="col-md-12"> --}}
	        {{-- <div class="card"> --}}
	          	<div class="card-header">
	            	<h3 class="card-title"><span id="title">مقایسه کالا</span></h3>
	          	</div>
	          	{{-- <div class="card-body" > --}}
	          		@if (session()->has("compares") and count(session("compares")["product"]) > 0 )
		          		<ul id="header-compare" class="nav compare-nav mb-4 mt-4">
		          			@foreach(session("compares")["product"] as $compare)
		          				<li>
		          					<div class="img-compare">
		          						<div class="images owl-carousel owl-theme m-auto" style="width: 100px; height: 100px;" id="slideshow{{ $compare->id }}">
		          							@foreach($compare->images as $key=>$image)
												<div>
					 							 	<img class="w-100" style="" src="{{asset('storage/images/'.$image['name'])}}" alt="{{$image['name']}}">
												</div>
											@endforeach
		          						</div>
		          						<div class="info">
		          							<p title="{{ $compare->category->title }} طرح {{ $compare->color_design->design->title }} رنگ {{ $compare->color_design->color->color }}">
		          								{{ Str::limit($compare->category->title ." طرح ".  $compare->color_design->design->title ." رنگ "  .$compare->color_design->color->color,30) }}
		          							</p>

		          							<div>
			          							<small class="text-muted float-right">{{ count($compare->grades) }} نفر</small>
							                    <div class="br-wrapper br-theme-fontawesome-stars float-left">
							                    	{{-- @dump($key) --}}
							                        <select class="showGrade{{$compare->id}}">
							                            <option value="1">1</option>
							                            <option value="2">2</option>
							                            <option value="3">3</option>
							                            <option value="4">4</option>
							                            <option value="5">5</option>
							                        </select>
							                    </div>
						                    </div>

		          							<div class="text-danger text-center" style="clear: both;">
		          								@php
		          									$prices = $compare->prices->where('local','تومان')->first();
								              		$price = 0;
								                	$off = 0;
								              		if($prices->offPrice > 0)
								              		{
							                			if($prices->offType == 'مبلغ')
							                			{
						                					$price = $prices->price - $prices->offPrice;
						                					$off =$prices->offPrice;
						                				}
						                				elseif($prices->offType == 'درصد')
						                				{
						                					$off = $prices->price * ($prices->offPrice/100);
						                					$price = $prices->price - $off;
						                				}
						                			}
						                			else
						                				$price = $prices->price;
						                		@endphp
						                		{{ number_format($price) }} تومان
		          							</div>
		          						</div>
		          					</div>
		          					<a href="{{ route('compare.remove') }}" class="close" data-id="{{ $compare->id }}"><i class="fa fa-close"></i></a>
		          						{{-- {{ dd($compare->category->model) }} --}}
		          					<a href="
		          						@switch($compare->category->model)
			                              	@case('App\Tablecloth')
				                                {{ route('tablecloth.show',[$compare]) }}
				                            	@break
				                            @case('App\Bedcover')
			                                	{{ route('bedcover.show',[$compare]) }}
			                                @break
			                              	@case('App\Shoe')
			                                	{{ route('shoe.show',[$compare]) }}
			                                @break
			                          	@endswitch
		          						" class="btn btn-flat btn-primary btn-sm mt-2">مشاهده و خرید </a>
		          				</li>
		          			@endforeach
		          		</ul>

		          		<h5 class="mt-2 mb-4"><div class="mr-4">اطلاعات کلی</div></h5>

		          		<ul id="data-compare" class="compare-nav">
		          			<li class="compare_list_title">
		          				<div>طرح</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->color_design->design->title }}</div>

		          				@endforeach
		          			</li>

		          			<li class="compare_list_title">
		          				<div>رنگ</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->color_design->color->color }}</div>

		          				@endforeach
		          			</li>

		          			<li class="compare_list_title">
		          				<div>تعداد رنگ بافت ترمه</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->color_design->design->countOfColor }} رنگ</div>

		          				@endforeach
		          			</li>

		          			<li class="compare_list_title">
		          				<div>ابعاد</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->dimensions }}</div>

		          				@endforeach
		          			</li>

		          			<li class="compare_list_title">
		          				<div></div>
		          			</li>
		          			<li class="compare_list_value">
		          				<div class=""></div>
		          			</li>

		          			<li class="compare_list_title">
		          				<div>وزن</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->weight }}</div>

		          				@endforeach
		          			</li>

		          			<li class="compare_list_title">
		          				<div>مشتمل بر</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->contains ?? " - " }}</div>

		          				@endforeach
		          			</li>

		          			<li class="compare_list_title">
		          				<div>موارد استفاده</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->uses ?? " - " }}</div>

		          				@endforeach
		          			</li>

		          			<li class="compare_list_title">
		          				<div>سایر توضیحات</div>
		          			</li>
		          			<li class="compare_list_value">
		          				@foreach(session("compares")["product"] as $compare)
		          					<div class="compareValue{{ $compare->id }}">{{ $compare->description ?? " - " }}</div>

		          				@endforeach
		          			</li>

		          		</ul>


	          		@endif




	          	{{-- </div> --}}
	        {{-- </div> --}}
	    {{-- </div> --}}
	{{-- </div> --}}
@endsection

@push('js')
	{{-- jqueryBarRating --}}
	<script src="{{asset('/storetemplate/plugins/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>

	<script>
		$(function(){

			//---Show Grade---------------------------------
			@if (session()->has("compares") and count(session("compares")) > 0 )
				@foreach(session("compares")["product"] as $compare)
					{{-- @dump($key) --}}
					$('.showGrade{{ $compare->id }}').barrating({
						theme:'fontawesome-stars-o',
						initialRating: "{{$compare->grades->avg('grade') ?? '0'}}",
						readonly:true,
					});
				@endforeach
			@endif

			$(window).scroll(function(){
			    if ($(window).scrollTop() >= 250) {
			        $('#header-compare').addClass('fixed-header');
			    }
			    else {
			        $('#header-compare').removeClass('fixed-header');
			    }
			});

			@if (session()->has("compares") and count(session("compares")) > 0 )
				@foreach(session("compares")["product"] as $compare)
					$("#slideshow{{ $compare->id }}").owlCarousel({
				        rtl: true,
				        nav:true,
				        dots: false,
				        items: 1,
				        navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],

				    });
			    @endforeach
			@endif

			$(".close").click(function(event){
				event.preventDefault();
				var id = $(this).data("id");
				var thiz = $(this);
				$.ajax({
					type:'get',
					url: "{{ route('compare.remove') }}",
					data: {
						_token: '<?php echo csrf_token() ?>',
					  	id: id,
					  	model: "Tablecloth",
					},
					success:function(data){
						// console.log(data);
						thiz.parents('li').fadeOut("fast");
						$(".compareValue" + id).fadeOut("fast");

					}
				});
			})

		})//End
	</script>
@endpush
