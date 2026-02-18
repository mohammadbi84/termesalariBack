{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ثبت نام در فروشگاه ترمه سالاری</title>
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
            <b>عضویت در فروشگاه ترمه سالاری</b><br>
            <div class="small">گام اول</div>
        </div>
        <p>رمز عبور باید شامل حداقل 8 کاراکتر باشد.</p>
        <p>وارد کردن شماره موبایل فعال برای ارسال کد فعال سازی الزامی می باشد.</p>
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">ثبت نام کاربر جدید</p>
                <form action="{{ route('register.sendSMS') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="mobile" id="mobile" type="mobile" maxlength="11"
                            class="form-control @error('mobile') is-invalid @enderror" placeholder="شماره موبایل "
                            value="{{ old('mobile') }}" pattern="[a-zA-Z0-9]+">
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
                        <input name="password" id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور"
                            autocomplete="off">
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
                            placeholder="تکرار رمز عبور" autocomplete="off">
                        <div class="input-group-append">
                            <span class="fa fa-lock input-group-text"></span>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-danger btn-block btn-flat"
                        value="مرحله بعد - ارسال کد فعالسازی" id="next-btn">
                </form>
                <br>
                <a href="{{ route('login') }}" class="text-center" style="font-weight: 700;">من قبلا ثبت نام کرده ام
                    .</a>
            </div>
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

            $("#next-btn").click(function(event) {
                mobile = $(this).parent("form").find("#mobile").val();
                $mobileObject = $(this).parent("form").find("#mobile");
                if (mobile != "") {
                    if (isNaN(mobile) == true || mobile.length > 11 || mobile.length < 11) {
                        $mobileObject.addClass("is-invalid").focus();

                        var hasInvalidFeedback = $mobileObject.parent(".input-group").find(
                            ".invalid-feedback");
                        if (hasInvalidFeedback.length == 0) {
                            $mobileObject.parent(".input-group").append(
                                '<div class="invalid-feedback">لطفا شماره موبایل را به صورت عددی و با طول 11 رقم وارد کنید(.مثلا 09134577500)</div>'
                                );
                        } else {
                            $mobileObject.parent(".input-group").find("div[class=invalid-feedback]").text(
                                'لطفا شماره موبایل را به صورت عددی و با طول 11 رقم وارد کنید(.مثلا 09134577500)'
                                );
                        }

                        return false;
                        event.preventDefault();
                    }
                }
            });

        })
    </script>
</body>

</html> --}}



@extends('shop.layouts.master')
@section('title', 'ورود به سایت ترمه سالاری')
@section('head')
    <!-- login styles -->
    <link rel="stylesheet" href="{{ asset('shop/css/login.css') }}">
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center">
        <div class="row w-75 login-card bg-white">
            <!-- اسلایدر راست -->
            <div class="col-md-6 d-none d-md-block p-0 h-100">
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
                <h4 class="mb-4">عضویت در فروشگاه ترمه سالاری</h4>
                <p class="text-muted mb-5">برای ثبت نام اطلاعات خواسته شده را وارد کنید.</p>
                <form action="{{ route('register.sendSMS') }}" method="post">
                    @csrf
                    <div class="mb-5 mt-4">
                        <div class="autocomplete mb-3 {{ old('mobile') ? 'filled' :'' }}" id="autocompleteBoxmobile">
                            <input type="mobile" id="searchInputmobile" class="" name="mobile"
                                oninput="nameinput('mobile')" value="{{ old('mobile') }}" maxlength="11"
                                pattern="[a-zA-Z0-9]+">
                            <label for="searchInputmobile">شماره موبایل</label>
                            <span class="clear-btn" id="clearBtn_mobile" onclick="clearInput('mobile')">×</span>
                        </div>
                        @error('mobile')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror


                        <div class="autocomplete mb-3 {{ old('password') ? 'filled' :'' }}" id="autocompleteBoxpassword">
                            <input type="password" id="searchInputpassword" class="" name="password"
                                oninput="nameinput('password')" value="{{ old('password') }}" maxlength="11"
                                pattern="[a-zA-Z0-9]+">
                            <label for="searchInputpassword">رمز عبور</label>
                            <span class="clear-btn" id="clearBtn_password" onclick="clearInput('password')">×</span>
                        </div>
                        @error('password')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror

                        <div class="autocomplete mb-3 {{ old('password_confirmation') ? 'filled' :'' }}"
                            id="autocompleteBoxpassword_confirmation">
                            <input type="password" id="searchInputpassword_confirmation" class=""
                                name="password_confirmation" oninput="nameinput('password_confirmation')"
                                value="{{ old('password_confirmation') }}" maxlength="11" pattern="[a-zA-Z0-9]+">
                            <label for="searchInputpassword_confirmation">تکرار رمز عبور</label>
                            <span class="clear-btn" id="clearBtn_password_confirmation"
                                onclick="clearInput('password_confirmation')">×</span>
                        </div>
                        @error('password_confirmation')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">ثبت نام</button>

                    <div class="text-center">
                        <div class="mb-2">قبلا ثبت نام کرده اید؟ <a href="{{ route('login') }}">ورود به حساب کاربری</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
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
