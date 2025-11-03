<!DOCTYPE html>
{{-- نام کاربری باید حداقل 6 کاراکتر و شامل عدد و حروف لاتین و بدون فاصله باشد



 --}}
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>تایید شماره موبایل</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/bootstrap-rtl.min.css')}}">
  <!-- template rtl version -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/fonts/font-face-FD-WOL.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/custom-style.css')}}">
  <!-- sweetalert -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/sweetalert/sweetalert.css')}}">
  <style>
    /*.invalid-feedback{
      display: block;
    }*/*

    .loader{
    	display: none;
    }

  </style>
</head>
<body class="hold-transition register-page" style="background: url({{asset('/storetemplate/dist/img/logo.png')}}) no-repeat top center; background-size: contain;">
	<div>
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

	<div class="register-box">
	  	<div class="register-logo">
	      	<b>عضویت  در فروشگاه ترمه سالاری</b><br>
	      	<div class="small">گام دوم - فعال سازی کاربر</div>
	  	</div>
	    {{-- <p>رمز عبور باید شامل حداقل 8 کاراکتر باشد.</p> --}}
	    {{-- <p>شماره ملی را حتما بصورت صحیح وارد نمایید در غیر اینصورت با خطا مواجه خواهید شد.</p> --}}
	    {{-- <p>وارد کردن شماره موبایل فعال برای ارسال کد فعال سازی الزامی می باشد.</p> --}}
		<div class="card">
		    <div class="card-body register-card-body">
		      	<p class="text-justify">کد فعالسازی به شماره تلفن همراه شما  <b>@php $user = session()->get('authenticationUser'); print $user['mobile']; @endphp</b> پیامک شد. لطفا آن را در کادر زیر وارد و دکمه فعالسازی را کلیک کنید.</p>
		      	<p class="text-justify">در صورت نیاز به ویرایش شماره موبایل به مرحله قبل بازگردید.</p>
			    <form action="{{ route('register.checkVerifyCode') }}" method="post">
			        @csrf

			        <div class="input-group mb-3">
			          	<input name="active_code" id="active_code" type="active_code" maxlength="11" class="form-control @error('active_code') is-invalid @enderror" placeholder="کد فعالسازی " value="{{ old('active_code') }}"  >

			          	@error('active_code')
			              	<span class="invalid-feedback" role="alert">
			                 	<strong>{{ $message }}</strong>
			              	</span>
			          	@enderror
			          	
			          	{{-- <div>
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
						</div> --}}
			        </div>

			        <input type="submit" class="btn btn-danger btn-flat btn-sm" value="ثبت کد تایید" id="next-btn">   
			        <a href="" class="btn btn-success btn-flat btn-sm" id="resendSMS" >ارسال مجدد کد </a>   
			        {{-- <a href=""  class="btn btn-secondary btn-flat btn-sm" >بازگشت و ویرایش</a>  --}}
			        <input type="button" value="بازگشت و ویرایش"  onclick="window.history.go(-1); return false;" class="btn btn-secondary btn-flat btn-sm" name="">  
			    </form>
	    	</div>
	  	</div><!-- /.card -->
	</div>
	<!-- /.register-box -->

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
<!-- jQuery -->
<script src="{{asset('/storetemplate/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
{{-- sweetalert --}}
  <script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
  $(function () {

    $("#resendSMS").click(function(){
    	event.preventDefault();
    	$('.loader').show();
    	$.ajax({
            type:'GET',
            url: '{{ route('register.resendSMS') }}',
            // data: {
              {{-- _token: '<?php echo csrf_token() ?>', --}}
              // id : data.id
            // },
            success:function(data){
		        if(data.res == "error")
		        {
		        	title = "خطا  در اجرای عملیات" ;
		        }
		        else if(data.res == "success")
		        {
		        	title = "عملیات با موفقیت انجام شد.";
		        }
			    swal(title, data.message,data.res);
            },
		    complete: function(){
		        $('.loader').hide();
		    }
        });
    });


  })//END
</script>
</body>
</html>
