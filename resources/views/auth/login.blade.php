{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ورود به سایت</title>
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
</head>

<body class="hold-transition login-page"
    style="background: url({{ asset('/storetemplate/dist/img/logo.png') }}) no-repeat top center; background-size: contain;">
    <div class="login-box">
        <div class="login-logo">
            <b>ورود به فروشگاه ترمه سالاری</b>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">فرم زیر را تکمیل کنید و ورود را کلیک کنید.</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input name="login" id="login" type="text"
                            class="form-control @if ($errors->has('mobile') || $errors->has('email')) is-invalid @endif"
                            placeholder="آدرس ایمیل یا شماره موبایل" value="{{ old('login') }}" autofocus>

                        <div class="input-group-append">
                            <span class="fa fa-user input-group-text"></span>
                        </div>

                        @if ($errors->has('mobile') || $errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->has('mobile') ? $errors->first('mobile') : $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور">

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
                                    <input type="checkbox" class="flat-red" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}> من را به خاطر بسپار
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
                <!-- /.social-auth-links -->
                @if (Route::has('password.request'))
                    <p class="mb-1">
                        <a href="{{ route('password.request') }}">رمز عبورم را فراموش کرده ام.</a>
                    </p>
                @endif

                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">___ثبت نام___</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

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

</html> --}}



@extends('shop.layouts.master')
@section('title', 'ورود به سایت ترمه سالاری')
@section('head')
    <!-- login styles -->
    <link rel="stylesheet" href="{{ asset('shop/css/login.css') }}">
    <style>
        .splide__pagination {
            bottom: 1.7rem;
        }
    </style>
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
                <h4 class="mb-4">ورود به فروشگاه ترمه سالاری</h4>
                <p class="text-muted mb-5">برای دسترسی به امکانات فروشگاه، ابتدا وارد حساب کاربری شوید.</p>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="mb-3 mt-4">
                        <div class="autocomplete @error('login') filled @enderror" id="autocompleteBoxlogin">
                            <input type="text" id="searchInputlogin" value="{{ old('login') }}" class=""
                                name="login" oninput="nameinput('login')">
                            <label for="searchInputlogin">شماره موبایل یا آدرس ایمیل</label>
                            <span class="clear-btn" id="clearBtn_login" onclick="clearInput('login')"
                                @if (old('login')) style="display:block !important" @endif>×</span>
                        </div>
                        @error('login')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="autocomplete" id="autocompleteBoxpassword">
                            <input type="password" id="searchInputpassword" class="" name="password"
                                oninput="nameinput('password')">
                            <label for="searchInputpassword">رمز عبور</label>
                            <span class="clear-btn" id="clearBtn_password" onclick="clearInput('password')">×</span>
                        </div>
                        @error('password')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="flat-red" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">من را به خاطر بسپار</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">ورود</button>

                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <div class="mb-2"><a href="{{ route('password.request') }}">رمز عبور را فراموش کرده‌اید؟</a>
                            </div>
                        @endif
                        <div class="mb-2">حساب کاربری ندارید؟ <a href="{{ route('register') }}">ثبت نام کنید</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const menu = $(".main-menu");
        menu.addClass('small');
        const bookmarkFirst = $("#bookmark");
        bookmarkFirst.removeClass('expanded');
        bookmarkFirst.addClass('collapsed');
        let cart_dropdown = document.querySelector(".cart-dropdown");
        let favorites_dropdown = document.querySelector(".favorites-dropdown");
        let compare_dropdown = document.querySelector(".compare-dropdown");
        if (favorites_dropdown) {
            favorites_dropdown.style.top = "51px";
            favorites_dropdown.style.left = "-192px";
            cart_dropdown.style.left = "-113px";
            compare_dropdown.style.left = "-150px";
        } else {
            compare_dropdown.style.left = "-173px";
            cart_dropdown.style.left = "-133px";
        }
        compare_dropdown.style.top = "51px";
        cart_dropdown.style.top = "51px";
        categoriesMenu.style.top = "65px";
        categoriesMenu.style.left = "1rem";
        categoriesMenu.style.right = "1rem";
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
