<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | صفحه ثبت نام</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/adminlte.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/iCheck/all.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/bootstrap-rtl.min.css') }}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/fonts/font-face-FD-WOL.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/custom-style.css') }}">
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
</head>

<body class="hold-transition register-page"
    style="background: url({{ asset('/storetemplate/dist/img/logo.png') }}) no-repeat top center; background-size: contain;">
    <div class="register-box">
        <div class="register-logo">
            <b>عضویت در فروشگاه ترمه سالاری</b>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">ثبت نام کاربر جدید</p>

                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input name="name" id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror" placeholder="نام"
                            value="{{ old('name') }}" autofocus>
                        <div class="input-group-append">
                            <span class="fa fa-user input-group-text"></span>
                        </div>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input name="family" id="family" type="text"
                            class="form-control @error('family') is-invalid @enderror" placeholder="نام خانوادگی"
                            value="{{ old('family') }}">
                        <div class="input-group-append">
                            <span class="fa fa-users input-group-text"></span>
                        </div>

                        @error('family')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input name="mobile" id="mobile" type="mobile" maxlength="11"
                            class="form-control @error('mobile') is-invalid @enderror" placeholder="شماره موبایل "
                            value="{{ old('mobile') }}">
                        <div class="input-group-append">
                            <span class="fa fa-mobile input-group-text" style="font-size: 1.4rem;"></span>
                        </div>

                        @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input name="email" id="email" type="text"
                            class="form-control @error('email') is-invalid @enderror" placeholder="آدرس ایمیل"
                            value="{{ old('email') }}">
                        <div class="input-group-append">
                            <span class="fa fa-envelope input-group-text"></span>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input name="password" id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور">
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
                        <input id="password-confirm" name="password_confirmation" type="password" class="form-control"
                            placeholder="تکرار رمز عبور">
                        <div class="input-group-append">
                            <span class="fa fa-lock input-group-text"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="checkbox icheck">
                                <input id="conditions" name="conditions" type="checkbox" value="1"
                                    class="flat-red  @error('conditions') is-invalid @enderror"
                                    {{ old('conditions') ? 'checked' : '' }}>
                                <label for="conditions"><a href="#">شرایط </a>ثبت نام را می پذیرم.</label>

                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-danger btn-block btn-flat">ثبت نام</button>
                        </div>
                        <!-- /.col -->
                        @error('conditions')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>

                {{-- <div class="social-auth-links text-center">
        <p>- یا -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fa fa-facebook mr-2"></i>
          ثبت نام با اکانت فیس بود
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fa fa-google-plus mr-2"></i>
          ثبت نام با گوگل
        </a>
      </div> --}}

                <a href="{{ route('login') }}" class="text-center" style="font-weight: 700;">من قبلا ثبت نام کرده ام
                    .</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('/storetemplate/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('/storetemplate/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function() {
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass: 'iradio_flat-red'
            })
        })
    </script>
</body>

</html>
