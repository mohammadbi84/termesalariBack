@extends('store-layout')

@push('link')
<link href="{{asset('/storetemplate/dist/css/cart.css')}}" rel="stylesheet">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('../storetemplate/plugins/select2/select2.min.css')}}">
<style type="text/css">
	#TopMenuCartIcone{
		display: none;
	}
</style>
@endpush

@section('title','ادامه فرایند خرید - مرحله دوم')

@section('main-content')
	@php
		$discountCardPrice = 0;
		if(session()->has("discountCardPrice"))
			$discountCardPrice = session("discountCardPrice");
	@endphp
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">
				<span>فرایند خرید – مرحله دوم</span>
			</h4>
		</div>
		<!-- /.card-header -->
		<div class="card-body product-header-info cart-container row">
			@if(isset($list) and count($list)>0)
				@php
					$price = 0;
					$off = 0;
					foreach($list['products'] as $key=>$product)
					{
                        $cartItemPrice = 0;
                        $cartItemOff = 0;

                        $p = $product->prices->where('local','تومان')->first();
                        if($p->offPrice > 0)
                        {
                          if($p->offType == 'مبلغ')
                          {
                            $cartItemPrice = $p->price - $p->offPrice;
                            $cartItemOff = $p->offPrice;
                            $price = $price + ( ($p->price - $p->offPrice) * $list['quantities'][$key]);
                            $off = $off + ($cartItemOff * $list['quantities'][$key]);
                          }
                          elseif($p->offType == 'درصد')
                          {
                            $cartItemPrice = $p->price - ($p->price * ($p->offPrice/100));
                            $cartItemOff = $p->price * ($p->offPrice/100);
                            $price = $price + (($p->price - $cartItemOff) * $list['quantities'][$key]);
                            $off = $off + ($cartItemOff * $list['quantities'][$key]);
                            
                          }
                        }
                        else
                        {
                          $cartItemPrice = $p->price;
                          $price = $price + ($p->price * $list['quantities'][$key]);
                        }
                    }   
                @endphp
				<div class="col-md-8">
					<div class="row">
						<div class="cart-products card-recipients col-md-12" style="border-bottom: 1px solid rgba(0,0,0,.125);">
							<div>
								<p class="text-bold float-right">آدرس تحویل سفارش را انتخاب کنید: </p>
								<a href="#" id="closeRecipients"><i class="fa fa-close float-left"></i></a>
							</div>
							
							<div class="row" style="clear: both;">
								@foreach($recipients as $recipient)

								{{-- col-md-4 col-lg-4 col-sm-4 --}}
									<div class="col-md-5 recipientBox">
								        <label>
								          <input type="radio" name="recipient" class="card-input-element" @if($recipient->created_at == $date) checked="checked" @endif value="{{ $recipient->id }}" />
								            <div class="card">
								                <div class="card-header">
								                	{{-- <input type="radio" name="product" class="card-input-element" /> &nbsp --}}
								                	<p class="card-title" style="display: inline;"> ارسال به این آدرس</</p>
								                </div>
								                <div class="card-body">
								                	<div class="recipient_id" style="display: none;">
								                		{{ $recipient->id }}
								                	</div>
									                <div class="recipient_address">
									                	{{ $recipient->subcity->city->name }}، {{ $recipient->subcity->name }}، {{ $recipient->address }}، پلاک {{ $recipient->houseId }}
									                </div>
									                <div class="text-muted">
									                	<i class="fa fa-envelope" title="کد پستی"></i> {{ $recipient->zipcode }} <br>
									                	<i class="fa fa-phone" aria-hidden="true" title="موبایل"></i> {{ $recipient->mobile }}
									                	<br>
									                	<i class="fa fa-user" title="نام و نام خانوادگی گیرنده"></i> 
									                	<span class="recipient_name">
									                		{{ $recipient->name }} {{ $recipient->family }}
									                	</span>
									                </div>

								                </div>
								                <div class="card-footer">
								                	<a href="{{ route('recipient.edit',[$recipient]) }}" class="btn btn-outline-primary btn-flat">ویرایش</a>
								                	<form class="del-form" action="{{route('recipient.destroy', [$recipient])}}" method="post" style="display: inline;">
														@csrf
														@method('delete')
														<a href="" class="btn btn-outline-danger btn-flat deleteRecipient">حدف</a>
													</form>
								                </div>
								            </div>
								        </label>
							     	</div>
								@endforeach
								<div class="col-md-5">
						            <div class="card add-recipient" style="text-align: center;">
						                <div class="card-body" style="padding: 5.1rem;overflow: hidden;">
						                	<a href="#" data-toggle="modal" data-target="#formAddRecipient">
						                		<span style="font-size: 2rem">+</span>		
		                						<div>افزودن آدرس جدید</div> 
											</a>

						                </div>
						            </div>
						     	</div>
							</div>
						</div>
						<form method="post" action="{{ route('cart.cartfinal') }}" class="col-md-12">
							@csrf
							@foreach($recipients as $recipient)
								@if($recipient->created_at == $date) 
								<div class="col-md-12 recipientAddress" style="line-height: 30px;border-bottom: 1px solid rgba(0,0,0,.125);">
									<p class="text-bold">آدرس تحویل سفارش</p>
									<input type="hidden" name="selectedRecipientId" id="selectedRecipientId" value="{{ $recipient->id }}">
									<div id="selectedRecipientAddress">
										{{ $recipient->subcity->city->name }}، {{ $recipient->subcity->name }}، {{ $recipient->address }}، پلاک {{ $recipient->houseId }}
									</div>
									<div class="text-muted small">
										<i class="fa fa-user"></i> <span id="selectedRecipientName">{{ $recipient->name }} {{ $recipient->family }}</span>
									</div>
									<a href="#" id="showRecipients" class="small mb-3 d-inline-block">تعییر یا ویرایش آدرس  <i class="fa fa-chevron-left" style="font-size:0.6rem"></i></a>
								</div>
								@endif
							@endforeach
							<div class="col-md-12 post" style="border-bottom: 1px solid rgba(0,0,0,.125);">
								<p class="text-bold mt-3">انتخاب روش ارسال محصول</p>
								@foreach($posts as $post)
									<div class="">
										<label>
											<input type="radio" value="{{ $post->id }}" class="radio" name="postType" data-price="{{ $post->price }}" data-widget="collapse" data-toggle="tooltip" @if($posts->count() == 1) checked="checked" @endif>
											{{ $post->title }}
										</label>
										<p class="mb-4">هزینه ارسال: @if($post->price == 0) <span class="text-danger">رایگان</span> @else {{ $post->price }} تومان @endif -  زمان ارسال حداکثر : {{ $post->delivery_time }}</p>
									</div>
								@endforeach
							</div>

							 <div class="col-md-12 pay">
								<p class="text-bold mt-3">انتخاب روش  پرداخت</p>
								@foreach($payment_methods as $pay)
									<div class="">
										<label>
											<input type="radio" value="{{ $pay->method }}" class="radio" name="payType" @if($pay->selection == 1) checked="checked" @endif >
											{{ $pay->title }}
											
										</label>
										<p class="" style="text-indent: 40px">
											{!! html_entity_decode($pay->description) !!}
											
											<!-- <span>مبلغ را به شماره کارت</span>
											<span class="text-danger text-bold"> 4890-4366-3373-6104 </span>
											<span>به نام آقای  </span><span class="text-danger text-bold">سید علی سالاری  </span>
											<span> واریز و اطلاعات را در مرحله بعد اعلام نمایید.</span> -->
										</p>
									</div>
								@endforeach
								{{-- <label>
									<input type="radio" class="radio" name="payType" value="پرداخت اینترنتی">
									پرداخت اینترنتی
								</label>
								<br>
								<label>
									<input type="radio" class="radio" name="payType" value="پرداخت  هنگام تحویل">
									پرداخت  هنگام تحویل
								</label> --}}
							</div>

							<div class="col-md-12 mt-5" >
								<a href="{{ route('cart.index') }}" class="btn btn-sm btn-flat btn-secondary">بازگشت به سبد خرید</a>
								<input type="submit" id="finalbtn" class="btn btn-sm btn-flat btn-primary" value="ادامه فرایند خرید - تایید اطلاعات">

							</div>
						</form>

					</div>{{-- div.row --}}
					

				</div>{{-- col-md-8 --}}
				<div class="cart-info col-md-4 table-responsive p-0">	
					<table class="table">
						<tr>
							<td>قیمت کالا@if(isset($sum) and $sum>1)ها  (<span id="cart_info-quantity">{{ $sum }}</span>) @endif</td>
							<td><span id="cart-info-price">{{ number_format($price + $off) }}</span> <small>تومان </small></td>
						</tr>
						<tr>
							<td>تخفیف کالا@if(isset($sum) and $sum>1)ها  @endif</td>
							<td style="color: #ef3a4e;"><span id="cart-info-off">{{ number_format($off) ?? '' }}</span> <small>تومان </small></td>
						</tr>
						<tr style="border-top: 1px solid #ef3a4e">
							<td>جمع </td>
							<td><span id="cart-info-sum">{{number_format( $price ) ?? ''}}</span> <small>تومان </small></td>
						</tr>
						@if(session()->has("discountCardPrice"))
							<tr>
								<td>تخفیف ویژه</td>
								<td>{{ number_format(session("discountCardPrice")) }} <small>تومان </small></td>
							</tr>
						@endif
						<tr>
							<td>هزینه ارسال</td>
							<td style="color: #ef3a4e;" id="cart-info-postPrice"> - </td>
						</tr>
						<tr>
							<td>مبلغ قابل پرداخت</td>
							<td><span id="cart-info-total" data-price="{{ $price - $discountCardPrice }}">{{number_format($price - $discountCardPrice) ?? ''}}</span> <small>تومان </small></td>
						</tr>
					</table>
				</div>
			@else
				<div style="margin: 0 auto; text-align: center;">
					<img src="{{asset('/storetemplate/dist/img/empty-cart-icon.png')}}">
					<p>سبد خرید شما خالی است!</p>
					<a href="#" class="btn btn-success" >نمایش محصولات <img src="{{asset('/storetemplate/dist/img/online-supermarket-cart.png')}}"></a>
				</div>
				
			@endif
		</div>
	</div>
{{-- ///////////////////////////////////////// --}}

	<div class="modal fade" id="formAddRecipient" tabindex="-1" role="dialog" aria-labelledby="formAddRecipientLabel" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	    	<form class="" role="form" action="{{route('recipient.store')}}" method="POST">
				@csrf
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title" id="formAddRecipientLabel">
		                	جزئیات  آدرس
		                </h5>
		            </div>
		            <div class="modal-body" {{-- style="height: 800px" --}}>
		      				<div class="row">
		      					<div class="col-6">
		      						<div class="form-group @error('city_id') is-invalid @enderror">
										<label for="city_id">استان* </label>
					                  	<select tabindex="1" name="city_id" id="city_id" class="form-control select2 select2-single select2-hidden-accessible " style="width: 100%;" >

						                    <option value="" selected="selected" style="">. نام استان را انتخاب کنید  </option>
						                    @foreach($cities as $city)
						                    	<option  @if ($city->id == old('city')) selected @endif value="{{$city->id}}">{{$city->name}}</option>
						                    @endforeach

					                  	</select>

					                  	@error('city_id')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror	
					                </div>
		      					</div>

		      					<div class="col-6">
		      						<div class="form-group @error('subcity_id') is-invalid @enderror">
										<label for="subcity_id">شهر*</label>
					                  	<select tabindex="2" name="subcity_id" id="subcity_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;" >

						                    <option value="" selected="selected" style=""> . نام شهر را انتخاب کنید </option>

					                  	</select>

					                  	@error('subcity_id')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror	
					                </div>
		      					</div>
		      				</div>

		      				<div class="form-group">
			                	<label for="address">نشانی پستی* <span class="text-muted small" style="font-size: 96%"> (در صورت سکونت در مجتمع آپارتمانی لطفا نام بلوک و شماره واحد را ذکر بفرمایید.)</span></label>
								<input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="لطفاً نشانی پستی را وارد کنید." value="{{old('address')}}">
								@error('address')
								    <div class="invalid-feedback">{{$message}}</div>
								@enderror
							</div>

							<div class="row">

								<div class="col-5">
									<div class="form-group">
										<label for="houseId">پلاک*</label>
										<input type="text" name="houseId" id="houseId" class="form-control @error('houseId') is-invalid @enderror" placeholder="لطفاً پلاک را وارد کنید ." value="{{old('houseId')}}" >
										@error('houseId')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror
									</div>
								</div>

								<div class="col-7">
									<div class="form-group">
										<label for="zipcode">کد پستی* <span class="text-muted">(به صورت ده رقمی و بدون خط تیره)</span></label>
										<input type="text" name="zipcode" id="zipcode" class="form-control @error('zipcode') is-invalid @enderror" placeholder="لطفاً  کد پستی را وارد کنید ." value="{{old('zipcode')}}" maxlength="10">
										@error('zipcode')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror
									</div>
								</div>

								<div class="form-group">
									<input type="checkbox" id="recipientIsSelf" name="recipientIsSelf" class="" data-value = ""> 
									<label for="recipientIsSelf"> گیرنده سفارش خودم هستم.</label>
									@error('code')
									    <div class="invalid-feedback">{{$message}}</div>
									@enderror
								</div>

							</div>

							<div class="row">

								<div class="col-6">
									<div class="form-group">
					                	<label for="name">نام گیرنده*</label>
										<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="لطفاً نام گیرنده را وارد کنید ." value="{{old('name')}}">
										@error('name')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
					                	<label for="family">نام خانوادگی گیرنده*</label>
										<input type="text" name="family" id="recipientfamily" class="form-control @error('family') is-invalid @enderror" placeholder="لطفاً نام خانوادگی گیرنده را وارد کنید ." value="{{old('family')}}">
										@error('family')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror
									</div>
								</div>
								
							</div>

							<div class="row">

								<div class="col-6">
									<div class="form-group">
					                	<label for="nationalCode">کد ملی گیرنده* <span class="text-muted">(بدون خط تیره)</span></label>
										<input type="text" name="nationalCode" id="nationalCode" class="form-control @error('nationalCode') is-invalid @enderror" placeholder="لطفاً کدملی را وارد کنید ." value="{{old('nationalCode')}}" maxlength="10">
										@error('nationalCode')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror
									</div>
								</div>
								
								<div class="col-6">
									<div class="form-group">
					                	<label for="mobile">شماره موبایل* <span class="text-muted">(مثلا 09131568758)</span></label>
										<input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="لطفاً شماره مویابل را وارد کنید ." value="{{old('mobile')}}" maxlength="11">
										@error('mobile')
										    <div class="invalid-feedback">{{$message}}</div>
										@enderror
									</div>
								</div>

							</div>	
		            </div>
		            <div class="modal-footer">
		                <input type="submit" id="saveRecipient" style="font-size: 0.8rem" class="btn btn-primary" value="ثبت"> &nbsp
		                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
		                
		            </div>
		        </div>
	      	</form>
	    </div>
	</div>


 <!-- LOADING... -->
{{--<div class="loader">
  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="24px" height="24px" viewBox="0 0 24 24" style="enable-background:new 0 0 50 50;" xml:space="preserve">
    <rect x="0" y="0" width="4" height="7" fill="#333">
      <animateTransform  attributeType="xml"
        attributeName="transform" type="scale"
        values="1,1; 1,3; 1,1"
        begin="0s" dur="0.6s" repeatCount="indefinite" />       
    </rect>

    <rect x="10" y="0" width="4" height="7" fill="#333">
      <animateTransform  attributeType="xml"
        attributeName="transform" type="scale"
        values="1,1; 1,3; 1,1"
        begin="0.2s" dur="0.6s" repeatCount="indefinite" />       
    </rect>
    <rect x="20" y="0" width="4" height="7" fill="#333">
      <animateTransform  attributeType="xml"
        attributeName="transform" type="scale"
        values="1,1; 1,3; 1,1"
        begin="0.4s" dur="0.6s" repeatCount="indefinite" />       
    </rect>
  </svg>
</div> --}}

@endsection

@push('js')
	<!-- Select2 -->
	<script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
	
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script type="text/javascript">
	$(function () {

		// $('.loader').hide();
		
		$('#showRecipients').click(function(){
			event.preventDefault();
			$('.card-recipients').fadeIn('fast');
			$('.recipientAddress').hide();
		});

		$('#closeRecipients').click(function(){
			event.preventDefault();
			var recipientId = $("#selectedRecipientId").val();
			if(recipientId == '')
			{
				swal("خطا  در اجرای عملیات", "لطفاً آدرس تحویل سفارش  را انتخاب کنید." ,"error");
				return false;
			}
			$('.card-recipients').hide();
			$('.recipientAddress').fadeIn('fast');
		});

		$('.card-input-element').click(function(){
			var address = $.trim($(this).parent().parent().find(".recipient_address").text());
			var name = $.trim($(this).parent().parent().find(".recipient_name").text());
			var id = $.trim($(this).parent().parent().find(".recipient_id").text());
			$('#selectedRecipientAddress').text(address);
			$('#selectedRecipientName').text(name);
			$('#selectedRecipientId').val(id);
			
		});

		$("#finalbtn").click(function(event){
			var postType = $(":checked[name=postType]").val();
			var payType = $(":checked[name=payType]").val();
			var recipientId = $("#selectedRecipientId").val();

			if(recipientId == '')
			{
				swal("خطا  در اجرای عملیات", "لطفاً آدرس تحویل سفارش  را انتخاب کنید." ,"error");
				return false;
				event.preventDefault();
			}

			if(! postType)
			{
				swal("خطا  در اجرای عملیات", "لطفاً  روش ارسال محصول را انتخاب کنید." ,"error");
				return false;
				event.preventDefault();
			}

			if(! payType)
			{
				swal("خطا  در اجرای عملیات", "لطفاً  روش پرداخت را انتخاب کنید." ,"error");
				return false;
				event.preventDefault();
			}

			return true;
		});

		$("#saveRecipient").click(function(event){

			var city = $("#city_id").val();
			var subcity = $("#subcity_id").val();
			var address = $("#address").val();
			var houseId = $("#houseId").val();
			var zipcode = $("#zipcode").val();
			var name = $("#name").val();
			var family = $("#recipientfamily").val();
			var nationalCode = $("#nationalCode").val();
			var mobile = $("#mobile").val();

			$("input,div,span").removeClass('is-invalid');
			$(".invalid-feedback").text("");

			if(city == "")
			{
				$("#city_id + span").addClass("is-invalid").focus();
				$("#city_id").parents(".form-group").append('<div class="invalid-feedback" style="display:block;">لطفا نام استان را انتخاب کنید.</div>');
				return false;
				event.preventDefault();
			}

			if(subcity == "")
			{
				$("#subcity_id + span").addClass("is-invalid").focus();
				$("#subcity_id").parents(".form-group").append('<div class="invalid-feedback" style="display:block;">لطفا نام شهر را انتخاب کنید.</div>');
				return false;
				event.preventDefault();
			}

			if(address == "")
			{
				$("#address").addClass("is-invalid").focus();
				$("#address").after('<div class="invalid-feedback">پر کردن فیلد آدرس الزامی می باشد.</div>');
				return false;
				event.preventDefault();
			}

			if(houseId == "" || isNaN(houseId) == true)
			{
				$("#houseId").addClass("is-invalid").focus();
				$("#houseId").after('<div class="invalid-feedback">پر کردن فیلد پلاک به صورت عددی الزامی می باشد.</div>');
				return false;
				event.preventDefault();
			}

			if(zipcode == "" || isNaN(zipcode) == true || zipcode.length < 10)
			{
				$("#zipcode").addClass("is-invalid").focus();
				$("#zipcode").after('<div class="invalid-feedback">پر کردن فیلد کدپستی به صورت عددی الزامی می باشد.</div>');
				return false;
				event.preventDefault();
			}

			if(name == "")
			{
				$("#name").addClass("is-invalid").focus();
				$("#name").after('<div class="invalid-feedback">پر کردن فیلد نام گیرنده الزامی می باشد.</div>');
				return false;
				event.preventDefault();
			}

			if(family == "")
			{
				$("#recipientfamily").addClass("is-invalid").focus();
				$("#recipientfamily").after('<div class="invalid-feedback">پر کردن فیلد نام خانوادگی گیرنده الزامی می باشد.</div>');
				return false;
				event.preventDefault();
			}

			if(nationalCode == "" || isNaN(nationalCode) == true || nationalCode.length < 10)
			{
				$("#nationalCode").addClass("is-invalid").focus();
				$("#nationalCode").after('<div class="invalid-feedback">پر کردن فیلد کدملی به صورت عددی الزامی می باشد.</div>');
				return false;
				event.preventDefault();
			}

			if(mobile == "" || mobile.length < 11)
			{
				$("#mobile").addClass("is-invalid").focus();
				$("#mobile").after('<div class="invalid-feedback">پر کردن فیلد موبایل به صورت عددی الزامی می باشد.</div>');
				return false;
				event.preventDefault();
			}

			return true;

		});

		$('.select2').select2({
			theme: 'bootstrap',
		});

			// console.log( $("#city_id,#subcity_id").parent(".form-group"));
		$("#city_id,#subcity_id").select2({
			dropdownParent : $("#formAddRecipient"),
			// dropdownParent : $(this).parent(".form-group"),
		});
		// $("#city_id,#subcity_id").element.nativeElement.parent().find(".select2-container").css('top', '100');

		$('input[type="checkbox"]').iCheck({
	      checkboxClass: 'icheckbox_flat-blue',
	      radioClass   : 'iradio_flat-blue'
	    });

	    $('input.radio').iCheck({
	      checkboxClass: 'icheckbox_flat-blue',
	      radioClass   : 'iradio_flat-blue'
	    });

	    $("input[name=postType]").on('ifChecked',function(){
	    	var postPrice = $(this).data('price');
	    	$("#cart-info-postPrice").text($.number(postPrice)+" " + "تومان");
	    	var totalPrice = $("#cart-info-total").data("price");
	    	totalPrice = parseInt(totalPrice) + parseInt(postPrice);
	    	$("#cart-info-total").text($.number(totalPrice));
	    })

	    $("#recipientIsSelf").on('ifChecked',function(){
			$("#name").val("{{ Auth::user()->name }}");
			$("#recipientfamily").val("{{ Auth::user()->family }}");
			$("#nationalCode").val("{{ Auth::user()->nationalCode }}");
			$("#mobile").val("{{ Auth::user()->mobile }}");
		});

		$("#recipientIsSelf").on('ifUnchecked',function(){
			$("#name").val("");
			$("#recipientfamily").val("");
			$("#nationalCode").val("");
			$("#mobile").val("");
		});

		$('#city_id').on('select2:select', function (e) {
			$(".loader").show();
		  	var data = e.params.data;
		  	$('#subcity_id').html('<option value="" selected="selected" style=""> . نام شهر را انتخاب کنید </option>').trigger("change");
    		$.ajax({
	            type:'POST',
	            url: '{{route("recipient.selectSubcity")}}',
	            data: {
	              _token: '<?php echo csrf_token() ?>',
	              id : data.id
	            },
	            success:function(data){
			        for (var i = data.results.length - 1; i >= 0; i--) {
			        	var newOption = new Option(data.results[i].text, data.results[i].id, false, false);
						$('#subcity_id').append(newOption).trigger('change');
			        }
	            },
			    complete: function(){
			        $('.loader').hide();
			    }
	        });
	    });


		$(".deleteRecipient").click(function(event){
			event.preventDefault();
			event.stopPropagation();
			var $thiz = $(this);
			var addr = $thiz.parents('.del-form').attr('action');
			swal({
			  title: "آیا از حذف این آدرس  تحویل مطمئن هستید؟",
			  // text: "این عملیات منجر به حذف محصول از سبد خرید شما خواهد شد.",
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
			              _token: '<?php echo csrf_token() ?>',
			              _method : 'DELETE'
			            },
			            success:function(data){
			            	if(data.res == "success"){
			            		swal("عملیات با موفقیت انجام شد." , data.message,data.res);
				                $thiz.parents('.recipientBox').fadeOut("slow");
				                var selected = $thiz.parents('.recipientBox').find('input[name=recipient]').attr('checked');
				                if(selected)
				                	$("#selectedRecipientId").val("");
			            	}
			            	
			            }
			        });
				}
			});
			
		});
});//end
	</script>
@endpush