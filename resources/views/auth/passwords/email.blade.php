{{-- <!DOCTYPE html>
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
</html> --}}



@extends('shop.layouts.master')
@section('title', 'بازیابی رمز عبور')
@section('head')
    <!-- login styles -->
    <link rel="stylesheet" href="{{ asset('shop/css/login.css') }}">
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center">
        <div class="row w-75 login-card bg-white">
            <!-- اسلایدر راست -->
            <div class="col-md-6 d-none d-md-block p-0">
                <section dir="ltr" class="splide h-100" id="slider-1" aria-label="Splide Basic HTML Example">
                    <div class="splide__track h-100 shadow">
                        <ul class="splide__list h-100">
                            <li class="splide__slide position-relative">
                                <a href="#">
                                    <img src="{{ asset('shop/assets/sliders/l1.jpg') }}" class="h-100"
                                        style="object-fit: cover;width: 100%;height: 100%;">
                                    <div class="slide-caption">فروشگاه ترمه سالاری</div>
                                </a>
                            </li>
                            <li class="splide__slide position-relative">
                                <a href="#">
                                    <img src="{{ asset('shop/assets/sliders/l2.jpg') }}" class="h-100"
                                        style="object-fit: cover;width: 100%;height: 100%;">
                                    <div class="slide-caption">فروشگاه ترمه سالاری</div>
                                </a>
                            </li>
                            <li class="splide__slide position-relative">
                                <a href="#">
                                    <img src="{{ asset('shop/assets/sliders/l3.jpg') }}" class="h-100"
                                        style="object-fit: cover;width: 100%;height: 100%;">
                                    <div class="slide-caption">فروشگاه ترمه سالاری</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
            <!-- فورم سمت چپ -->
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <h4 class="mb-4">بازیابی رمز عبور</h4>
                <p class="text-justify text-muted mb-5">اطلاعات مربوط به بازیابی رمز عبور به ایمیل/شماره موبایل شما ارسال
                    خواهد شد</p>
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="mb-5 mt-4">
                        <div class="autocomplete mb-3 @error('email') filled @enderror" id="autocompleteBoxemail">
                            <input type="email" id="searchInputemail" class="" name="email"
                                oninput="nameinput('email')" value="{{ old('email') }}">
                            <label for="searchInputemail">ایمیل یا شماره موبایل</label>
                            <span class="clear-btn" id="clearBtn_email" onclick="clearInput('email')">×</span>
                        </div>
                        @error('email')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" id="submit" class="btn btn-primary w-100 mb-3">ارسال</button>
                    <a href="{{ route('login') }}" class="btn btn-flat btn-danger">بازگشت</a>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const menu = $(".main-menu");
        menu.addClass('small');

        $("#submit").click(function() {
            var data = $("#searchInputemail").val();
            if (isNaN(data) == false) {
                $("form").attr("action", "{{ route('forgetPasswordMobile.sendVerifyCode') }}");
            } else {
                $("form").attr("action", "{{ route('password.email') }}");
            }
            return true;
        });
    </script>
    <!-- slider -->
    <script>
        var splide = new Splide('#slider-1', {
            type: 'loop',
            perPage: 1,
            autoplay: true,
        });
        splide.mount();
    </script>
    <script>
        $(document).on("input", ".only-number", function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            let name = $(this).attr('name');
            const box = document.getElementById("autocompleteBox" + name);
            const clearBtn = document.getElementById("clearBtn_" + name);
            let value2 = $(this).val();
            if (value2.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        });

        function nameinput(id) {
            const input = document.getElementById("searchInput" + id);
            const box = document.getElementById("autocompleteBox" + id);
            const clearBtn = document.getElementById("clearBtn_" + id);
            if (input.value.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        }

        function clearInput(id) {

            const box = document.getElementById("autocompleteBox" + id);
            box.classList.remove("filled");
            const input = document.getElementById("searchInput" + id);
            input.value = "";
            const clearBtn = document.getElementById("clearBtn_" + id);
            clearBtn.style.display = 'none';

            if (id == 'state') {
                const box2 = document.getElementById("autocompleteBoxcity");
                const input2 = document.getElementById("searchInputcity");
                input2.value = "";
                document.getElementById("selectedIdcity").value = "";
                box2.classList.remove("filled");
                const clearBtn2 = document.getElementById("clearBtn_city");
                clearBtn2.style.display = 'none';
            }
        }
    </script>
@endsection
