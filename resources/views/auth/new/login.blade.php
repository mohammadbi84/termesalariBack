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
                                    <img src="{{ asset('/hometemplate/img/intro-carousel/7.jpg') }}" class="h-100"
                                        style="object-fit: cover;width: 100%;height: 100%;">
                                    <div class="slide-caption">فروشگاه ترمه سالاری</div>
                                </a>
                            </li>
                            <li class="splide__slide position-relative">
                                <a href="#">
                                    <img src="{{ asset('/hometemplate/img/intro-carousel/6.jpg') }}" class="h-100"
                                        style="object-fit: cover;width: 100%;height: 100%;">
                                    <div class="slide-caption">فروشگاه ترمه سالاری</div>
                                </a>
                            </li>
                            <li class="splide__slide position-relative">
                                <a href="#">
                                    <img src="{{ asset('/hometemplate/img/intro-carousel/5.jpg') }}" class="h-100"
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
                        <div class="autocomplete mb-3 @error('verify_code') filled @enderror"
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
    <script>
        const menu = $(".main-menu");
        menu.addClass('small');

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
