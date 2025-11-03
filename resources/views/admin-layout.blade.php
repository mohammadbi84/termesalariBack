<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>@yield('title')</title>
  @stack('link')
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('/hometemplate/lib/fontawesome-free-5.12.0/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/bootstrap-rtl.min.css')}}">
  <!-- template rtl version -->
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/fonts/font-face-FD-WOL.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/custom-style.css')}}">

  <!-- sweetalert -->
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/sweetalert/sweetalert.css')}}">

  <link rel="stylesheet" href="{{asset('/storetemplate/dist/css/termehsalari.css')}}">
  <link rel="stylesheet" href="{{asset('/storetemplate/plugins/nprogress-master/nprogress.css')}}">

  @stack('linkLast')
  <style type="text/css" media="screen">
    .loader{
      display: none;
    }
    #cartContainer{
      overflow: auto;
      height: 278px;
    }

    #cartFooter small{
      font-size: .7rem;
    }

    .container-fluid{
      width: 100% !important;
    }
  </style>
  
  
</head>
<body class="sidebar-mini" style="height: auto;">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">خانه</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">تماس</a>
      </li> --}}
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="جستجو" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}
    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto">
      @if (Auth::check())

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">             
            {{Auth::user()->name}} {{Auth::user()->family}}&nbsp;<i class="fa fa-chevron-down" style="font-size: 0.5rem"></i>            
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <a href="#" class="dropdown-item">
              <i class="fa fa-sign-out ml-2"></i> تغییر رمز عبور
            </a>

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
              <i class="fa fa-sign-out ml-2"></i> خروج
            </a>
        </li>
      @endif

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="{{ route('userMessage.index') }}" title=" نوتیفیکیشن ها">
          <i class="fa fa-comments"></i>
            {{-- @if(isset($countUserMessages) and $countUserMessages > 0) --}}
              <span class="badge badge-danger navbar-badge">
                {{ $countNotification = $countUserMessages + $countMessages + $countComments }}
              </span>
            {{-- @endif --}}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          @if($countNotification > 0)
            <span class="dropdown-item dropdown-header">{{ $countNotification }} نوتیفیکیشن</span>

            @if(isset($countUserMessages) and $countUserMessages > 0)
              <div class="dropdown-divider"></div>
              <a href="{{ route('userMessage.index') }}" class="dropdown-item" style="font-size: 0.9rem">
                <i class="fa fa-envelope ml-2"></i> {{ $countUserMessages }} پیام جدید از کاربران
                {{-- <span class="float-left text-muted text-sm">3 دقیقه</span> --}}
              </a>
            @endif

            @if(isset($countMessages) and $countMessages > 0)
              <div class="dropdown-divider"></div>
              <a href="{{ route('userMessage.index') }}" class="dropdown-item" style="font-size: 0.9rem">
                <i class="fa fa-paper-plane ml-2"></i> {{ $countMessages }} پیام جدید از بازدیدکنندگان
                {{-- <span class="float-left text-muted text-sm">3 دقیقه</span> --}}
              </a>
            @endif

            @if(isset($countComments) and $countComments > 0)
              <div class="dropdown-divider"></div>
              <a href="{{ route('comment.index') }}" class="dropdown-item" style="font-size: 0.9rem">
                <i class="fa fa-comment ml-2"></i> {{$countComments  }} نظر جدید
                {{-- <span class="float-left text-muted text-sm">3 دقیقه</span> --}}
              </a>
            @endif
          @endif

          {{-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">مشاهده همه نوتیفیکیشن</a> --}}
         
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      
      <li class="nav-item dropdown">
        <a class="nav-link cart" href="{{ route('order.index') }}" title="سفارش ها" >
          <i class="fa fa-shopping-cart"></i>
          @if(isset($countOrders) and $countOrders > 0)
            <span class="badge badge-danger navbar-badge shopping-cart-badge">{{ $countOrders }}</span>
          @endif
        </a> 
      </li>
  
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 444px;">
    
    <!-- Brand Logo -->
      <a href="{{ route('homeStore.index') }}" class="brand-link" target="blank">
        <img src="{{asset('/hometemplate/img/logo.png')}}" alt="Termeh Salari" class="brand-image">
        <span class="brand-text font-weight-light">@if (Auth::check()) پنل مدیریت @else خوش آمدید @endif</span>
      </a>
      
    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        @if (Auth::check())
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <a href="#" data-toggle="modal" data-target="#profileImages">
                <img src="@if(Auth::user()->image) {{asset('/storetemplate/dist/img/'.Auth::user()->image)}}@else{{asset('/storetemplate/dist/img/avatar7.jpg')}}@endif?s=200&amp;d=mm&amp;r=g" class="img-circle elevation-2" alt="User Image">
              </a>
            </div>
            <div class="info">
                <a href="{{ route('user.adminProfile') }}" class="d-block">@if (Auth::check()) {{ Auth::user()->name}} {{ Auth::user()->family }} @endif</a>
            </div>
          </div>
        @endif

        <div class="modal fade row" id="profileImages" tabindex="-1" role="dialog" aria-labelledby="profileImagesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered col-12" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="commentTextLabel">تغییر نمایه کاربری شما</h6>
                    </div>
                    <div class="modal-body row">
                        @for($i=7 ; $i<=12 ; $i++)
                            <div class="col-4 mb-3">
                                <a href="{{ route('user.adminChangeImage',["avatar".$i.".jpg"]) }}" class=""><img class="profile-user-img img-fluid img-circle" src="{{ asset('/storetemplate/dist/img/avatar'.$i.'.jpg') }} " alt="User profile picture"></a>
                            </div>
                            
                        @endfor
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>داشبورد</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('user.index') }}" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                <p>
                  کاربران
                  {{-- <i class="fa fa-angle-left right"></i> --}}
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('category.index') }}" class="nav-link">
                <i class="fas fa-sitemap"></i>
                <p>
                  دسته بندی محصولات
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('design.index') }}" class="nav-link">
                <i class="fas fa-swatchbook"></i>
                <p>
                  طرح ها 
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('color.index') }}" class="nav-link">
                <i class="fas fa-palette"></i>
                <p>
                 رنگ ها
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-box-open"></i>
                <p>
                  محصولات
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{ route('tablecloth.index') }}" class="nav-link">
                    <i class="fa fa-chevron-left nav-icon"></i>
                    <p>رومیزی</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('bedcover.index') }}" class="nav-link">
                    <i class="fa fa-chevron-left nav-icon"></i>
                    <p>روتختی</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('pillow.index') }}" class="nav-link">
                    <i class="fa fa-chevron-left nav-icon"></i>
                    <p>پشتی و کوسن</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('prayermat.index') }}" class="nav-link">
                    <i class="fa fa-chevron-left nav-icon"></i>
                    <p>سجاده و جانماز</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('fabric.index') }}" class="nav-link">
                    <i class="fa fa-chevron-left nav-icon"></i>
                    <p>پارچه ترمه</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('etc.index') }}" class="nav-link">
                    <i class="fa fa-chevron-left nav-icon"></i>
                    <p>سایر محصولات</p>
                  </a>
                </li>
                         
              </ul>
            </li>

            <li class="nav-item">
              <a href="{{ route('discountCard.index') }}" class="nav-link">
                <i class="fas fa-tags"></i>
                <p> کد تخفیف</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('userMessage.index') }}" class="nav-link">
                <i class="nav-icon fa fa-paper-plane "></i>
                <p>پیام ها</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('comment.index') }}" class="nav-link">
                <i class="nav-icon fa fa-comments"></i>
                <p>نظرات</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('order.index') }}" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>سفارش های موفق</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('order.unsuccess.index') }}" class="nav-link">
                <i class="fas fa-exclamation-triangle"></i>
                <p>سفارش های ناموفق</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('payment.index') }}" class="nav-link">
                <i class="nav-icon fa fa-credit-card"></i>
                <p>مبالغ دریافتی</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('recipient.index') }}" class="nav-link">
                <i class="nav-icon fa fa-user"></i>
                <p>گیرندگان</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('newsletter.index') }}" class="nav-link">
                <i class="nav-icon fa fa-envelope"></i>
                <p>خبرنامه</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('slideshow.index') }}" class="nav-link">
                <i class="nav-icon fa fa-envelope"></i>
                <p>تصاویر اسلایدشو</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('user.adminProfile') }}" class="nav-link">
                <i class="nav-icon fas fa-id-card "></i>
                <p>حساب کاربری</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('user.adminChangePassword') }}" class="nav-link">
                <i class="nav-icon fas fa-lock"></i>
                <p>تغییر رمز عبور</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>خروج</p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 444px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('title-content')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            {{-- <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">خانه</a></li>
              <li class="breadcrumb-item active">@yield('title')</li>
            </ol> --}}
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        @yield('main-content')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    {{-- <div class="float-right d-none d-sm-inline">
      Anything you want
    </div> --}}
    <!-- Default to the left -->
    <strong class="float-left">CopyLeft © 2020 <a href="#">www.TermehSalari.com</a></strong>
  </footer>
