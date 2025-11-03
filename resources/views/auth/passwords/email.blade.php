<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>بازیابی رمز عبور</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/adminlte.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('/plugins/iCheck/square/blue.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/bootstrap-rtl.min.css')}}">
  <!-- template rtl version -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/fonts/font-face-FD-WOL.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/custom-style.css')}}">
</head>
<body class="hold-transition login-page" style="background: url({{asset('/storetemplate/dist/img/logo.png')}}) no-repeat top center; background-size: contain;">
<div class="login-box">
  <div class="login-logo">
    <b>بازیابی رمز عبور</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif
      <p class="login-box-msg" style="line-height: 30px">اطلاعات مربوط به بازیابی رمز عبور به ایمیل/شماره موبایل شما ارسال خواهد شد.</p>

      <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="input-group mb-3">
          <input name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="ایمیل یا شماره موبایل"  value="{{ old('email') }}" required autocomplete="email" autofocus>

          <div class="input-group-append">
            <span class="fa fa-envelope input-group-text"></span>
          </div>

          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        
          <!-- /.col -->
          <div class="">
            <button type="submit" class="btn btn-danger btn-flat" id="submit">ارسال</button>
            <a href="{{ route('login') }}" class="btn btn-flat btn-danger">بازگشت</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
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
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })

    $("#submit").click(function(){
      var data = $("#email").val();
      if(isNaN(data) == false){
        $("form").attr("action","{{ route('forgetPasswordMobile.sendVerifyCode') }}");
      }
      else{
        $("form").attr("action","{{ route('password.email') }}");
      }
      return true;
    });

  })
</script>
</body>
</html>
