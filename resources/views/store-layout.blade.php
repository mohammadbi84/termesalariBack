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
  <link href="{{asset('/hometemplate/img/favicon.png')}}" rel="icon">
  <!-- <link href="{{asset('/hometemplate/img/apple-touch-icon.png')}}" rel="apple-touch-icon"> -->

  <!-- Bootstrap CSS File -->
  <link href="{{asset('/storetemplate/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- <link href="{{asset('/hometemplate/lib/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet"> -->

  <!-- Libraries CSS Files -->
  <link href="{{asset('/hometemplate/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css')}}">
  <link href="{{asset('/hometemplate/lib/font-awesome/css/all.min.css')}}" rel="stylesheet">
  <link href="{{asset('/hometemplate/lib/fontawesome-free-5.12.0/css/all.min.css')}}" rel="stylesheet">
  <!-- Main Stylesheet File -->
  <link href="{{asset('/hometemplate/css/style.css')}}" rel="stylesheet">
    <!-- sweetalert -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/sweetalert/sweetalert.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/bootstrap-rtl.min.css')}}">

  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/custom-style.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/cart.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/termehsalari.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/fonts/font-face-FD-WOL.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/nprogress-master/nprogress.css')}}">
  <link href="{{asset('/hometemplate/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('/hometemplate/lib/owlcarousel/assets/owl.theme.default.min.css')}}" rel="stylesheet">

  @stack('linkLast')
  <style type="text/css" media="screen">
    .loader{
      display: none;
    }

    .swal-modal{
      direction: rtl;
    }

    .sweet-alert h2{
      font-family: 'Vazir';
    }

    .login-icon:hover{
      color:#ef3a4e !important;
      background-color: transparent !important;
      /*border-color: white !important;*/
    }

    .ui-chat-container .btn_chat_lancher span.open_me {
      bottom: 0px;
    }

    @media (min-width:100px) and (max-width:500px) {
      #main {
        padding: 0px 20px 0 20px !important;
      }
    }

    {{--@media (min-width:100px) and (max-width:300px) {
      #main {
        padding: 0px !important;
      }
    }

    @media (min-width:300px) and (max-width:400px) {
      #main {
        padding: 0px !important;
      }
    }

    @media (min-width:400px) and (max-width: 500px) {
      
      #main {
        padding: 0px !important;
      }
    }

    @media only screen and (max-width: 500px) {
      #main {
        padding: 0px !important;
      }
    }--}}

    @media (min-width:500px) and (max-width: 700px) {
      #main {
        padding: 0px 60px 20px 60px !important;
      }
    }

    @media (min-width:700px) and (max-width: 800px) {
      #main {
        padding: 0px 140px 20px 140px !important;
      }
    }

    @media only screen and (max-width: 800px) {
      #main {
        padding: 0px 10px 20px 10px !important;
        padding-top: 92px !important;
      }
    }

    @media (min-width:100px) and (max-width:350px) {
      #header #logo{
        padding-left: 0px !important;
      }

      #header #logo h1 {
        font-size: 90% !important;
      }
    }
    @media only screen and (min-width: 1048px) {
      #main {
        padding: 0px 50px 0 50px !important;
        padding-top: 92px !important;
      }
    }
    
  </style>
</head>

