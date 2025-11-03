<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    @stack('link')
    <!-- Favicons -->
    <link href="{{ asset('/hometemplate/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('/hometemplate/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    {{-- <link href="{{asset('/hometemplate/css/font.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/fonts/font-face-FD-WOL.css') }}">
    <!-- Bootstrap CSS File -->
    <link href="{{ asset('/storetemplate/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{asset('/hometemplate/lib/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet"> --}}

    <!-- Libraries CSS Files -->
    <link href="{{ asset('/hometemplate/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css') }}">
    {{-- <link href="{{asset('/hometemplate/lib/font-awesome/css/all.min.css')}}" rel="stylesheet"> --}}
    <link href="{{ asset('/hometemplate/lib/fontawesome-free-5.12.0/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link href="{{ asset('/hometemplate/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/hometemplate/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/storetemplate/plugins/owlcarousel/dist/assets/owl.theme.default.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/hometemplate/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <!-- Main Stylesheet File -->
    <link href="{{ asset('/hometemplate/css/style.css') }}" rel="stylesheet">
    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/adminlte.min.css') }}">
    <!-- bootstrap rtl  -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/custom-style.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/dist/css/cart.css') }}">

    <!-- Rating  -->
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/css-stars.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css') }}">
    <link rel="stylesheet" href="{{ asset('/storetemplate/plugins/nprogress-master/nprogress.css') }}">
    @stack('linkLast')
    <style type="text/css" media="screen">
        .loader {
            display: none;
        }

        .swal-modal {
            direction: ltr;
        }

        .sweet-alert h2 {
            font-family: 'Vazir';
        }

        .box-product .img-wrapper {
            height: 13rem;
        }

        .box-product .title {
            font-size: 0.8rem;
            color: #666;
        }

        .box-product .price {
            text-align: right;
            font-size: 1rem;
            font-weight: bold;
        }

        .login-icon:hover {
            color: #ef3a4e !important;
            background-color: transparent !important;
            /*border-color: white !important;*/
        }

        #intro .carousel-item::before {
            background-color: rgba(0, 0, 0, 0) !important;
        }

        .carousel a {
            color: white !important;

        }

        @media (min-width: 1501px) {

            .container-fluid {
                width: 80% !important;
            }

        }

        /*
      ##Device = Desktops
      ##Screen = 1281px to higher resolution desktops
    */

        @media (min-width: 1381px) and (max-width: 1500px) {

            .container-fluid {
                width: 90% !important;
            }

        }

        @media (min-width: 1281px) and (max-width: 1380px) {

            .container-fluid {
                width: 100% !important;
            }

        }

        /*
      ##Device = Laptops, Desktops
      ##Screen = B/w 1025px to 1280px
    */

        @media (min-width: 1025px) and (max-width: 1280px) {

            .container-fluid {
                width: 100% !important;
            }

        }

        /*
      ##Device = Tablets, Ipads (portrait)
      ##Screen = B/w 768px to 1024px
    */

        @media (min-width: 768px) and (max-width: 1024px) {

            .container-fluid {
                width: 100% !important;
            }

        }

        /*
      ##Device = Tablets, Ipads (landscape)
      ##Screen = B/w 768px to 1024px
    */

        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {

            .container-fluid {
                width: 100% !important;
            }

        }

        /*
      ##Device = Low Resolution Tablets, Mobiles (Landscape)
      ##Screen = B/w 481px to 767px
    */

        @media (min-width: 481px) and (max-width: 767px) {

            .container-fluid {
                width: 100% !important;
            }

        }

        /*
      ##Device = Most of the Smartphones Mobiles (Portrait)
      ##Screen = B/w 320px to 479px
    */

        @media (min-width: 320px) and (max-width: 480px) {

            .container-fluid {
                width: 100% !important;
            }

        }
    </style>
</head>

<body style="overflow-x: unset;">
    @php
        // dd(session('cart'));
        if (session()->has('cart')) {
            $cart = session('cart');
            $sum = 0;
            $list = ['products' => [], 'models' => [], 'quantities' => []];
            foreach ($cart as $productID => $value) {
                foreach ($value as $model => $data) {
                    $class = 'App\\' . $model;
                    $product = $class::find($productID);
                    // if ($product->visibility == 1) {
                    array_push($list['products'], $product);
                    array_push($list['models'], $model);
                    array_push($list['quantities'], $data['quantity']);
                    $sum = $sum + $data['quantity'];
                    // }
                }
            }

            // foreach ($list["model"] as $key => $value) {
            //   dd($value);
            // }
        }
    @endphp
    <!--==========================
    Header
  ============================-->
    <header id="header">
        <div class="container-fluid">

            <nav id="nav-menu-container" class="nav-menu-container">
                <ul class="nav-menu">

                    <li class="nav-item dropdown">
                        <a class="nav-link cart" data-toggle="dropdown" href="{{ route('cart.index') }}">
                            <i class="fa fa-shopping-cart"></i>
                            @isset($cart)
                                <span
                                    class="badge badge-danger navbar-badge shopping-cart-badge">{{ $sum }}</span>
                            @endisset
                        </a>

                        @isset($cart)

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">

                                <div class="m-2 text-sm" id="cartHeader" style="line-height: 33px;">
                                    <div class="float-right">
                                        <span class="" id="totalQuantity">
                                            @if (isset($cart))
                                                {{ $sum }}
                                            @else
                                                0
                                            @endif
                                        </span> کالا
                                    </div>

                                    {{-- <span class="float-left"> --}}
                                    <a class="btn btn-flat btn-sm btn-danger mb-2 float-left"
                                        style="border-radius: 5px 0px;" href="{{ route('cart.index') }}">مشاهده سبد خرید و
                                        پرداخت</a>
                                    {{-- <i class="fa fa-arrow-left"></i> --}}
                                    {{-- </span> --}}
                                </div>
                                <div class="dropdown-divider" style="clear: both;"></div>

                                <div id="cartContainer">
                                    @isset($list)
                                        @php
                                            $price = 0;
                                            $off = 0;
                                        @endphp
                                        @foreach ($list['products'] as $key => $item)
                                            @php
                                                $cartPrice = 0;
                                                $cartOff = 0;
                                                $p = $item->prices->where('local', 'تومان')->first();
                                                if ($p->offPrice > 0) {
                                                    if ($p->offType == 'مبلغ') {
                                                        $cartPrice = $p->price - $p->offPrice;
                                                        $cartOff = $p->offPrice;
                                                        $price =
                                                            $price +
                                                            ($p->price - $p->offPrice) * $list['quantities'][$key];
                                                        $off = $off + $cartOff * $list['quantities'][$key];
                                                    } elseif ($p->offType == 'درصد') {
                                                        $cartPrice = $p->price - $p->price * ($p->offPrice / 100);
                                                        $cartOff = $p->price * ($p->offPrice / 100);
                                                        $price =
                                                            $price +
                                                            ($p->price - $p->price * ($p->offPrice / 100)) *
                                                                $list['quantities'][$key];
                                                        $off = $off + $cartOff * $list['quantities'][$key];
                                                    }
                                                } else {
                                                    $cartPrice = $p->price;
                                                    $price = $price + $p->price * $list['quantities'][$key];
                                                }
                                            @endphp
                                            <div class="dropdown-item" data-id="{{ $item->id }}"
                                                data-moddel="{{ $list['models'][$key] }}">
                                                <div class="row">
                                                    <div class="col-4 m-auto">
                                                        <img class="w-100"
                                                            src="{{ asset('storage/images/' . $item->images->first()->name) }}"
                                                            alt="" style="vertical-align: super;">
                                                    </div>
                                                    <div class="col-8">
                                                        <p class="text-sm"
                                                            title="{{ $item->title . ' طرح ' . $item->color_design->design->title . ' رنگ ' . $item->color_design->color->color }}">
                                                            <a href="
                                                                    @switch($list['models'][$key])
                                                                      @case('Tablecloth')
                                                                        {{ route('tablecloth.show', [$item->id]) }}
                                                                      {{-- @case('Shoe')
                                                                        {{ route('shoe.show',[$item->id]) }} --}}
                                                                    @endswitch"
                                                                data-id="{{ $item->id }}"
                                                                data-moddel="{{ $list['models'][$key] }}">

                                                                {{ Str::limit($item->title . ' طرح ' . $item->color_design->design->title . ' رنگ ' . $item->color_design->color->color, 30) }}
                                                            </a>

                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    @if ($cartOff > 0)
                                                        <div class="col-6">
                                                            <span class=" text-muted text-sm">
                                                                <del><span
                                                                        class="cartOriginalPrice">{{ number_format($p->price) }}</span>
                                                                    {{ $p->local }}
                                                            </span></del>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="mt-2 text-muted text-sm">
                                                                <span
                                                                    class="cartPrice">{{ number_format($cartPrice) }}</span>
                                                                {{ $p->local }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="col-12">
                                                            <div class="col-6">
                                                                <span class="mt-2 text-muted text-sm">
                                                                    <span class="cartPrice">{{ number_format($cartPrice) }}
                                                                    </span> {{ $p->local }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row mt-2 text-muted text-sm">
                                                    <div class="col-6 text-right">
                                                        <span class="cartQuantity">{{ $list['quantities'][$key] }}</span> عدد
                                                    </div>

                                                    <div class="col-6 text-left">
                                                        <a href="#" class="deleteCartItem"
                                                            data-id="{{ $item->id }}"
                                                            data-model="{{ $list['models'][$key] }}"><i
                                                                class="far fa-trash-alt float-left"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider" style="clear: both;"></div>
                                        @endforeach
                                    @endisset
                                </div>

                                <div class="dropdown-item" id="cartFooter" style="text-align: center;">

                                    <span>
                                        <small class="text-muted text-sm" sty>مبلغ قابل پرداخت : </small>
                                        <strong id="cartTotalPrice">{{ number_format($price) }}</strong>
                                        <small class="text-muted text-sm"> تومان</small>
                                    </span>

                                    @if (!Auth::check())
                                        <a href="{{ route('login') }}" class="btn btn-danger text-sm btn-block"
                                            style="margin-top: 10px">ورود و ثبت سفارش</a>
                                    @endif

                                </div>{{-- cartFooter --}}


                            </div>{{-- cartContainer --}}
                        @endisset
                    </li>

                    @if (!Auth::check())
                        <li class="nav-item dropdown">
                            <a href="{{ route('login') }}" class="btn btn-flat btn-danger login-icon"
                                style="padding: 5px !important;"> <i class="fa fa-user ml-2"></i> ورود به حساب کاربری
                                / ثبت نام</a>
                        </li>
                        {{-- <li class="nav-item dropdown">
              <a href="{{ route('register.stepOne') }}" class="btn btn-flat btn-danger login-icon" style="padding: 5px !important;"> <i class="fa fa-user ml-2"></i> ثبت نام</a>
            </li> --}}
                    @endif

                    @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                {{ Auth::user()->name }} {{ Auth::user()->family }}&nbsp;<i
                                    class="fa fa-chevron-down" style="font-size: 0.5rem"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="font-size: 0.9rem;">
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.myOrders') }}" class="dropdown-item">
                                    <i class="fa  fa-shopping-cart ml-2"></i>سفارش های من
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.profile') }}" class="dropdown-item">
                                    <i class="fa fa-address-card-o ml-2"></i> تنظیمات حساب کاربری
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.changePassword') }}" class="dropdown-item">
                                    <i class="fa fa-key ml-2"></i>تغییر رمز عبور
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="" class="dropdown-item"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <i class="fa fa-sign-out ml-2"></i> خروج
                                    {{-- <span class="float-left text-muted text-sm">12 ساعت</span> --}}
                                </a>

                        </li>
                    @endif


                </ul>
            </nav><!-- #nav-menu-container -->

            <div id="logo" class="logo pull-right">
                <h1>
                    <a href="{{ route('homeStore.index') }}" class="scrollto" style="display: inline-block;">
                        <img src="{{ asset('/hometemplate/img/logo.png') }}" alt="ترمه سالاری"
                            title="ترمه سالاری" />
                        فروشگاه ترمه سالاری
                    </a>
                </h1>
                <!-- Uncomment below if you prefer to use an image logo -->
            </div>


        </div>
    </header><!-- #header -->

    <!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="homeStoreIntro">
        <div class="intro-container">
            <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

                <ol class="carousel-indicators"></ol>

                <div class="carousel-inner" role="listbox">
                    @if (isset($slideshows) and count($slideshows) > 0)
                        @foreach ($slideshows as $key => $slideshow)
                            <div class="carousel-item @if ($key == 0) active @endif">
                                <div class="carousel-background">
                                    <img src="{{ asset('storage/images/' . $slideshow->image) }}" alt="">
                                </div>
                                <div class="carousel-container">
                                    <div class="carousel-content">
                                        <h2><a href="{{ $slideshow->link }}">{{ $slideshow->title }}</a></h2>
                                        <p>{{ $slideshow->description }}</p>
                                        {{-- <a href="#" class="btn-get-started scrollto">ورود به فروشگاه ترمه سالاری</a> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">قبلی</span>
                </a>

                <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">بعدی</span>
                </a>

            </div>
        </div>
    </section><!-- #intro -->

    <main id="main">
        <!--<div class="container"> -->
        <div class="row">
            <div class="container-fluid">
                @yield('main-content')
            </div>
        </div>
        <!--</div> -->
    </main>

    <!--==========================
    Footer
  ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-info">
                        <h3>ترمه سالاری</h3>
                        <p>ترمه سالاری یزد با بیش از یک قرن تجربه و سیصد طرح متنوع، ارائه دهنده ی معروف ترین و مرغوب
                            ترین ترمه ها در ایران می باشد. شعار ما "ترمه سالاری برای هر ایرانی با کیفیتی عالی و قیمتی
                            مناسب" می باشد تا همه اقشار ملت بتوانند از آن بهره مند شوند.</p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>دسترسی سریع</h4>
                        <ul>
                            {{-- <li><i class="ion-ios-arrow-left"></i> <a href="#intro">صفحه اصلی</a></li>
              <li><i class="ion-ios-arrow-left"></i> <a href="#services">نمایندگی ها</a></li> --}}

                            <li><i class="ion-ios-arrow-left"></i> <a href="#portfolio">نمونه محصولات</a></li>
                            <li><i class="ion-ios-arrow-left"></i> <a href="#call-to-action">سفارش محصول</a></li>

                            <li><i class="ion-ios-arrow-left"></i> <a href="http://www.termehsalari.com/shop">ورود به
                                    فروشگاه</a></li>
                            <li><i class="ion-ios-arrow-left"></i> <a href="{{ route('terms') }}">شرایط و قوانین</a>
                            </li>
                            <li><i class="ion-ios-arrow-left"></i> <a href="{{ route('privacy-policy') }}">حریم
                                    خصوصی</a></li>

                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>ارتباط با ما</h4>
                        <p>
                            فروشگاه مرکزی : میدان امیرچقماق<br>
                            <strong>تلفن:</strong> 37 06 3626 035<br>
                            فروشگاه شماره2 : جنب شیرینی سازی حاج خلیفه رهبر .سرای ترمه <br>
                            <strong>تلفن:</strong> 80 38 3622 035<br>
                            <strong>ایمیل:</strong> Info@TermehSalari.com<br>
                            <i class="far fa-paper-plane"></i> <i class="fab fa-whatsapp"></i> 09134577500
                        </p>

                        <div class="social-links">
                            {{-- <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></i></a> --}}
                            <a href="https://www.instagram.com/termehsalari/" class="instagram"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="https://telegram.me/termeh_salari" class="google-plus"><i
                                    class="fab fa-telegram-plane"></i></a>
                            {{-- <a href="#" class="linkedin"><i class="fab fa-whatsapp"></i></a> --}}
                            <a href="mailto:Info@TermehSalari.com" class="google-plus"><i
                                    class="far fa-envelope"></i></a>
                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6 footer-newsletter">
                        <h4>خبرنامه</h4>
                        <p>کاربر گرامی: لطفا برای اطلاع از تخفیف‌ها و جدیدترین‌های ترمه سالاری در خبرنامه عضو شوید.</p>
                        {{-- @if (session('status-join', '0') == 1)
                <div class="sendmessage">
                  شما با موفقیت عضو خبرنامه شدید.<br>
                  از حالا منتظر خبرهای جذاب ما باشید.
                </div>
              @endif --}}
                        <form action="{{ route('newsletter.store') }}" method="post">
                            @csrf
                            <input type="email" class=" @error('email_join_newsletter') is-invalid @enderror"
                                name="email_join_newsletter" id="email_join_newsletter"
                                placeholder=" آدرس ایمیل خود را بنویسید"
                                value="{{ old('email_join_newsletter') }}"><input type="submit"
                                class="joinNewsletter" value="عضویت">
                        </form>
                        <div>
                            <img src="{{ asset('/storetemplate/dist/img/behpardakht.png') }}"
                                alt="behpardakht termeh salari">

                            <a referrerpolicy="origin" target="_blank"
                                href="https://trustseal.enamad.ir/?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"><img
                                    referrerpolicy="origin"
                                    src="https://Trustseal.eNamad.ir/logo.aspx?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"
                                    alt=""
                                    style="cursor:pointer;width: 100px;filter:contrast(200%) brightness(150%);"
                                    id="Anvxg4lW2ecEYh0W8QsV"></a>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>termehsalari</strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=BizPage
        -->
                Designed by <a href="https://www.fazeledu.com/">FazelEdu</a>
            </div>
        </div>
    </footer><!-- #footer -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <div id="preloader"></div>
    <div class="ui-chat-container">
        <button class="btn_chat_lancher">
            <span class="open_me active"><i class="fa fa-comments"></i></span>
            <span class="close_me"></span>
        </button>

        <div id="chat-box" class="">
            <div class="pt-2 pr-2 pl-2">
                <p>{{-- سلام، وقت بخیر <br> --}}
                    ما همیشه همراه شما هستیم، تمامی سوالات خود را با ما در میان بگذارید.</p>
            </div>

            <form action="{{ route('message.store') }}" class="contactForm pr-2 pl-2 pb-2">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name" placeholder="نام" data-rule="minlen:2" data-msg="لطفا نام خود را بنویسید ."
                        value="{{ old('name') }}" />
                    <div class="validation"></div>
                </div>

                <div class="form-group">
                    <input type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                        id="mobile" maxlength="11" placeholder="شماره موبایل" data-rule="mobile"
                        data-msg="لطفا شماره موبایل فعال خود را بنویسید ." value="{{ old('mobile') }}" />
                    <div class="validation"></div>
                </div>

                <div class="form-group">
                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" rows="5"
                        data-rule="required" data-msg="لطفا متن پیام را بنویسید ." placeholder="متن پیام">{{ old('message') }}</textarea>
                    <div class="validation"></div>
                </div>

                <div class="text-right"><button id="sendMessage" type="submit"
                        class="btn btn-flat btn-outline-danger btn-sm">ارسال پیام</button></div>
            </form>

            <div class="chat-box-footer">
                <div class="social">
                    <a href="https://www.instagram.com/termehsalari/" title="termehsalari"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://telegram.me/termeh_salari" title="termeh_salari"><i
                            class="fab fa-telegram-plane"></i></a>
                    <a href="#" title="09134577500"><i class="fab fa-whatsapp"></i></a>
                    <a href="mailto:Info@TermehSalari.com" title="Info@TermehSalari.com"><i
                            class="far fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- LOADING... -->
    {{-- <div class="loader">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
       width="24px" height="24px" viewBox="0 0 24 24" style="enable-background:new 0 0 50 50;" xml:space="preserve">
      <rect x="0" y="0" width="4" height="7" fill="#333">
        <animateTransform  attributeType="xml"
          attributeName="transform" type="scale"
          values="1,1; 1,3; 1,1"
          begin="0s" dur="0.6s" repeatCount="indefinite" />
      </rect>

      <rect x="10" y="0" width="4" height="7" fill="#333">
        <animateTransform  attributeType="xml"
          attributeName="transform" type="scale"
          values="1,1; 1,3; 1,1"
          begin="0.2s" dur="0.6s" repeatCount="indefinite" />
      </rect>
      <rect x="20" y="0" width="4" height="7" fill="#333">
        <animateTransform  attributeType="xml"
          attributeName="transform" type="scale"
          values="1,1; 1,3; 1,1"
          begin="0.4s" dur="0.6s" repeatCount="indefinite" />
      </rect>
    </svg>
  </div> --}}

    <!-- JavaScript Libraries -->
    <script src="{{ asset('/hometemplate/lib/jquery/jquery.min.js') }}"></script>
    <!-- Contact Form JavaScript File -->
    <script src="{{ asset('/hometemplate/contactform/contactform.js') }}"></script>
    {{-- sweetalert --}}
    <script src="{{ asset('/storetemplate/plugins/sweetalert/sweetalert.min.js') }}"></script>
    @stack('js')
    <script src="{{ asset('/hometemplate/lib/jquery/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/superfish/hoverIntent.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/superfish/superfish.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('/hometemplate/lib/touchSwipe/jquery.touchSwipe.min.js') }}"></script>

    <!-- Template Main Javascript File -->
    <script src="{{ asset('/hometemplate/js/main.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/storetemplate/dist/js/adminlte.min.js') }}"></script>
    <!--   jqueryBarRating  -->
    <script src="{{ asset('/storetemplate/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}"></script>

    <script src="{{ asset('/storetemplate/dist/js/jquery.number.min.js') }}"></script>

    <script src="{{ asset('/storetemplate/dist/js/cart.js') }}"></script>
    <script src="{{ asset('/storetemplate/plugins/nprogress-master/nprogress.js') }}"></script>

    <script>
        NProgress.configure({
            showSpinner: false,
        });

        jQuery(document).ajaxStart(function() {
            NProgress.start();
        });

        jQuery(document).ajaxStop(function() {
            NProgress.done();
        });

        $(function() {

            $(".btn_chat_lancher").click(function() {
                if ($(".btn_chat_lancher").find("span.active").hasClass("close_me")) {
                    $(".ui-chat-container .btn_chat_lancher .close_me").removeClass("active");
                    $(".ui-chat-container .btn_chat_lancher .open_me").addClass("active");
                    $("#chat-box").fadeOut("slow");
                } else if ($(".btn_chat_lancher").find("span.active").hasClass("open_me")) {
                    $(".ui-chat-container .btn_chat_lancher .open_me").removeClass("active");
                    $(".ui-chat-container .btn_chat_lancher .close_me").addClass("active");
                    $("#chat-box").fadeIn("slow");
                }

            })

            $(".joinNewsletter").click(function() {
                event.preventDefault();
                var thiz = $(this);
                var email = $(this).parents('form').find('#email_join_newsletter');
                var url = document.location.origin + "/newsletter";
                if (email.val() == "") {
                    swal("توجه", ".لطفا ابتدا آدرس پست الکترونیک خود را وارد کنید", "error");
                    email.addClass("is-invalid").focus();
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: '<?php echo csrf_token(); ?>',
                        email: email.val(),
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.res == "error") {
                            title = "خطا  در اجرای عملیات";
                        } else if (data.res == "success") {
                            title = ".شما با موفقیت عضو خبرنامه شدید";
                            email.val("");
                        }
                        swal(title, data.message, data.res);
                    }
                });
            })

            {{-- @if (session()->has('status-join'))
        {{ dd(session('status-join')) }}
          $result = session('status-join');
          @if ($result == 1)
            swal(".شما با موفقیت عضو خبرنامه شدید", ".از حالا منتظر خبرهای جذاب ما باشید" ,"success");
          @endif
          @if ($result == 0)
            swal("خطا در اجرای عملیات ", ". آدرس پست الکترونیک تکراری می باشد" ,"erroe");
          @endif
        @endif --}}

            //--------------------------------------------------------
            $(document).on('click', 'a.deleteCartItem', function() {
                event.preventDefault();
                var thiz = $(this);
                var id = $(this).data('id');
                var model = $(this).data('model');
                var cartContainer = thiz.parents('#cartContainer');
                var cartTotalPrice = cartContainer.find('#cartTotalPrice');

                // var cartTotalPrice = thiz.parents('#cartContainer').find('#cartTotalPrice').text().replace(/,/gi,"");
                swal({
                        title: "آیا از حذف این محصول مطمئن هستید؟",
                        text: "این عملیات منجر به حذف محصول از سبد خرید شما خواهد شد.",
                        icon: "warning",
                        buttons: ["انصراف", "حذف"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('cart.deleteItem') }}",
                                data: {
                                    _token: '<?php echo csrf_token(); ?>',
                                    id: id,
                                    model: model,
                                },
                                success: function(data) {
                                    // console.log(data);
                                    if (data.status == "error") {
                                        title = "خطا  در اجرای عملیات";
                                    } else if (data.status == "success") {
                                        var itemCount = thiz.parents('.dropdown-item').find(
                                            '.cartQuantity').text();
                                        var itemPrice = thiz.parents('.dropdown-item').find(
                                            '.cartPrice').text().replace(/,/gi, "");
                                        var cartTotalPrice = thiz.parents('.dropdown-menu')
                                            .find('#cartTotalPrice').text().replace(/,/gi,
                                                "");
                                        var newPrice = parseInt(cartTotalPrice) - (parseInt(
                                            itemCount) * parseInt(itemPrice));
                                        var totalQuantity = $("#totalQuantity").text();

                                        thiz.parents('.dropdown-menu').find(
                                            '#cartTotalPrice').text($.number(newPrice));
                                        $(".shopping-cart-badge,#totalQuantity").text(
                                            parseInt(totalQuantity) - parseInt(
                                                itemCount));

                                        swal("عملیات با موفقیت انجام شد.", "", data.status);
                                        thiz.parents('.dropdown-item').fadeOut();
                                    }
                                }
                            });
                        }
                    })
            });


        }) //end
    </script>
</body>

</html>
