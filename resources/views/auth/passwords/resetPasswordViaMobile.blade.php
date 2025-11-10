{{-- @extends('auth.layout')

@section('title', 'تغییر رمز عبور')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
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
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('password.updatePassword') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('شماره موبایل') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $user->mobile ?? old('mobile') }}" required readonly autofocus>

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('رمز عبور جدید') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('تکرار رمز عبور جدید') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('تغییر رمز عبور') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
  $(function () {

    $("#resendSMS").click(function(){
        event.preventDefault();
        $('.loader').show();
        $.ajax({
            type:'GET',
            url: '{{ route('password.resendSMS') }}',
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

@endpush --}}



@extends('shop.layouts.master')
@section('title', 'تغییر رمز عبور')
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
                <h4 class="mb-4">تغییر رمز عبور</h4>
                {{-- <p class="text-justify text-muted mb-5">اطلاعات مربوط به بازیابی رمز عبور به ایمیل/شماره موبایل شما ارسال
                    خواهد شد</p> --}}
                <form action="{{ route('password.updatePassword') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-5 mt-4">
                        <div class="autocomplete mb-3 @error('mobile') filled @enderror" id="autocompleteBoxmobile">
                            <input type="mobile" id="searchInputmobile" class="" name="mobile"
                                oninput="nameinput('mobile')" value="{{ $user->mobile ?? old('mobile') }}">
                            <label for="searchInputmobile">{{ __('شماره موبایل') }}</label>
                            <span class="clear-btn" id="clearBtn_mobile" onclick="clearInput('mobile')">×</span>
                        </div>
                        @error('mobile')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror

                        <div class="autocomplete mb-3 @error('password') filled @enderror" id="autocompleteBoxpassword">
                            <input type="password" id="searchInputpassword" class="" name="password"
                                oninput="nameinput('password')">
                            <label for="searchInputpassword">{{ __('رمز عبور جدید') }}</label>
                            <span class="clear-btn" id="clearBtn_password" onclick="clearInput('password')">×</span>
                        </div>
                        @error('password')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror


                        <div class="autocomplete mb-3 @error('password_confirmation') filled @enderror" id="autocompleteBoxpassword_confirmation">
                            <input type="password_confirmation" id="searchInputpassword_confirmation" class="" name="password_confirmation"
                                oninput="nameinput('password_confirmation')">
                            <label for="searchInputpassword_confirmation">{{ __('تکرار رمز عبور جدید') }}</label>
                            <span class="clear-btn" id="clearBtn_password_confirmation" onclick="clearInput('password_confirmation')">×</span>
                        </div>
                        @error('password_confirmation')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" id="submit" class="btn btn-primary w-100 mb-3">{{ __('Reset Password') }}</button>
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