<body>
	@php
    if (session()->has('cart')) {
      $cart = session('cart');
      $sum = 0;
      $list=['products'=>[],'models'=>[],'quantities'=>[]];
      foreach ($cart as $productID => $value)
      {
        foreach ($value as $model=>$data) {
          $class="App\\".$model;
          $product = $class::find($productID);
          // if ($product->visibility == 1) {
            array_push($list['products'], $product);
            array_push($list['models'], $model);
            array_push($list['quantities'], $data['quantity']);
            $sum = $sum + $data['quantity'];
          // }
        }
      }
    }
  @endphp
  <!--==========================
    Header
  ============================-->
  <header id="header" class="header">
    <div class="container-fluid">

      <nav id="nav-menu-container" class="nav-menu-container">
        <ul class="nav-menu">

          <li class="nav-item dropdown" id="TopMenuCartIcone">
  	        <a class="nav-link cart" data-toggle="dropdown" href="{{ route('cart.index') }}" >
  	          <i class="fa fa-shopping-cart"></i>
  	          @isset($cart)
  	            <span class="badge badge-danger navbar-badge shopping-cart-badge">
  	                {{ $sum }}
  	            </span>
  	          @endisset
  	        </a>
	        
  	        @isset($cart)

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">

                <div class="m-2 text-sm" id="cartHeader" style="line-height: 33px;">
                  <div class="float-right">
                    <span class="" id="totalQuantity">@if(isset($cart)){{$sum}} @else 0 @endif</span> کالا
                  </div>
                  
                  {{-- <span class="float-left"> --}}
                    <a class="btn btn-flat btn-sm btn-danger mb-2 float-left" style="border-radius: 5px 0px;" href="{{route('cart.index')}}">مشاهده سبد خرید و پرداخت</a>
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
                    @foreach($list['products'] as $key=>$item)
                      @php
                        $cartPrice = 0;
                        $cartOff = 0;
                        $p = $item->prices->where('local','تومان')->first();
                        if($p->offPrice > 0)
                        {
                          if($p->offType == 'مبلغ')
                          {
                            $cartPrice = $p->price - $p->offPrice;
                            $cartOff = $p->offPrice;
                            $price = $price + ( ($p->price - $p->offPrice) * $list['quantities'][$key]);
                            $off = $off + ($cartOff * $list['quantities'][$key]);
                          }
                          elseif($p->offType == 'درصد')
                          {
                            $cartPrice = $p->price - ($p->price * ($p->offPrice/100));
                            $cartOff = $p->price * ($p->offPrice/100);
                            $price = $price + (( $p->price - ($p->price * ($p->offPrice/100)) ) * $list['quantities'][$key]);
                            $off = $off + ($cartOff * $list['quantities'][$key]);
                          }
                        }
                        else
                        {
                          $cartPrice = $p->price;
                          $price = $price + ($p->price * $list['quantities'][$key]);
                        }
                      @endphp
                      <div class="dropdown-item" data-id="{{$item->id}}" data-moddel="{{ $list['models'][$key] }}">
                        <div class="row">
                          <div class="col-4 m-auto">
                            <img class="w-100" src="{{asset('storage/images/'.$item->images->first()->name)}}" alt="" style="vertical-align: super;">
                          </div>
                          <div class="col-8">
                            <p class="text-sm" title="{{ $item->title ." طرح ".$item->color_design->design->title." رنگ ".$item->color_design->color->color }}">
                              <a href="
                              @switch($list['models'][$key])
                                @case('Tablecloth')
                                  {{ route('tablecloth.show',[$item->id]) }}
                                {{-- @case('Shoe')
                                  {{ route('shoe.show',[$item->id]) }} --}}
                              @endswitch" data-id="{{$item->id}}" data-moddel="{{ $list['models'][$key] }}">
                              
                              {{ Str::limit($item->title ." طرح ".$item->color_design->design->title." رنگ ".$item->color_design->color->color,30)}}
                              </a>
                              
                            </p>
                          </div>
                        </div>
                        <div class="row mt-2">
                          @if($cartOff > 0)
                            <div class="col-6">
                              <span class=" text-muted text-sm">
                                <del><span class="cartOriginalPrice">{{ number_format(($p->price)) }}</span> {{ $p->local }} 
                              </span></del> 
                            </div>
                            <div class="col-6">
                              <span class="mt-2 text-muted text-sm">
                                <span class="cartPrice">{{ number_format(($cartPrice)) }}</span> {{ $p->local }} 
                              </span> 
                            </div>
                          @else
                            <div class="col-12">
                              <div class="col-6">
                                <span class="mt-2 text-muted text-sm">
                                  <span class="cartPrice">{{ number_format(($cartPrice)) }} </span> {{ $p->local }}
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
                            <a href="#" class="deleteCartItem" data-id="{{$item->id}}" data-model="{{ $list['models'][$key] }}"><i class="far fa-trash-alt float-left"></i></a>
                          </div>
                        </div>
                      </div>
                      <div class="dropdown-divider" style="clear: both;"></div>
                    @endforeach
                  {{-- @else
                    <div style="text-align: center;">
                      سبد خرید خالی است.
                    </div> --}}
                  @endisset
                </div>

                <div class="dropdown-item" id="cartFooter" style="text-align: center;" >

                  <span>
                    <small class="text-muted text-sm" sty>مبلغ قابل پرداخت : </small>
                      <strong id="cartTotalPrice">{{ number_format($price) }}</strong>
                    <small class="text-muted text-sm"> تومان</small>
                  </span>

                  @if(!(Auth::check()))
                    <a href="{{ route('login') }}" class="btn btn-danger text-sm btn-block" style="margin-top: 10px">ورود و ثبت سفارش</a>
                  @endif

                </div>{{-- cartFooter --}}


              </div>{{-- cartContainer --}}
            @endisset
	        </li>

          @if(!(Auth::check()))
            <li class="nav-item dropdown">
              <a href="{{ route('login') }}" class="btn btn-flat btn-danger login-icon" style="padding: 5px !important;"> <i class="fa fa-user"></i> ورود به حساب کاربری / ثبت نام</a>
            </li>
          @endif

	        @if (Auth::check())

		        <li class="nav-item dropdown">
		          <a class="nav-link" data-toggle="dropdown" href="#">             
		            {{Auth::user()->name}} {{Auth::user()->family}}&nbsp;<i class="fa fa-chevron-down" style="font-size: 0.5rem"></i>             
		          </a>
		          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="font-size: 0.9rem;">
		            {{-- <span class="dropdown-item dropdown-header">15 نوتیفیکیشن</span> --}}
                <div class="dropdown-divider"></div>
                <a href="{{ route('user.myOrders') }}" class="dropdown-item">
                  <i class="fa  fa-shopping-cart ml-2"></i>سفارش  های من
                </a>
		            <div class="dropdown-divider"></div>
		            <a href="{{ route("user.profile") }}" class="dropdown-item">
		              <i class="fa fa-address-card-o ml-2"></i> تنظیمات حساب کاربری
		            </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('user.changePassword') }}" class="dropdown-item">
                  <i class="fa fa-key ml-2"></i>تغییر رمز عبور
                </a>
		            <div class="dropdown-divider"></div>
		            <a href="" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
		              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		                  @csrf
		              </form>
		              <i class="fa fa-sign-out ml-2"></i> خروج
		              {{-- <span class="float-left text-muted text-sm">12 ساعت</span> --}}
		            </a>
		            {{-- <div class="dropdown-divider"></div>
		            <a href="#" class="dropdown-item">
		              <i class="fa fa-file ml-2"></i> 3 گزارش جدید
		              <span class="float-left text-muted text-sm">2 روز</span>
		            </a>
		            <div class="dropdown-divider"></div>
		            <a href="#" class="dropdown-item dropdown-footer">مشاهده همه نوتیفیکیشن</a>
		          </div> --}}
		        </li>
		    @endif


        </ul>
      </nav><!-- #nav-menu-container -->

      <div id="logo" class="logo pull-right">
        <h1>
          <a href="{{ route('homeStore.index') }}" class="scrollto" style="display: inline-block;">
            <img src="{{ asset('/hometemplate/img/logo.png') }}" alt="ترمه سالاری" title="ترمه سالاری" />
          فروشگاه ترمه سالاری
          </a>
        </h1>
        <!-- Uncomment below if you prefer to use an image logo -->
      </div>


    </div>
  </header><!-- #header -->


  <main id="main" style="padding-top: 92px;">
    <div class="container-fluid">
      @yield('main-content')
    </div>

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
            <p>ترمه سالاری یزد با بیش از یک قرن تجربه و سیصد طرح متنوع، ارائه دهنده ی معروف ترین و مرغوب ترین ترمه ها در ایران می باشد. شعار ما "ترمه سالاری برای هر ایرانی با کیفیتی عالی و قیمتی مناسب" می باشد تا همه اقشار ملت بتوانند از آن بهره مند شوند.</p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>دسترسی سریع</h4>
            <ul>
              {{-- <li><i class="ion-ios-arrow-left"></i> <a href="#intro">صفحه اصلی</a></li>
              <li><i class="ion-ios-arrow-left"></i> <a href="#services">نمایندگی ها</a></li> --}}

              <li><i class="ion-ios-arrow-left"></i> <a href="#portfolio">نمونه محصولات</a></li>
              <li><i class="ion-ios-arrow-left"></i> <a href="#call-to-action">سفارش محصول</a></li>

              <li><i class="ion-ios-arrow-left"></i> <a href="http://www.termehsalari.com/shop">ورود به فروشگاه</a></li>
              <li><i class="ion-ios-arrow-left"></i> <a href="{{ route('terms') }}">شرایط و قوانین</a></li>
              <li><i class="ion-ios-arrow-left"></i> <a href="{{ route('privacy-policy') }}">حریم خصوصی</a></li>
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
              <i class="far fa-paper-plane"></i> <i class="fab fa-whatsapp"></i>  09134577500
            </p>

            <div class="social-links">
              {{-- <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></i></a> --}}
              <a href="https://www.instagram.com/termehsalari/" class="instagram"><i class="fab fa-instagram"></i></a>
              <a href="https://telegram.me/termeh_salari" class="google-plus"><i class="fab fa-telegram-plane"></i></a>
              {{-- <a href="#" class="linkedin"><i class="fab fa-whatsapp"></i></a> --}}
              <a href="mailto:Info@TermehSalari.com" class="google-plus"><i class="far fa-envelope"></i></a>
            </div>

          </div>

          <div class="col-lg-3 col-md-6 footer-newsletter">
            <h4>خبرنامه</h4>
            <p>کاربر گرامی: لطفا برای اطلاع از تخفیف‌ها و جدیدترین‌های ترمه سالاری در خبرنامه عضو شوید.</p>
              {{-- @if(session('status-join', '0') == 1)
                <div class="sendmessage">
                  شما با موفقیت عضو خبرنامه شدید.<br>
                  از حالا منتظر خبرهای جذاب ما باشید.
                </div>
              @endif --}}
            <form action="{{route('newsletter.store')}}" method="post">
              @csrf
              <input type="email" class=" @error('email_join_newsletter') is-invalid @enderror" name="email_join_newsletter" id="email_join_newsletter" placeholder=" آدرس ایمیل خود را بنویسید" value="{{old('email_join_newsletter')}}"><input class="joinNewsletter" type="submit"  value="عضویت">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>termehsalari</strong>. All Rights Reserved
      </div>
      <div class="credits">
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
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="نام" data-rule="minlen:2" data-msg="لطفا نام خود را بنویسید ." value="{{old('name')}}" />
          <div class="validation"></div>
        </div>

        <div class="form-group">
          <input type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" maxlength="11" placeholder="شماره موبایل" data-rule="mobile" data-msg="لطفا شماره موبایل فعال خود را بنویسید ." value="{{old('mobile')}}" />
          <div class="validation"></div>
        </div>

        <div class="form-group">
          <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" rows="5" data-rule="required" data-msg="لطفا متن پیام را بنویسید ." placeholder="متن پیام">{{old('message')}}</textarea>
          <div class="validation"></div>
        </div>

        <div class="text-right"><button id="sendMessage" type="submit" class="btn btn-flat btn-outline-danger btn-sm">ارسال پیام</button></div>
      </form>

      <div class="chat-box-footer">
        <div class="social">
          <a href="https://www.instagram.com/termehsalari/" title="termehsalari"><i class="fab fa-instagram"></i></a> 
          <a href="https://telegram.me/termeh_salari" title="termeh_salari"><i class="fab fa-telegram-plane"></i></a>
          <a href="#" title="09134577500"><i class="fab fa-whatsapp"></i></a>
          <a href="mailto:Info@TermehSalari.com" title="Info@TermehSalari.com"><i class="far fa-envelope"></i></a>
        </div>
      </div>
    </div>
  </div>
  

  {{-- <div class="message-icon">
    <i class="fa fa-comments"></i>
  </div>


  <div id="message-box">
    
  </div> --}}
  <!-- Uncomment below i you want to use a preloader -->
  <!-- <div id="preloader"></div> -->
  
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
  <script src="{{asset('/hometemplate/lib/jquery/jquery.min.js')}}"></script>
  @stack('js')
  <script src="{{asset('/hometemplate/lib/jquery/jquery-migrate.min.js')}}"></script>
  <script src="{{asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/easing/easing.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/superfish/hoverIntent.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/superfish/superfish.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/wow/wow.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/waypoints/waypoints.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/counterup/counterup.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/lightbox/js/lightbox.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/touchSwipe/jquery.touchSwipe.min.js')}}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{{asset('/hometemplate/contactform/contactform.js')}}"></script> 
  <!-- sweetalert -->
  <script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
  <!-- Template Main Javascript File -->
  <script src="{{asset('/hometemplate/js/main.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('/storetemplate/dist/js/adminlte.min.js')}}"></script>
  <!-- SlimScroll -->
  <script src="{{asset('/storetemplate/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('/storetemplate/plugins/fastclick/fastclick.js')}}"></script>

  <script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
  <script src="{{asset('/storetemplate/dist/js/jquery.number.min.js')}}"></script>
  <script src="{{asset('/storetemplate/plugins/nprogress-master/nprogress.js')}}"></script>
  <script>
    NProgress.configure({
      showSpinner: false,
    });

    jQuery( document ).ajaxStart(function() {
      NProgress.start();
    });

    jQuery( document ).ajaxStop(function() {
      NProgress.done();
    });

    $(function () {

      $(".btn_chat_lancher").click(function(){
        if($(".btn_chat_lancher").find("span.active").hasClass("close_me")){
          $(".ui-chat-container .btn_chat_lancher .close_me").removeClass("active");
          $(".ui-chat-container .btn_chat_lancher .open_me").addClass("active");
          $("#chat-box").fadeOut("slow");
        }
        else if($(".btn_chat_lancher").find("span.active").hasClass("open_me")){
          $(".ui-chat-container .btn_chat_lancher .open_me").removeClass("active");
          $(".ui-chat-container .btn_chat_lancher .close_me").addClass("active");
          $("#chat-box").fadeIn("slow");
        }
        
      })
      
    	$("#tableclothsCarousel").owlCarousel({
        dots: false,
        nav:true,
        rtl: true,
        loop: true,
        items: 3,
        autoplay: true,
        autoplayTimeout: 3000,
        smartSpeed:450, 
        // navText:['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill: none;stroke-width: 1px;stroke: #d7d7d7;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>','<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #d7d7d7;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
        navText:['<i class="fa fa-chevron-right"></i>','<i class="fa fa-chevron-left"></i>'],
        //navText:['<a class="owl-prev" href="#introCarousel" role="button" data-slide="prev"><span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span><span class="sr-only">قبلی</span></a>','<a class="owl-next" href="#introCarousel" role="button" data-slide="next"><span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span><span class="sr-only">بعدی</span></a>'],
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
      });

      $(".joinNewsletter").click(function(){
        event.preventDefault();
        var thiz = $(this);
        var email = $(this).parents('form').find('#email_join_newsletter');
        var url = document.location.origin + "/newsletter";
        if(email.val() == "")
        {
          swal("توجه",".لطفا ابتدا آدرس پست الکترونیک خود را وارد کنید","error");
          email.addClass("is-invalid").focus();
          return false;
        }
        $.ajax({
          type:'POST',
          url: url,
          data: {
            _token: '<?php echo csrf_token() ?>',
              email: email.val(),
          },
          success:function(data){
            // console.log(data);
            if(data.res == "error")
            {
              title = "خطا  در اجرای عملیات" ;
            }
            else if(data.res == "success")
            {
              title = ".شما با موفقیت عضو خبرنامه شدید" ;
              email.val("");
            }
            swal(title, data.message,data.res);
          }
        });
      })
      

      {{-- @if(session()->has('status-join'))
        swal(".شما با موفقیت عضو خبرنامه شدید", ".از حالا منتظر خبرهای جذاب ما باشید" ,"success");
      @endif --}}

    //--------------------------------------------------------
      $(document).on( 'click', 'a.deleteCartItem',function(){
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
           buttons: ["انصراف","حذف"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if(willDelete) {
            $.ajax({
              type:'POST',
              url: "{{ route('cart.deleteItem') }}",
              data: {
                _token: '<?php echo csrf_token() ?>',
                  id: id,
                  model: model,
              },
              success:function(data){
                // console.log(data);
                if(data.status == "error")
                {
                  title = "خطا  در اجرای عملیات" ;
                }
                else if(data.status == "success")
                {
                  var itemCount = thiz.parents('.dropdown-item').find('.cartQuantity').text();
                  var itemPrice = thiz.parents('.dropdown-item').find('.cartPrice').text().replace(/,/gi,"");
                  var cartTotalPrice = thiz.parents('.dropdown-menu').find('#cartTotalPrice').text().replace(/,/gi,"");
                  var newPrice = parseInt(cartTotalPrice) - (parseInt(itemCount) * parseInt(itemPrice));
                  var totalQuantity = $("#totalQuantity").text();

                  thiz.parents('.dropdown-menu').find('#cartTotalPrice').text($.number(newPrice));
                  $(".shopping-cart-badge,#totalQuantity").text(parseInt(totalQuantity) - parseInt(itemCount));

                  swal("عملیات با موفقیت انجام شد.", "",data.status);
                  thiz.parents('.dropdown-item').fadeOut();
                }
              }
            });
          }
        })
      });

    });//end
  </script>
</body>
</html>
{{-- https://telegram.me/ --}}