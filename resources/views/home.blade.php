<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>ترمه سالاری | شکوهی از هنر سه نسل</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <meta name="_token" content="{{ csrf_token() }}">
  <!-- Favicons -->
  <link href="{{asset('/hometemplate/img/favicon.png')}}" rel="icon">
  <link href="{{asset('/hometemplate/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  {{-- <link href="{{asset('/hometemplate/css/font.css')}}" rel="stylesheet"> --}}
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/fonts/font-face-FD-WOL.css')}}">
  <!-- Bootstrap CSS File -->
  <link href="{{asset('/storetemplate/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  {{-- <link href="{{asset('/hometemplate/lib/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet"> --}}

  <!-- Libraries CSS Files -->
  <link href="{{asset('/hometemplate/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
  {{-- <link href="{{asset('/hometemplate/lib/font-awesome/css/all.min.css')}}" rel="stylesheet"> --}}
  <link href="{{asset('/hometemplate/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('/hometemplate/lib/fontawesome-free-5.12.0/css/all.min.css')}}" rel="stylesheet">
  <link href="{{asset('/hometemplate/lib/animate/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('/hometemplate/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('/hometemplate/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{{asset('/hometemplate/css/style.css')}}" rel="stylesheet">
    <!-- sweetalert -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/sweetalert/sweetalert.css')}}">
  <style type="text/css" media="screen">

    .sweet-alert{
      direction: rtl;
    }

    .sweet-alert h2{
      font-family: 'Vazir';
    }

    #main{
      padding: 0px !important;
    }

    .nav-menu > li {
      margin-left: 0px !important;
    }

    .nav-menu>li>a {
      padding: 10px !important;
    }
    .storeLink{
      background-color: #18d26e;
      padding: 10px 6px 10px 6px !important;
    }

    .storeLink:hover{
      color: black !important;
    }

    .storeLink>i{
      transform: scaleX(-1);
      -webkit-transform: scaleX(-1);
      -moz-transform: scaleX(-1);
    }
    .container-fluid {
      padding-right: 7.5px !important;
      padding-left: 7.5px !important;
    }

    /*#mobile-nav-toggle {
      right: 25px !important;
    }*/

    /*body.mobile-nav-active #mobile-nav {
      right: 35px;
    }*/

    /*#mobile-nav-toggle {
      right: 0;
    }*/

    #mobile-nav ul li>a {
      padding: 10px 15px 10px 22px;
    }

    @media only screen and (max-width: 900px) {
      #testimonials .testimonial-item .testimonial-img {
        width: 80%;
      }
    }

    @media only screen and (max-width: 500px){
      #mobile-nav-toggle {
        right: -10px !important;
      }
      body.mobile-nav-active #mobile-nav {
        right: 0px;
      }
    }


    /*.container {
      width: 100%;
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }*/

  </style>
</head>