</div>
<!-- ./wrapper -->

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

<!-- REQUIRED SCRIPTS -->

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('/storetemplate/plugins/jquery/jquery.min.js')}}"></script>
@stack('js')
<!-- Bootstrap 4 -->
<script src="{{asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Site App -->
<script src="{{asset('/storetemplate/dist/js/adminlte.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('/storetemplate/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/storetemplate/plugins/fastclick/fastclick.js')}}"></script>
{{-- sweetalert --}}
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

<script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('/storetemplate/plugins/nprogress-master/nprogress.js')}}"></script>
{{-- <script src="{{asset('/storetemplate/dist/js/autoLogout.js')}}"></script> --}}
{{-- <script type="module" src="{{asset('/storetemplate/plugins/sweetalert2/src/SweetAlert.js')}}"></script> --}}
{{-- <script type="module" src="{{asset('/storetemplate/plugins/sweetalert2/src/sweetalert2.js')}}"></script> --}}
<script type="text/javascript">
  NProgress.configure({
    showSpinner: false,
  });

  jQuery( document ).ajaxStart(function() {
    NProgress.start();
  });

  jQuery( document ).ajaxStop(function() {
    NProgress.done();
  });

  $(function(){ 
    const timeout = 1800000;  // 900000 ms = 15 minutes
    var idleTimer = null;
    $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
        clearTimeout(idleTimer);

        idleTimer = setTimeout(function () {
            document.getElementById('logout-form').submit();
        }, timeout);
    });
    $("body").trigger("mousemove");
  });
  
</script>
</body>
</html>
