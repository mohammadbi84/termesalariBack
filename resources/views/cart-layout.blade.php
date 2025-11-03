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

  @stack('linkLast')
  <style type="text/css" media="screen">
    #cartContainer{
      overflow: auto;
      height: 278px;
    }

    #cartFooter small{
      font-size: .7rem;
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
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">خانه</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">تماس</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="جستجو" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto">
      @if (Auth::check())

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">             
            {{Auth::user()->name}} {{Auth::user()->family}}             
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            {{-- <span class="dropdown-item dropdown-header">15 نوتیفیکیشن</span> --}}
            <div class="dropdown-divider"></div>
            <a href="" class="dropdown-item">
              <i class="fa fa-user ml-2"></i> تنظیمات پروفایل
              {{-- <span class="float-left text-muted text-sm">3 دقیقه</span> --}}
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


      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="" class="img-size-50 ml-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <span class="float-left text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm"></p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i></p>
              </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
         
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->

      
      


      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fa fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 444px;">
    
    <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="{{asset('/storetemplate/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">@if (Auth::check()) پنل مدیریت @else خوش آمدید @endif</span>
      </a>
      
    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        @if (Auth::check())
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              
                <img src="@if(Auth::user()->image) {{asset('/storage/'.Auth::user()->image)}} @else {{asset('/img/avatar5.png')}}@endif?s=200&amp;d=mm&amp;r=g" class="img-circle elevation-2" alt="User Image">
                  
            </div>
            <div class="info">
              <a href="" class="d-block">@if (Auth::check()) {{ Auth::user()->name}} {{Auth::user()->family}}  @endif</a>
            </div>
          </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-tree"></i>
                <p>
                  Authors
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>List</p>
                  </a>
                </li>            
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-tree"></i>
                <p>
                  Publishers
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>List</p>
                  </a>
                </li>            
              </ul>
            </li>


            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-tree"></i>
                <p>
                  Books
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>Create</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>List</p>
                  </a>
                </li>            
              </ul>
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
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">خانه</a></li>
              <li class="breadcrumb-item active">@yield('title')</li>
            </ol>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>CopyLeft © 2018 <a href="#">@if (Auth::check()) {{Auth::user()->name}}  {{Auth::user()->family}}  @endif</a>.</strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('/storetemplate/plugins/jquery/jquery.min.js')}}"></script>
@stack('js')
<!-- Bootstrap 4 -->
<script src="{{asset('/storetemplate/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/storetemplate/dist/js/adminlte.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('/storetemplate/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/storetemplate/plugins/fastclick/fastclick.js')}}"></script>
{{-- sweetalert --}}
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

<script src="{{asset('/storetemplate/plugins/sweetalert/sweetalert.min.js')}}"></script>
{{-- <script type="module" src="{{asset('/storetemplate/plugins/sweetalert2/src/SweetAlert.js')}}"></script> --}}
{{-- <script type="module" src="{{asset('/storetemplate/plugins/sweetalert2/src/sweetalert2.js')}}"></script> --}}
</body>
</html>
