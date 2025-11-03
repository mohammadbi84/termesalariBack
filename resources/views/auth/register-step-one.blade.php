<!DOCTYPE html>
{{-- نام کاربری باید حداقل 6 کاراکتر و شامل عدد و حروف لاتین و بدون فاصله باشد



 --}}
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ثبت نام در فروشگاه ترمه سالاری</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/adminlte.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/iCheck/all.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/bootstrap-rtl.min.css')}}">
  <!-- template rtl version -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/fonts/font-face-FD-WOL.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/custom-style.css')}}">
  <style>
    .invalid-feedback{
      display: block;
    }
  </style>
</head>
<body class="hold-transition register-page" style="background: url({{asset('/storetemplate/dist/img/logo.png')}}) no-repeat top center; background-size: contain;">
	<div class="register-box">
	  	<div class="register-logo">
	      	<b>عضویت  در فروشگاه ترمه سالاری</b><br>
	      	<div class="small">گام اول</div>
	  	</div>
	    <p>رمز عبور باید شامل حداقل 8 کاراکتر باشد.</p>
	    {{-- <p>شماره ملی را حتما بصورت صحیح وارد نمایید در غیر اینصورت با خطا مواجه خواهید شد.</p> --}}
	    <p>وارد کردن شماره موبایل فعال برای ارسال کد فعال سازی الزامی می باشد.</p>
		<div class="card">
		    <div class="card-body register-card-body">
		      	<p class="login-box-msg">ثبت نام کاربر جدید</p>
			    <form action="{{ route('register.sendSMS') }}" method="post">
			        @csrf
			        <div class="input-group mb-3">
			          	<input name="mobile" id="mobile" type="mobile" maxlength="11" class="form-control @error('mobile') is-invalid @enderror" placeholder="شماره موبایل " value="{{ old('mobile') }}" pattern="[a-zA-Z0-9]+"  >
			          	<div class="input-group-append">
			            	<span class="fa fa-mobile input-group-text" style="font-size: 1.4rem;"></span>
			          	</div>
			            	<span class="text-danger text-bold" style="margin-top:15px;margin-left: 3px;"> * </span>
			          	
			          	@error('mobile')
			              	<span class="invalid-feedback" role="alert">
			                	<strong>{{ $message }}</strong>
			              	</span>
			          	@enderror
			        </div>

			        <div class="input-group mb-3">
			          	<input name="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور" autocomplete="off">
			          	<div class="input-group-append">
			            	<span class="fa fa-lock input-group-text"></span>
			          	</div>

			          	@error('password')
			              	<span class="invalid-feedback" role="alert">
			                  <strong>{{ $message }}</strong>
			              	</span>
			          	@enderror
			        </div>

			        <div class="input-group mb-3">
			          	<input id="password-confirm" name="password_confirmation" type="password" class="form-control" placeholder="تکرار رمز عبور" autocomplete="off" >
			          	<div class="input-group-append">
			            	<span class="fa fa-lock input-group-text"></span>
			          	</div>
			        </div>

			        <input type="submit" class="btn btn-danger btn-block btn-flat" value="مرحله بعد - ارسال کد فعالسازی" id="next-btn">   
			    </form>
			    <br>
		      	<a href="{{ route('login') }}" class="text-center" style="font-weight: 700;">من قبلا ثبت نام کرده ام .</a>
	    	</div>
	  	</div><!-- /.card -->
	</div>
	<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('/storetemplate/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('/storetemplate/plugins/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      	checkboxClass: 'icheckbox_flat-red',
      	radioClass   : 'iradio_flat-red'
    })

    $("#next-btn").click(function(event){
    	mobile = $(this).parent("form").find("#mobile").val();
    	$mobileObject = $(this).parent("form").find("#mobile");
    	if(mobile != "")
    	{
    		if (isNaN(mobile) == true || mobile.length > 11 || mobile.length < 11 ){
    			$mobileObject.addClass("is-invalid").focus();

    			var hasInvalidFeedback = $mobileObject.parent(".input-group").find(".invalid-feedback");
				if(hasInvalidFeedback.length == 0){
					$mobileObject.parent(".input-group").append('<div class="invalid-feedback">لطفا شماره موبایل را به صورت عددی و با طول 11 رقم وارد کنید(.مثلا 09134577500)</div>');
				}
				else{
					$mobileObject.parent(".input-group").find("div[class=invalid-feedback]").text('لطفا شماره موبایل را به صورت عددی و با طول 11 رقم وارد کنید(.مثلا 09134577500)');
				}

    			return false;
				event.preventDefault();
    		}
    	}
    });

  })
</script>
</body>
</html>
