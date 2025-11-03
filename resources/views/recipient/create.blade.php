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

@section('title','ادامه فرایند خرید - ثبت اطلاعات گیرنده')

@section('main-content')
<div class="card col-md-6 m-auto">
	<div class="card-header">
    	<h3 class="card-title"><span id="title">ثبت اطلاعات گیرنده</span></h3>
  	</div>
	<div class="card-body">
		<form class="" id="formAddRecipient" role="form" action="{{route('recipient.store')}}" method="POST">
			@csrf
			<div class="row">
				<div class="col-6">
					<div class="form-group @error('city_id') is-invalid @enderror">
						<label for="city_id">استان* </label>
			          	<select tabindex="1" name="city_id" id="city_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;" >
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
					<input type="checkbox" id="recipientIsSelf" name="recipientIsSelf" class=" checkbox" data-value = ""> 
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
			<div class="card-footer">
			    <input type="submit" id="saveRecipient" style="" class="btn btn-primary" value="ثبت اطلاعات گیرنده"> &nbsp			    
			</div>
		</form>
	</div>
</div>





<!-- LOADING... -->
<div class="loader">
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
</div>

@endsection

@push('js')
	<!-- Select2 -->
	<script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
	<script src="{{asset('/storetemplate/dist/js/jquery.number.min.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
	<script type="text/javascript">
	$(function () {

		$('.loader').hide();

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
			// theme: 'bootstrap',
		});

		// $("#city_id,#subcity_id").select2({
		// 	dropdownParent : $("#formAddRecipient"),
		// });

		$('input[type="checkbox"]').iCheck({
	      checkboxClass: 'icheckbox_flat-blue',
	      radioClass   : 'iradio_flat-blue'
	    });

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

});//end
</script>
@endpush