<body>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container-fluid">

      <div id="logo" class="pull-left">
        <h1>
          <a href="#intro" class="scrollto" style="display: inline-block;">
            <img src="{{ asset('/hometemplate/img/logo.png') }}" alt="ترمه سالاری" title="ترمه سالاری" />
          ترمه سالاری
          </a>
        </h1>
        <!-- Uncomment below if you prefer to use an image logo -->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          {{-- <li><a href="#contact">تماس با ما</a></li> --}}
          {{-- <li><a href="#testimonials">حقوق مالکیت معنوی</a></li> --}}
          {{-- <li><a href="#clients">مشتریان</a></li> --}}
          {{-- <li><a href="#skills">نشان اصالت</a></li> --}}
          {{-- <li><a href="#portfolio">نمونه محصولات</a></li>  --}}
          {{-- <li><a href="#call-to-action">سفارش محصول</a></li> --}}
          {{-- <li><a href="#services">نمایندگی ها</a></li> --}}
          {{-- <li><a href="#about">رسالت ما</a></li> --}}
          {{-- <li><a href="#family">خاندان ترمه سالاری</a></li> --}}
          {{-- <li class="menu-active"><a href="#intro">اسلایدشو</a></li> --}}
          {{-- <li><a class="storeLink rounded" href="http://www.termehsalari.com/shop">فروشگاه <i class="fa fa-shopping-cart"></i></a></li> --}}


          <li><a href="#contact">تماس با ما</a></li>
          <li><a href="#clients">مشتریان</a></li>
          <li><a href="#services">نمایندگی ها</a></li>
          <li><a href="#call-to-action">سفارش محصول</a></li>
          <li><a href="#portfolio">نمونه محصولات</a></li>
          <li><a class="storeLink rounded" href="http://www.termehsalari.com/store">فروشگاه <i class="fa fa-shopping-cart"></i></a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">
    <div class="intro-container">
      <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

        <ol class="carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <div class="carousel-item active">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/1.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/2.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/3.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt omnis iste natus error sit voluptatem accusantium.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/4.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/5.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/6.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/7.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/8.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/9.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/10.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/11.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/12.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/13.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/14.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/15.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/16.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/17.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/18.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-background"><img src="{{asset('/hometemplate/img/intro-carousel/19.jpg')}}" alt=""></div>
            <div class="carousel-container">
              <div class="carousel-content">
                <h2><img src="{{asset('/hometemplate/img/termehsalari.png')}}" alt="termeh salari"></h2>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                <a href="http://www.termehsalari.com/store" class="btn-get-started scrollto">فروشگاه ترمه سالاری</a>
              </div>
            </div>
          </div>


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

    <!--==========================
      Featured Services Section
    ============================-->
    <section id="featured-services">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 box">
            <i class=""><img src="{{asset('/hometemplate/img/warranty.png')}}"></i>
            <h4 class="title"><a href="">گارانتی محصولات</a></h4>
            <!-- <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p> -->
          </div>

          <div class="col-lg-4 box box-bg">
            <i class=""><img src="{{asset('/hometemplate/img/varity.png')}}"></i>
            <h4 class="title"><a href="">تنوع طرح و رنگ</a></h4>
            <!-- <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p> -->
          </div>

          <div class="col-lg-4 box">
            <i class=""><img src="{{asset('/hometemplate/img/quality.png')}}"></i>
            <h4 class="title"><a href="">کیفییتی بی نظیر</a></h4>
            <!-- <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p> -->
          </div>

        </div>
      </div>
    </section><!-- #featured-services -->

    <!--==========================
      Family Section
    ============================-->
    <section id="family">
      <div class="container">

        <header class="section-header">
          <h3>خاندان ترمه سالاری</h3>
          <p></p>
        </header>

        <div class="row about-cols">

          <div class="col-md-4 wow fadeInUp">
            <div class="about-col">
              <div class="img">
                <img src="{{asset('/hometemplate/img/about-mission.jpg')}}" alt="" class="img-fluid">
                {{-- <div class="icon"><i class="ion-ios-speedometer-outline"></i></div> --}}
              </div>
              <h2 class="title"><a href="#">آسید علی سالاری</a></h2>
              <p>
                  ترمه بافی در خاندان سالاری حدود 90 سال پیش بدست مرحوم آسیدعلی سالاری ملقب به آسیدعلی سید حیدر آغاز شد. ترمه ای که در آن زمان بافته می شد نوعی بقچه و سوزنی حاشیه دار بود که نام خود بافنده در آن بافت شده است.
                  <br><br><br><br>
              </p>
            </div>
          </div>

          <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="about-col">
              <div class="img">
                <img src="{{asset('/hometemplate/img/about-plan.jpg')}}" alt="" class="img-fluid">
                {{-- <div class="icon"><i class="ion-ios-list-outline"></i></div> --}}
              </div>
              <h2 class="title"><a href="#">آسید علی اکبر سالاری</a></h2>
              <p>
                نسل دومی این خاندان آسیدعلی اکبر بود که در محله چهارمنار مشغول بکار شد و سپس تولید خود را با افزودن دستگاهها تا 6 دستگاه دستباف و با 12 کارگر زن در محله سجادیه ادامه داد. این روند تا سال 1348 بصورت ترمه دستی باروش بافت سنتی ادامه داشت و پس از آن با زحمات بسیار زیاد بافت ترمه به صورت ماشینی درآمد ولی با همان کیفیت ترمه دستی تولید و بافت انجام می گرفت.
              </p>
            </div>
          </div>

          <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="about-col">
              <div class="img">
                <img src="{{asset('/hometemplate/img/about-vision.jpg')}}" alt="" class="img-fluid">
                {{-- <div class="icon"><i class="ion-ios-eye-outline"></i></div> --}}
              </div>
              <h2 class="title"><a href="#">آسید حیدر سالاری</a></h2>
              <p>نسل سوم از سال 1361 فعالیت گذشتگان را ادامه داد ولی با این تفاوت که روز به روز تولیداتی با طرحها و رنگ های متنوع و جدید به بازار عرضه نمود و با بهره گیری از تکنولوژی جدید و دستگا های مدرن روز پیوسته به تعداد طرحها رنگها و جذابیت ترمه های تولیدی خود افزوده است آنچنان که توانسته است علاوه بر مشتریان داخلی نظر گردشگران دیگر کشورها را نیز به خود جلب و آنان را در زمره خریداران خود قرار دهد.
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- #Family -->

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
      <div class="container">
        <header class="section-header">
          <h3>رسالت ترمه سالاری</h3>
          <p>ترمه نوعی از منسوجات سنتی ایران است که از گذشته های بسیار دور در ایران تولید می شده است. ترمه همانند فرش دست بافت دارای تار و پود است که پود در پشت پارچه ترمه به صورت آزاد قرار می گیرد. ترمه اصیل ایران لاکی یا عنابی رنگ است و طرح بته جقه یا سرو خمیده جزء لاینفک آن است. امروزه پارچه ترمه در طرح ها و رنگ های متنوع بافته می شود. رومیزی ترمه (مربع، رانر و سری رانر)، کوسن، سجاده و جانماز ترمه، تابلو ترمه، روتختی ترمه، پشتی ترمه، لحاف ترمه، پرده ترمه، رومبلی ترمه، کتاب های نفیس ترمه، صندوقچه ترمه، جعبه جواهرات ترمه، کیسه شاباش ترمه، لباس، کیف و کفش ترمه، کراوات ترمه و رومیزی های ترمه سرمه دوزی شده از جمله مهم ترین محصولات تولید شده با پارچه ترمه می باشند. در سال های اخیر با توجه به ظرافت بافت ترمه، پارچه ترمه و رومیزی های ترمه تنها در استان یزد بافته و تولید می شوند. ترمه سالاری یزد با بیش از یک قرن تجربه و سیصد طرح متنوع، ارائه دهنده ی معروف ترین و مرغوب ترین ترمه ها در ایران می باشد.
          رسالت اصلی ترمه سالاری پاسداری از میراث نسل های گذشته خویش و ادامه راه ایشان جهت تکمیل و هر چه بهتر شدن کیفیت این پارچه سنتی بوده تا بتواند افتخاری برای آیندگان خود باشد. شعار ما "ترمه سالاری برای هر ایرانی با کیفیتی عالی و قیمتی مناسب" می باشد تا همه اقشار ملت بتوانند از آن بهره مند شوند. طرح های بی نظیر و رنگ آمیزی خاص ترمه های تولیدی ما تنها با مقایسه و لمس دیگر ترمه ها مشهود خواهد شد که به کیفیت و لطافت و رنگ آمیزی کم نظیر می باشد.</p>
        </header>
      </div>
    </section><!-- #about -->

    <!--==========================
      Services Section
    ============================-->
    <section id="services">
      <div class="container">

        <header class="section-header wow fadeInUp">
          <h3>نمایندگی ها</h3>
          <p>لطفاً جهت اطلاع از شرایط اخذ نمایندگی با تلفن  <strong style="color:#18d26e ;">09134577500</strong> تماس بگیرید .</p>
        </header>

        <div class="row">

          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">تهران</a></h4>
            <h5>آقای صفائی</h5>
            <p class="description">
              بازار کفاش ها - خانه ترمه ایران
            </p>
          </div>
          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">تهران</a></h4>
            <h5>آقای میرزایی</h5>
            <p class="description">مینی سیتی - شهرک شهید محلاتی </p>
          </div>
          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">مشهد</a></h4>
            <h5>آقای شفاجو</h5>
            <p class="description">چهارراه خسروی - پاساژ جواد - طبقه اول 05132253572</p>
          </div>
          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">رفسنجان</a></h4>
            <h5>آقای عربی</h5>
            <p class="description">خ شهدا پاساژ بزرگ شهر طبقه زیرین اولین مغازه سمت راست  ترمه سرای عربی 03434265741</p>
          </div>

          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">اصفهان</a></h4>
            <h5>آقای شجائی</h5>
            <p class="description">میدان نقش جهان</p>
          </div>
          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">کرمان</a></h4>
            <h5>آقای نیک نفس</h5>
            <p class="description">سه راهی شمال جنوبی - جنب مسجد شیخها - ترمه ابریشم 03432239460</p>
          </div>
          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">قزوین</a></h4>
            <h5>خانم حاتمی</h5>
            <p class="description">خیابان فردوسی - بعد از چهارراه بوعلی - جنب تالار فرهنگیان - ترمه سیان 02833359101</p>
          </div>
          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">یاسوج</a></h4>
            <h5>خانم کیانوش</h5>
            <p class="description">خیابان30 متری معاد</p>
          </div>
          <div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            <h4 class="title"><a href="#services">نجف آباد اصفهان</a></h4>
            <h5>خانم اکبری</h5>
            <p class="description">مجتمع تجاری فردوسی - صنایع ترمه</p>
          </div>

        </div>

      </div>
    </section><!-- #services -->

    <!--==========================
      Team Section
    ============================-->
    <section id="team">
      <div class="container">
        <div class="section-header wow fadeInUp">
          <h3>نمایندگی های برگزیده استان یزد</h3>
          <p></p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 wow fadeInUp">
            <div class="member">
              <img src="{{asset('/hometemplate/img/team-1.jpg')}}" class="img-fluid" alt="">
              <div class="member-info">
                {{-- <div class="member-info-content">
                  <h4>Walter White</h4>
                  <span>Chief Executive Officer</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="member">
              <img src="{{asset('/hometemplate/img/team-2.jpg')}}" class="img-fluid" alt="">
              <div class="member-info">
                {{-- <div class="member-info-content">
                  <h4>Sarah Jhonson</h4>
                  <span>Product Manager</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
            <div class="member">
              <img src="{{asset('/hometemplate/img/team-3.jpg')}}" class="img-fluid" alt="">
              <div class="member-info">
                {{-- <div class="member-info-content">
                  <h4>William Anderson</h4>
                  <span>CTO</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
            <div class="member">
              <img src="{{asset('/hometemplate/img/team-4.jpg')}}" class="img-fluid" alt="">
              <div class="member-info">
                {{-- <div class="member-info-content">
                  <h4>Amanda Jepson</h4>
                  <span>Accountant</span>
                  <div class="social">
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-google-plus"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- #team -->

    <!--==========================
      Call To Action Section
    ============================-->
    <section id="call-to-action" class="wow fadeIn">
      <div class="container text-center">
        <h3>سفارش محصول</h3>
        <p>
          <img src="{{asset('/hometemplate/img/by-persone.png')}}" alt="">
          <b>خرید حضوری:</b> فروشگاه ها و شعب منسوجات ترمه سالاری همه روزه به جز روزهای تعطیل از ساعت 9 الی 13 و 17 الی 21 پذیرای حضور گرم شما مشتریان عزیز خواهد بود.</p>
        <p>
          <img src="{{asset('/hometemplate/img/by-phone.png')}}" alt="">
          <b>سفارش تلفنی:</b>
         شما مشتریان گرامی می توانید از طریق تماس با شماره های 36260637-035 (فروشگاه شماره یک، آقای علیرضا رادفر) و 36223880-035 (فروشگاه شماره دو، آقای منصور فراقی) محصول انتخابی خویش را سفارش دهید. چنانچه امکان بازدید حضوری برای شما میسر نمی باشد می توانید درخواست مشاوره، ارسال کاتالوگ محصولات و نمونه کارها نموده تا با هماهنگی قبلی کارشناسان ما خدمت شما حضور یابند و به سلیقه شما طراحی مربوطه صورت پذیرفته تا محصول نهایی در کوتاه ترین زمان ممکن تحویل شما عزیزان گردد.</p>
        <p>
          <img src="{{asset('/hometemplate/img/online.png')}}" alt="">
          <b>خرید آنلاین:</b>
        وارد فروشگاه اینترنتی ما شوید و از بین دنیایی از طرح و رنگ، محصول با کیفیت مورد نظر خود را سفارش و در سریع ترین زمان ممکن آن را دریافت کنید.</p>
        <a class="cta-btn" href="http://www.termehsalari.com/store">ورود به فروشگاه  اینترنتی ترمه سالاری</a>
      </div>
    </section><!-- #call-to-action -->

    <!--==========================
      Facts Section
    ============================-->
    <!-- <section id="facts"  class="wow fadeIn">
      <div class="container">

        <header class="section-header">
          <h3>Facts</h3>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
        </header>

        <div class="row counters">

  				<div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">274</span>
            <p>Clients</p>
  				</div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">421</span>
            <p>Projects</p>
  				</div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">1,364</span>
            <p>Hours Of Support</p>
  				</div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">18</span>
            <p>Hard Workers</p>
  				</div>

  			</div>

        <div class="facts-img">
          <img src="" alt="" class="img-fluid">
        </div>

      </div>
    </section> --><!-- #facts -->

    <!--==========================
      Portfolio Section
    ============================-->
    <section id="portfolio"  class="section-bg" >
      <div class="container">

        <header class="section-header">
          <h3 class="section-title">نمونه محصولات</h3>
        </header>

        <div class="row">
          <div class="col-lg-12">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">همه</li>
              <!-- <li data-filter=".filter-bag">کیف</li>
              <li data-filter=".filter-shoe">کفش</li> -->
              <li data-filter=".filter-tablecloth">رومیزی</li>
              <li data-filter=".filter-sermeh">سرمه دوزی</li>
              <li data-filter=".filter-bedCover">روتختی</li>

            </ul>
          </div>
        </div>

        <div class="row portfolio-container">

          <!-- <div class="col-lg-4 col-md-6 portfolio-item filter-bag fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bag-1.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bag-1.jpg')}}" data-lightbox="نمونه محصول" data-title="کیف مجلسی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کیف مجلسی</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bag fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bag-2.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bag-2.jpg')}}" data-lightbox="نمونه محصول" data-title="کیف  مجلسی دسته کوتاه" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کیف  مجلسی دسته کوتاه</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bag fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bag-4.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bag-4.jpg')}}" data-lightbox="نمونه محصول" data-title="کیف رودوشی رسمی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کیف رودوشی رسمی</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bag fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bag-5.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bag-5.jpg')}}" data-lightbox="نمونه محصول" data-title="کیف دستی مجلسی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کیف دستی مجلسی</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bag fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bag-6.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bag-6.jpg')}}" data-lightbox="نمونه محصول" data-title="کوله پشتی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کوله پشتی</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bag fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bag-7.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bag-7.jpg')}}" data-lightbox="نمونه محصول" data-title="کیف پول" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کیف پول</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-shoe fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/shoe-1.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/shoe-1.jpg')}}" data-lightbox="نمونه محصول" data-title="کفش پاشنه بلند مجلسی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کفش پاشنه بلند مجلسی</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-shoe fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/shoe-2.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/shoe-2.jpg')}}" data-lightbox="نمونه محصول" data-title="کفش پاشنه بلند مجلسی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کفش پاشنه بلند مجلسی</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-shoe fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/shoe-3.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/shoe-3.jpg')}}" data-lightbox="نمونه محصول" data-title="کفش پاشنه دار رسمی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کفش پاشنه دار رسمی</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-shoe fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/shoe-4.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/shoe-4.jpg')}}" data-lightbox="نمونه محصول" data-title="کفش لژ دار راحتی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کفش لژ دار راحتی</p>
              </div>
            </div>
          </div>

         <div class="col-lg-4 col-md-6 portfolio-item filter-shoe fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/shoe-6.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/shoe-6.jpg')}}" data-lightbox="نمونه محصول" data-title="کفش لژ دار روزانه" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کفش لژ دار روزانه</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-shoe fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/shoe-7.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/shoe-7.jpg')}}" data-lightbox="نمونه محصول" data-title="کفش  پاشنه بلند مجلسی" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>کفش  پاشنه بلند مجلسی</p>
              </div>
            </div>
          </div> -->

          <div class="col-lg-4 col-md-6 portfolio-item filter-sermeh fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/sermeh-1.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/sermeh-1.jpg')}}" class="link-preview" data-lightbox="نمونه محصول" data-title="رومیزی 4 تکه طرح سیمرغ" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 3</a></h4> --}}
                <p>رومیزی 4 تکه طرح سیمرغ</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-sermeh fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/sermeh-2.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/sermeh-2.jpg')}}" data-lightbox="نمونه محصول" data-title="سرویس 5 تکه پردیس" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>سرویس 5 تکه پردیس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-sermeh fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/sermeh-3.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/sermeh-3.jpg')}}" class="link-preview" data-lightbox="نمونه محصول" data-title="سرویس 5 تکه پرنیان" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">Web 3</a></h4> --}}
                <p>سرویس 5 تکه پرنیان</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-sermeh fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/sermeh-4.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/sermeh-4.jpg')}}" class="link-preview" data-lightbox="نمونه محصول" data-title="رومیزی مربع طرح الماس" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 2</a></h4> --}}
                <p>رومیزی مربع طرح الماس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-sermeh fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/sermeh-5.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/sermeh-5.jpg')}}" class="link-preview" data-lightbox="نمونه محصول" data-title="رومیزی مربع طرح پردیس" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">Card 2</a></h4> --}}
                <p>رومیزی مربع طرح پردیس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-sermeh fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/sermeh-6.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/sermeh-6.jpg')}}" class="link-preview" data-lightbox="نمونه محصول" data-title="رومیزی مربع طرح فرشته" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">Web 2</a></h4> --}}
                <p>رومیزی مربع طرح فرشته</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bedCover fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bedcover-1.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bedcover-1.jpg')}}" class="link-preview" data-lightbox="نمونه محصول" data-title="روتختی دونفره طرح سیمرغ" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">Card 3</a></h4> --}}
                <p>روتختی دونفره طرح سیمرغ</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bedCover fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bedcover-2.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bedcover-2.jpg')}}" class="link-preview" data-lightbox="نمونه محصول" data-title="روتختی دونفره طرح پارس" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">Web 1</a></h4> --}}
                <p>روتختی دونفره طرح پارس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bedCover fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bedcover-3.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bedcover-3.jpg')}}" data-lightbox="نمونه محصول" data-title="رو تختی دونفره طرح رزبرگ" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رو تختی دونفره طرح رزبرگ</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bedCover fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bedcover-4.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bedcover-4.jpg')}}" data-lightbox="نمونه محصول" data-title="روتختی زرشکی طرح پرنیان" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>روتختی زرشکی طرح پرنیان</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bedCover fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bedcover-5.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bedcover-5.jpg')}}" data-lightbox="نمونه محصول" data-title="روتختی قرمز طرح پردیس" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>روتختی قرمز طرح پردیس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-bedCover fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/bedcover-6.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/bedcover-6.jpg')}}" data-lightbox="نمونه محصول" data-title="روتختی طلایی طرح پردیس" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>روتختی طلایی طرح پردیس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-1.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-1.jpg')}}" data-lightbox="نمونه محصول" data-title="رومیزی مربع طرح الناز" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رومیزی مربع طرح الناز</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-2.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-2.jpg')}}" data-lightbox="نمونه محصول" data-title="رومیزی مربع طرح سروناز" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رومیزی مربع طرح سروناز</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-3.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-3.jpg')}}" data-lightbox="نمونه محصول" data-title="رومیزی مربع طرح رزبرگ" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رومیزی مربع طرح رزبرگ</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-6.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-6.jpg')}}" data-lightbox="نمونه محصول" data-title="رومیزی گرد طرح الماس" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رومیزی گرد طرح الماس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-8.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-8.jpg')}}" data-lightbox="نمونه محصول" data-title="رومیزی گرد طرح پردیس" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رومیزی گرد طرح پردیس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-9.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-9.jpg')}}" data-lightbox="نمونه محصول" data-title="رومیزی گرد طلایی طرح پرنیان" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رومیزی گرد طلایی طرح پرنیان</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-10.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-10.jpg')}}" data-lightbox="نمونه محصول" data-title="رانر آبی طرح پرنیان" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رانر آبی طرح پرنیان</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-11.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-11.jpg')}}" data-lightbox="نمونه محصول" data-title="رانر طلایی طرح پارس" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رانر طلایی طرح پارس</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-12.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-12.jpg')}}" data-lightbox="نمونه محصول" data-title="رانر حاشیه قرمز طرح سیمرغ" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>رانر حاشیه قرمز طرح سیمرغ</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-13.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-13.jpg')}}" data-lightbox="نمونه محصول" data-title="ست رانر 3 تکه طرح رزبرگ" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>ست رانر 3 تکه طرح رزبرگ</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-16.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-16.jpg')}}" data-lightbox="نمونه محصول" data-title="ست رانر 3 تکه طرح زرین" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>ست رانر 3 تکه طرح زرین</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-tablecloth fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{asset('/hometemplate/img/portfolio/tablecloth-17.jpg')}}" class="img-fluid" alt="">
                <a href="{{asset('/hometemplate/img/portfolio/tablecloth-17.jpg')}}" data-lightbox="نمونه محصول" data-title="ست رانر 3 تکه طرح پرنیان" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
              </figure>

              <div class="portfolio-info">
                {{-- <h4><a href="#">App 1</a></h4> --}}
                <p>ست رانر 3 تکه طرح پرنیان</p>
              </div>
            </div>
          </div>



        </div>

      </div>
    </section><!-- #portfolio -->

    <!--==========================
      Skills Section
    ============================-->
    <section id="skills">
      <div class="container">

        <header class="section-header">
          <h3>نشان اصالت محصول</h3>
          <p>جهت اطمینان از اصل بودن کالای خریداری شده و اصالت ترمه و ضمانت محصولات ضمن خرید از فروشگاه های معتبر به نشان ترمه سالاری بر روی محصولات توجه فرمایید.</p>
          <img src="{{asset('/hometemplate/img/original.png')}}" alt="" >
        </header>

        </div>

      </div>
    </section>

    <!--==========================
      Clients Section
    ============================-->
    <section id="clients" class="wow fadeInUp">
      <div class="container">

        <header class="section-header">
          <h3>مشتریان ما</h3>
          <p>فعالیت های ترمه سالاری  تنها محدود به مناطق و شهرهای داخل کشورمان نیست.مفتخریم که عنوان کنیم محصولات ترمه سالاری را به کشورهای <strong> آلمان، سوئد، سنگاپور و مالزی </strong> صادر کرده ایم.

            امید است با تلاش فراوان و همچنین کمک خداوند متعال بتوانیم ، بهترین محصولات را در اختیار خریداران محترم قرار بدهیم تا برای آبادانی کشور قدمی برداشته باشیم.
          </p>
        </header>

        <div class="owl-carousel clients-carousel">
          <img src="{{asset('/hometemplate/img/clients/client-1.png')}}" alt="">
          <img src="{{asset('/hometemplate/img/clients/client-2.png')}}" alt="">
          <img src="{{asset('/hometemplate/img/clients/client-3.png')}}" alt="">
          <img src="{{asset('/hometemplate/img/clients/client-4.png')}}" alt="">
          <img src="{{asset('/hometemplate/img/clients/client-5.png')}}" alt="">
          <img src="{{asset('/hometemplate/img/clients/client-6.png')}}" alt="">
          {{-- <img src="{{asset('/hometemplate/img/clients/client-7.png')}}" alt=""> --}}
          {{-- <img src="{{asset('/hometemplate/img/clients/client-8.png')}}" alt=""> --}}
        </div>

      </div>
    </section><!-- #clients -->

    <!--==========================
      Clients Section
    ============================-->
    <section id="testimonials" class="section-bg wow fadeInUp">
      <div class="container">

        <header class="section-header">
          <h3>حقوق  مالکیت معنوی</h3>
          <p>تمام طرح های تولیدی ترمه سالاری دارای گواهی نامه ثبت مالکیت معنوی بوده و هرگونه کپی برداری از آن پیگرد قانونی دارد.</p>
        </header>

        <div class="owl-carousel testimonials-carousel">

          <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/1.jpg')}}" class="testimonial-img" alt="نام طرح : خاتون">
            <h3>نام طرح : خاتون</h3>
          </div>

          <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/2.jpg')}}" class="testimonial-img" alt="نام طرح : پردیس">
            <h3>نام طرح : پردیس</h3>
          </div>

          <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/3.jpg')}}" class="testimonial-img" alt="نام طرح : رزبرگ">
            <h3>نام طرح : رزبرگ</h3>
          </div>

          <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/4.jpg')}}" class="testimonial-img" alt="نام طرح : سیمرغ">
            <h3>نام طرح : صدف</h3>
          </div>

          <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/5.jpg')}}" class="testimonial-img" alt="نام طرح : سیمرغ">
            <h3>نام طرح : سیمرغ</h3>
          </div>

           <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/6.jpg')}}" class="testimonial-img" alt="نام طرح : گلنار">
            <h3>نام طرح : گلنار</h3>
          </div>

           <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/7.jpg')}}" class="testimonial-img" alt="نام طرح : لیل و مجنون">
            <h3>نام طرح : لیل و مجنون</h3>
          </div>

           <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/8.jpg')}}" class="testimonial-img" alt="نام طرح : پارس">
            <h3>نام طرح : پارس</h3>
          </div>

           <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/9.jpg')}}" class="testimonial-img" alt="نام طرح : نگین">
            <h3>نام طرح : نگین</h3>
          </div>

           <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/10.jpg')}}" class="testimonial-img" alt="نام طرح : شاهی">
            <h3>نام طرح : شاهی</h3>
          </div>

           <div class="testimonial-item">
            <img src="{{asset('/hometemplate/img/certificate/11.jpg')}}" class="testimonial-img" alt="نام طرح : پرنیان">
            <h3>نام طرح : پرنیان</h3>
          </div>

        </div>

      </div>
    </section><!-- #testimonials -->

    <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="section-bg wow fadeInUp">
      <div class="container">

        <div class="section-header">
          <h3>تماس با ما</h3>
          <p>با  ما در ارتباط باشید. از نظرات و پیشنهادات شما عزیزان استقبال می کنیم .</p>
        </div>

        <div class="row contact-info">
          <div class="col-md-4">
            <div class="contact-address">
              <i class="fas fa-map-marker-alt"></i>
              <h3>آدرس</h3>
              <address>فروشگاه مرکزی : میدان امیرچقماق</address>
              <address>فروشگاه شماره2 : جنب شیرینی سازی حاج خلیفه رهبر سرای ترمه</address>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-phone">
              <i class="fas fa-phone-volume"></i>
              <h3>تلفن تماس</h3>
              <p>فروشگاه مرکزی : 36260637 - 035</p>
              <p>فروشگاه شماره2 :  36223880 - 035</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-email">
              <i class="fas fa-comment"></i>
              <h3>ارتباط در فضای مجازی</h3>
              <p>info@termehsalari.com<i class="far fa-envelope"></i></p>
              <p>termehsalari<i class="fab fa-instagram"></i></p>
              <p>09134577500<i class="far fa-paper-plane"></i><i class="fab fa-whatsapp"></i></p>
            </div>
          </div>
        </div>

        <div class="form">
          <form action="{{ route('message.store') }}" method="post" role="form" class="contactForm">
            @csrf

            <div class="form-row">
              <div class="form-group col-md-6">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="نام" data-rule="minlen:2" data-msg="لطفا نام خود را بنویسید ." value="{{old('name')}}" />
                <div class="validation"></div>
              </div>

              {{-- <div class="form-group col-md-6">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="پست الکترونیک" data-rule="email" data-msg="لطفا  پست الکترونیک معتبر خود را بنویسید" value="{{old('email')}}" />
                <div class="validation"></div>
              </div> --}}

              <div class="form-group col-md-6">
                <input type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" maxlength="11" placeholder="شماره موبایل" data-rule="mobile" data-msg="لطفا شماره موبایل فعال خود را بنویسید ." value="{{old('mobile')}}" />
                <div class="validation"></div>
              </div>
            </div>

            {{-- <div class="form-group">
              <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject" placeholder="عنوان پیام" data-rule="minlen:4" data-msg="لطفا عنوان پیام که شامل حداقل 8 کاراکتر باشد را بنویسید ." value="{{old('subject')}}" />
              <div class="validation"></div>
            </div> --}}

            <div class="form-group">
              <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" rows="5" data-rule="required" data-msg="لطفا متن پیام را بنویسید ." placeholder="متن پیام">{{old('message')}}</textarea>
              <div class="validation"></div>
            </div>

            <div class="text-right"><button id="sendMessage" type="submit">ارسال پیام</button></div>
          </form>
        </div>

      </div>
    </section><!-- #contact -->

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
              {{-- <li><i class="ion-ios-arrow-left"></i> <a href="#intro">صفحه اصلی</a></li> --}}
              {{-- <li><i class="ion-ios-arrow-left"></i> <a href="#services">نمایندگی ها</a></li> --}}

              <li><i class="ion-ios-arrow-left"></i> <a href="#portfolio">نمونه محصولات</a></li>
              <li><i class="ion-ios-arrow-left"></i> <a href="#call-to-action">سفارش محصول</a></li>

              <li><i class="ion-ios-arrow-left"></i> <a href="http://www.termehsalari.com/store">ورود به فروشگاه</a></li>
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
            <form action="{{route('newsletter.store')}}" method="post" class="mb-2">
              @csrf
              <input type="email" class="@error('email_join_newsletter') is-invalid @enderror" name="email_join_newsletter" id="email_join_newsletter" placeholder=" آدرس ایمیل خود را بنویسید" value="{{old('email_join_newsletter')}}"><input type="submit" class="joinNewsletter"  value="عضویت">
            </form>

            <div class="text-right">
              <img src="{{ asset('/storetemplate/dist/img/behpardakht.png') }}" alt="behpardakht termeh salari">

              <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=210447&amp;Code=Anvxg4lW2ecEYh0W8QsV" alt="" style="cursor:pointer;width: 100px;filter:contrast(200%) brightness(150%);" id="Anvxg4lW2ecEYh0W8QsV"></a>

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

        Designed by <a href="http://www.fazeledu.com/">FazelEdu</a>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Uncomment below i you want to use a preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- JavaScript Libraries -->
  <script src="{{asset('/hometemplate/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/jquery/jquery-migrate.min.js')}}"></script>
  <script src="{{asset('/hometemplate/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
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
  {{-- sweetalert --}}
  <script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
  <!-- Template Main Javascript File -->
  <script src="{{asset('/hometemplate/js/main.js')}}"></script>
  <script>
    $(function () {
      // $("#sendMessage").click(function(){
      //   if (ferror == false){
      //     $.ajax({
      //       type: "POST",
      //       url: "{{ route('message.store') }}",
      //       // data: str,
      //       data: {
      //         name: $("#name").val(),
      //         // 'email':$("#email").val(),
      //         mobile: $("#mobile").val(),
      //         // 'subject':$("#subject").val(),
      //         message: $("#message").val(),
      //         _token: "<?php echo csrf_token() ?>"
      //       },
      //       success: function(data) {
      //         // alert(msg);
      //         var title = "";
      //         if(data.res == "error")
      //           title = "خطا  در اجرای عملیات" ;

      //         else if(data.res == "success")
      //           title = "عملیات با موفقیت انجام  شد";

      //         swal(title, data.message,data.res);

      //         if (data.res == "success") {
      //           $("#sendmessage").addClass("show");
      //           $("#errormessage").removeClass("show");
      //           $('.contactForm').find("input, textarea").val("");
      //         } else {
      //           $("#sendmessage").removeClass("show");
      //           $("#errormessage").addClass("show");
      //           $('#errormessage').html(data);
      //         }

      //       }
      //     });
      //   }
      // });

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

        $result = session('status-join');
        @if($result == 1)
          swal(".شما با موفقیت عضو خبرنامه شدید", ".از حالا منتظر خبرهای جذاب ما باشید" ,"success");
        @endif
        @if($result == 0)
          swal("خطا در اجرای عملیات ", ". آدرس پست الکترونیک تکراری می باشد" ,"erroe");
        @endif
      @endif   --}}

    });//end
  </script>
</body>
</html>
