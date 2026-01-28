{{-- @extends('auth.layout')

@section('title', 'تایید شماره موبایل')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-4">
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
                    <form method="POST" action="{{ route('forgetPasswordMobile.verify') }}">
                        @csrf
                        <div class="input-group mb-4">
                            <input name="verify_code" id="verify_code" type="text" maxlength="11" class="form-control @error('verify_code') is-invalid @enderror" placeholder="کد تائید " value="{{ old('verify_code') }}"  >

                            @error('verify_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-2">
                           <input type="submit" class="btn btn-danger btn-flat btn-sm" value="ثبت کد تایید" id="verify">
                            <a href="#" class="btn btn-success btn-flat btn-sm" id="resendSMS" >ارسال مجدد کد </a>
                            <a href="{{ route('password.request') }}" class="btn btn-secondary btn-flat btn-sm" >بازگشت و ویرایش</a>
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
                        <div class="autocomplete mb-3 {{ old('verify_code') ? 'filled' :'' }}"
                            id="autocompleteBoxverify_code">
                            <input type="verify_code" id="searchInputverify_code" class="" name="verify_code"
                                oninput="nameinput('verify_code')">
                            <label for="searchInputverify_code">کد تائید</label>
                            <span class="clear-btn" id="clearBtn_verify_code" onclick="clearInput('verify_code')">×</span>
                        </div>
                        @error('verify_code')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" id="submit" class="btn btn-primary w-100 mb-3">ثبت کد تایید</button>
                    <div class="text-center">
                        <a href="#" class="btn btn-success btn-flat btn-sm" id="resendSMS">ارسال مجدد کد </a>
                        <a href="{{ route('password.request') }}" class="btn btn-secondary btn-flat btn-sm">بازگشت و
                            ویرایش</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('shop/js/main-menu-full.js') }}"></script>
    <script>

        $("#resendSMS").click(function(){
        event.preventDefault();
        $.ajax({
            type:'GET',
            url: '{{ route('password.resendSMS') }}',
            // data: {
              {{-- _token: '<?php echo csrf_token() ?>', --}}
              // id : data.id
            // },
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
