<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ورود به سایت</title>
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
</head>

<body class="hold-transition login-page" style="background: url({{asset('/storetemplate/dist/img/logo.png')}}) no-repeat top center; background-size: contain;">
  {{-- @dump($errors) --}}
<div class="login-box">
  <div class="login-logo">
    <b>ورود به فروشگاه ترمه سالاری</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">فرم زیر را تکمیل کنید و ورود را کلیک کنید.</p>

      <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="input-group mb-3">
          <input name="login" id="login" type="text" class="form-control @if($errors->has('mobile') || $errors->has('email')) is-invalid @endif" placeholder="آدرس ایمیل یا شماره موبایل"  value="{{ old('login') }}"  autofocus>

          <div class="input-group-append">
            <span class="fa fa-user input-group-text"></span>
          </div>

          @if($errors->has('mobile') || $errors->has('email'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->has('mobile') ? $errors->first('mobile') : $errors->first('email') }}</strong>
              </span>
          @endif
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور">

          <div class="input-group-append @error('password') is-invalid @enderror">
            <span class="fa fa-lock input-group-text"></span>
          </div>

          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" class="flat-red" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} > من را به خاطر بسپار
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-danger btn-block btn-flat">ورود</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      {{-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fa fa-facebook mr-2"></i> ورود با اکانت فیسوبک
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fa fa-google-plus mr-2"></i> ورود با اکانت گوگل
        </a>
      </div> --}}
      <!-- /.social-auth-links -->
            
      @if (Route::has('password.request'))      
        <p class="mb-1">
          <a href="{{ route('password.request') }}">رمز عبورم را فراموش کرده ام.</a>
        </p>
      @endif

      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">___ثبت نام___</a>
      </p>
{{-- 
      <form method="post" action="{{ route('a.reset') }}">
        @csrf
        <input type="submit" name="">
      </form> --}}

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

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
  })
</script>
</body>
</html>
