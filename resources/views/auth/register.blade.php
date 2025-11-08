{{-- <!DOCTYPE html>
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
            <div class="small">گام سوم - تکمیل ثبت نام</div>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">تکمیل ثبت نام کاربر </p>
                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input name="name" id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror" placeholder="نام (الزامی)"
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
                            class="form-control @error('family') is-invalid @enderror"
                            placeholder="نام خانوادگی (الزامی)" value="{{ old('family') }}">
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
                        <input name="email" id="email" type="text"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="آدرس پست الکترونیک (اختیاری)" value="{{ old('email') }}">
                        <div class="input-group-append">
                            <span class="fa fa-envelope input-group-text"></span>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="checkbox icheck">
                                <input id="conditions" name="conditions" type="checkbox" value="1"
                                    class="flat-red  @error('conditions') is-invalid @enderror"
                                    {{ old('conditions') ? 'checked' : '' }}>
                                <label for="conditions"><a href="{{ route('terms') }}">شرایط </a>ثبت نام را می
                                    پذیرم.</label>

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
                <h4 class="mb-4">عضویت در فروشگاه ترمه سالاری</h4>
                <p class="text-justify text-muted mb-5">گام سوم - تکمیل ثبت نام</p>
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="mb-5 mt-4">
                        <div class="autocomplete mb-3 @error('name') filled @enderror" id="autocompleteBoxname">
                            <input type="text" id="searchInputname" class="" name="name"
                                oninput="nameinput('name')" value="{{ old('name') }}">
                            <label for="searchInputname">نام (الزامی)</label>
                            <span class="clear-btn" id="clearBtn_name" onclick="clearInput('name')">×</span>
                        </div>
                        @error('name')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror

                        <div class="autocomplete mb-3 @error('family') filled @enderror" id="autocompleteBoxfamily">
                            <input type="text" id="searchInputfamily" class="" name="family"
                                oninput="nameinput('family')" value="{{ old('family') }}">
                            <label for="searchInputfamily">نام خانوادگی (الزامی)</label>
                            <span class="clear-btn" id="clearBtn_family" onclick="clearInput('family')">×</span>
                        </div>
                        @error('family')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror

                        <div class="autocomplete mb-3 @error('email') filled @enderror" id="autocompleteBoxemail">
                            <input type="email" id="searchInputemail" class="" name="email"
                                oninput="nameinput('email')" value="{{ old('email') }}">
                            <label for="searchInputemail">آدرس پست الکترونیک (اختیاری)</label>
                            <span class="clear-btn" id="clearBtn_email" onclick="clearInput('email')">×</span>
                        </div>
                        @error('email')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror

                        <input id="conditions" name="conditions" type="checkbox" value="1"
                            class="flat-red  @error('conditions') is-invalid @enderror"
                            {{ old('conditions') ? 'checked' : '' }}>
                        <label for="conditions"><a href="{{ route('terms') }}">شرایط </a>ثبت نام را می
                            پذیرم.</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">ثبت نام</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const menu = $(".main-menu");
        menu.addClass('small');
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
