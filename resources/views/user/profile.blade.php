@extends("user.user-layout")

@push('link')
	<link rel="stylesheet" type="text/css" href="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{asset('../storetemplate/plugins/select2/select2.min.css')}}">
	<style type="text/css">

		.datepicker-grid-view .header {
		    background-color: unset !important;
		    height: unset !important;
		    padding: unset !important;
		}

	</style>
@endpush
@section('title','پروفایل کاربری')
@section("card-title","اطلاعات حساب شخصی")
@section("user-content")
{{-- {{ $errors->first() }} --}}
	<form class="" id="" role="form" action="{{route('user.update',[Auth::user()])}}" method="POST">
		@csrf
		@method('put')
		<div class="form-row">
		    <div class="form-group col-md-6">
	    		<label for="name">نام</label>
	      		<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{old('name' , Auth::user()->name)}}" autofocus="autofocus">
	      		@error('name')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
	    	</div>

			<div class="form-group col-md-6">
	    		<label for="family">نام خانوادگی</label>
	      		<input type="text" name="family" id="" class="form-control @error('family') is-invalid @enderror" placeholder="" value="{{old('family' , Auth::user()->family)}}" >
	      		@error('family')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
	    	</div>
		    	  	
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
		      	<label for="nationalCode">کدملی (بدون خط تیره)</label>
		      	<input type="text" name="nationalCode" id="nationalCode" class="form-control @error('nationalCode') is-invalid @enderror" placeholder="" value="{{old('nationalCode' , Auth::user()->nationalCode)}}" maxlength="10" minlength="10" >
		      	@error('nationalCode')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>

		    <div class="form-group col-md-6">
		    	<label for="birthday">تاریخ تولد</label>
		      	<input type="text" name="birthday" id="birthday" class="form-control @error('birthday') is-invalid @enderror" placeholder="" value="{{old('birthday' , Verta(Auth::user()->birthday)->datetime()->format('Y-m-d'))}}" autocomplete="off" >
		      	@error('birthday')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
		    	<label for="mobile">شماره تلفن همراه</label>
		      	<input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="" minlength="11" maxlength="11" value="{{old('mobile' , Auth::user()->mobile)}}" >
		      	@error('mobile')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>

			<div class="form-group col-md-6">
		    	<label for="email">آدرس پست الکترونیک</label>
		      	<input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="" value="{{old('email' , Auth::user()->email)}}" >
		      	@error('email')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>
		</div>

		
		<div class="form-row">
		    <div class="form-group col-md-6">
		    	<label for="shaba_number">شماره شبا جهت بازگرداندن وجه </label>
		      	<input type="text" name="shaba_number" id="shaba_number" class="form-control @error('shaba_number') is-invalid @enderror" placeholder="" value="{{old('shaba_number')}}" maxlength="24">
		      	@error('shaba_number')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>
		    <div class="form-group col-md-6">
		    	<label for="send_newsletter">دریافت خبرنامه</label>
		      	<select name="send_newsletter" id="send_newsletter" class="form-control @error('send_newsletter') is-invalid @enderror">
		      		<option value="1"  @if(Auth::user()->send_newsletter == old('send_newsletter',1)) selected @endif>بله</option>
		      		<option value="0"  @if(Auth::user()->send_newsletter == old('send_newsletter',0)) selected @endif>خیر</option>
		      	</select>
		      	@error('send_newsletter')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>
		</div>

		{{-- <div class="form-row" style="display: none;">
		    <div class="form-group col-md-6">
		    	<label for=""></label>
		      	<input type="text" name="" id="" class="form-control @error('') is-invalid @enderror" placeholder="" value="{{old('')}}" >
		      	@error('')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>
		    <div class="form-group col-md-6">
		    	<label for=""></label>
		      	<input type="text" name="" id="" class="form-control @error('') is-invalid @enderror" placeholder="" value="{{old('')}}" >
		      	@error('')
				    <div class="invalid-feedback">{{$message}}</div>
				@enderror
		    </div>
		</div> --}}




		<div class="card-header mt-10"><div class="card-title"><span>افزودن اطلاعات حقوقی</span></div></div>
		<p class="pt-4">با تکمیل اطلاعات حقوقی، می‌توانید اقدام به خرید سازمانی با دریافت فاکتور رسمی و گواهی ارزش افزوده نمایید.</p>
    	<div class="card-body" id="page-content">

    		<div class="form-row">
			    <div class="form-group col-md-6">
			    	<label for="companyName">نام شرکت یا سازمان</label>
			      	<input type="text" name="companyName" id="companyName" class="form-control @error('companyName') is-invalid @enderror" placeholder="" value="{{old('companyName' , Auth::user()->companyName)}}" >
			      	@error('companyName')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
			    </div>
			    <div class="form-group col-md-6">
			    	<label for="companyEconomyID">کد اقتصادی</label>
			      	<input type="text" name="companyEconomyID" id="companyEconomyID" class="form-control @error('companyEconomyID') is-invalid @enderror" placeholder="" maxlength="12" minlength="12" value="{{old('companyEconomyID' , Auth::user()->companyEconomyID)}}" >
			      	@error('companyEconomyID')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
			    </div>
    		</div>

    		<div class="form-row">
			    <div class="form-group col-md-6">
			    	<label for="companyNationalID">شناسه ملی</label>
			      	<input type="text" name="companyNationalID" id="companyNationalID" class="form-control @error('companyNationalID') is-invalid @enderror" placeholder="" maxlength="11" minlength="11" value="{{old('companyNationalID' , Auth::user()->companyNationalID)}}" >
			      	@error('companyNationalID')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
			    </div>
			    <div class="form-group col-md-6">
			    	<label for="companyRegistrationID">شناسه ثبت</label>
			      	<input type="text" name="companyRegistrationID" id="companyRegistrationID" class="form-control @error('companyRegistrationID') is-invalid @enderror" placeholder="" value="{{old('companyRegistrationID' , Auth::user()->companyRegistrationID)}}" >
			      	@error('companyRegistrationID')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
			    </div>
    		</div>

    		<div class="form-row">
			    <div class="form-group col-md-6 @error('city_id') is-invalid @enderror">
					<label for="city_id">استان محل دفتر مرکزی</label>
		          	<select tabindex="1" name="city_id" id="city_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;" >
		                <option value="" selected="selected" style="">. نام استان را انتخاب کنید  </option>
		                @foreach($cities as $city)
		                	<option  @if ($city->id == old('city_id' , Auth::user()->city_id)) selected @endif value="{{$city->id}}">{{$city->name}}</option>
		                @endforeach

		          	</select>

		          	@error('city_id')
					    <div class="invalid-feedback d-block">{{$message}}</div>
					@enderror	
		        </div>

			    <div class="form-group col-md-6 @error('subcity_id') is-invalid @enderror">
						<label for="subcity_id">شهر محل دفتر مرکزی</label>
			          	<select tabindex="2" name="subcity_id" id="subcity_id" class="form-control select2 select2-hidden-accessible " style="width: 100%;" >

			                <option value="" selected="selected" style=""> . نام شهر را انتخاب کنید </option>

			                @isset($companySubcities)
			                	@foreach($companySubcities as $subcity) 
			                		<option  @if ($subcity->id == old('subcity_id' , Auth::user()->subcity_id)) selected @endif value="{{$subcity->id}}">{{$subcity->name}}</option>
			                	@endforeach
			                @endisset

			          	</select>

			          	@error('subcity_id')
						    <div class="invalid-feedback d-block">{{$message}}</div>
						@enderror	
			        </div>
    		</div>

    		<div class="form-row">
			    <div class="form-group col-md-6">
			    	<label for="companyTel">شماره تلفن ثابت</label>
			      	<input type="text" name="companyTel" id="companyTel" class="form-control @error('companyTel') is-invalid @enderror" placeholder="" value="{{old('companyTel' , Auth::user()->companyTel)}}" >
			      	@error('companyTel')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
			    </div>
			    <div class="form-group col-md-6">
			    	<label for="companySite">آدرس سایت</label>
			      	<input type="text" name="companySite" id="companySite" class="form-control @error('companySite') is-invalid @enderror" placeholder="" value="{{old('companySite' , Auth::user()->companySite)}}" >
			      	@error('companySite')
					    <div class="invalid-feedback">{{$message}}</div>
					@enderror
			    </div>
    		</div>

    		<input type="submit" class="btn btn-primary btn-flat" id="" name="" value="ثبت اطلاعات">






    	</div>


	</form>

