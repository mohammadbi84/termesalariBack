{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>تایید شماره موبایل</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/bootstrap-rtl.min.css') }}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/fonts/font-face-FD-WOL.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/custom-style.css') }}">
    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/sweetalert/sweetalert.css') }}">
    <style>
        /*.invalid-feedback{
      display: block;
    }*/
        * .loader {
            display: none;
        }
    </style>
</head>

<body class="hold-transition register-page"
    style="background: url({{ asset('/storetemplate/dist/img/logo.png') }}) no-repeat top center; background-size: contain;">
    <div>
        @if (session()->has('success') or session()->has('danger'))
            <div
                class="alert  @if (session()->has('success')) alert-success @elseif(session()->has('danger')) alert-danger @endif  alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fa fa-check"></i> توجه!</h5>
                @if (session()->has('success'))
                    {{ session('success') }}
                @elseif(session()->has('danger'))
                    {{ session('danger') }}
                @endisset
        </div>
    @endif
</div>

<div class="register-box">
    <div class="register-logo">
        <b>عضویت در فروشگاه ترمه سالاری</b><br>
        <div class="small">گام دوم - فعال سازی کاربر</div>
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="text-justify">کد فعالسازی به شماره تلفن همراه شما <b>@php
                $user = session()->get('authenticationUser');
                print $user['mobile'];
            @endphp</b> پیامک شد. لطفا آن
                را در کادر زیر وارد و دکمه فعالسازی را کلیک کنید.</p>
            <p class="text-justify">در صورت نیاز به ویرایش شماره موبایل به مرحله قبل بازگردید.</p>
            <form action="{{ route('register.checkVerifyCode') }}" method="post">
                @csrf

                <div class="input-group mb-3">
                    <input name="active_code" id="active_code" type="active_code" maxlength="11"
                        class="form-control @error('active_code') is-invalid @enderror" placeholder="کد فعالسازی "
                        value="{{ old('active_code') }}">

                    @error('active_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <input type="submit" class="btn btn-danger btn-flat btn-sm" value="ثبت کد تایید" id="next-btn">
                <a href="" class="btn btn-success btn-flat btn-sm" id="resendSMS">ارسال مجدد کد </a>
                <input type="button" value="بازگشت و ویرایش" onclick="window.history.go(-1); return false;"
                    class="btn btn-secondary btn-flat btn-sm" name="">
            </form>
        </div>
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- LOADING... -->
<div class="loader">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" style="enable-background:new 0 0 50 50;"
        xml:space="preserve">
        <rect x="0" y="0" width="4" height="7" fill="#333">
            <animateTransform attributeType="xml" attributeName="transform" type="scale" values="1,1; 1,3; 1,1"
                begin="0s" dur="0.6s" repeatCount="indefinite" />
        </rect>

        <rect x="10" y="0" width="4" height="7" fill="#333">
            <animateTransform attributeType="xml" attributeName="transform" type="scale" values="1,1; 1,3; 1,1"
                begin="0.2s" dur="0.6s" repeatCount="indefinite" />
        </rect>
        <rect x="20" y="0" width="4" height="7" fill="#333">
            <animateTransform attributeType="xml" attributeName="transform" type="scale" values="1,1; 1,3; 1,1"
                begin="0.4s" dur="0.6s" repeatCount="indefinite" />
        </rect>
    </svg>
</div>
<!-- jQuery -->
<script src="{{ asset('/storetemplate/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/storetemplate/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(function() {

        $("#resendSMS").click(function() {
            event.preventDefault();
            $('.loader').show();
            $.ajax({
                type: 'GET',
                url: '{{ route('register.resendSMS') }}',
                success: function(data) {
                    if (data.res == "error") {
                        title = "خطا  در اجرای عملیات";
                    } else if (data.res == "success") {
                        title = "عملیات با موفقیت انجام شد.";
                    }
                    swal(title, data.message, data.res);
                },
                complete: function() {
                    $('.loader').hide();
                }
            });
        });
    }) //END
</script>
</body>

</html> --}}




@extends('shop.layouts.master')
@section('title', 'تایید شماره تلفن در سایت ترمه سالاری')
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
                <p class="text-justify text-muted mb-5">کد فعالسازی به شماره تلفن همراه شما <b>@php
                    $user = session()->get('authenticationUser');
                    print $user['mobile'];
                @endphp</b> پیامک
                    شد. لطفا آن
                    را در کادر زیر وارد و دکمه فعالسازی را کلیک کنید.</p>
                <form action="{{ route('register.checkVerifyCode') }}" method="post">
                    @csrf
                    <div class="mb-5 mt-4">
                        <div class="autocomplete mb-3 @error('active_code') filled @enderror" id="autocompleteBoxactive_code">
                            <input type="active_code" id="searchInputactive_code" class="" name="active_code"
                                oninput="nameinput('active_code')" value="{{ old('active_code') }}" maxlength="11"
                                pattern="[a-zA-Z0-9]+">
                            <label for="searchInputactive_code">کد فعالسازی</label>
                            <span class="clear-btn" id="clearBtn_active_code" onclick="clearInput('active_code')">×</span>
                        </div>
                        @error('active_code')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">ثبت کد تایید</button>

                    <div class="text-center">
                        <a href="" class="btn btn-success btn-flat btn-sm" id="resendSMS">ارسال مجدد کد </a>
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

        $("#resendSMS").click(function() {
            event.preventDefault();
            $.ajax({
                type: 'GET',
                url: '{{ route('register.resendSMS') }}',
                // data: {
                {{-- _token: '<?php echo csrf_token(); ?>', --}}
                // id : data.id
                // },
                success: function(data) {
                    if (data.res == "error") {
                        title = "خطا  در اجرای عملیات";
                    } else if (data.res == "success") {
                        title = "عملیات با موفقیت انجام شد.";
                    }
                    swal(title, data.message, data.res);
                },
                complete: function() {
                }
            });
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