@endsection

@push('js')
    <script src="{{asset('/storetemplate/plugins/datepicker-master/persian-date.min.js')}}"></script>
    <script src="{{asset('/storetemplate/plugins/datepicker-master/persian-datepicker.min.js')}}"></script>
    <!-- Select2 -->
	<script src="{{asset('../storetemplate/plugins/select2/select2.full.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            
            //http://babakhani.github.io/PersianWebToolkit/doc/datepicker/
			$('#birthday').pDatepicker({
            	onlySelectOnDate : true ,
            	autoClose : true ,
            	responsive : true ,
            	// observer: true,
            	
            	initialValueType: 'gregorian',
            	persianDigit: false,
    			format: 'YYYY/MM/DD',

            	// "inline" : true ,

            	timePicker : {
            		"enabled" : false ,
            	} ,
            	monthPicker : {
            		"enabled" : true ,
            		"titleFormat" : "YYYY" ,
            	} ,
            	yearPicker : {
            		"enabled" : true ,
            		"titleFormat" : "YYYY" ,
            	} ,
       //      	onSelect: function (unix) {
			    //     bd.touched = true;
			    //     // if (to && to.options && to.options.minDate != unix) {
			    //         var cachedValue = bd.getState().selected.unixDate;
			    //         bd.setDate(cachedValue);
			    //         // console.log('datepicker select : ' + cachedValue);
			    //         // to.options = {minDate: unix};
			    //         // if (to.touched) {
			    //         //     to.setDate(cachedValue);
			    //         // }
			    //     // }
			    // }

            });
            // $("#birthday").val("");



	        $('.select2').select2({
				// theme: 'bootstrap',
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

		    if($('#city_id').val() != "" )
		    {

		    	var z = $('#city_id').val();

			  	$('#subcity_id').html('<option value="" selected="selected" style=""> . نام شهر را انتخاب کنید </option>').trigger("change");
	    		$.ajax({
		            type:'POST',
		            url: '{{route("recipient.selectSubcity")}}',
		            data: {
		              _token: '<?php echo csrf_token() ?>',
		              id : $('#city_id').val()
		            },
		            success:function(data){
				        for (var i = data.results.length - 1; i >= 0; i--) {
				        	var newOption = new Option(data.results[i].text, data.results[i].id, false, false);
				        	// console.log(newOption);
							$('#subcity_id').append(newOption).trigger('change');
							if("{{ old('subcity_id') }}" == data.results[i].id || "{{ Auth::user()->subcity_id }}" == data.results[i].id)
							{
								{{-- console.log("{{ old('subcity_id') }}" +" - "+ data.results[i].id); --}}
								$('#subcity_id').children('[value="'+data.results[i].id+'"]').attr("selected","selected");
							}
				        }
		            }
		        });
		    }




        })//end
    </script>



@endpush