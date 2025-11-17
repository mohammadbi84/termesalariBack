<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- لینک CDN ها -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link href="https://v1.fontapi.ir/css/VazirFD" rel="stylesheet">

    <!-- icons -->
    <link rel="stylesheet" href="{{ asset('shop/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('shop/css/boxicons.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- swiper slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- slider styles -->
    <script src="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.4/dist/min/tiny-slider.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.4/dist/tiny-slider.css">
    <link rel="stylesheet" href="{{ asset('shop/css/slider.css') }}">
    <script src="{{ asset('shop/js/slider.js') }}"></script>


    <!-- menu styles -->
    <link rel="stylesheet" href="{{ asset('shop/css/main-menu.css') }}">
    <script src="{{ asset('shop/js/main-menu.js') }}"></script>
    <!-- استایل‌های سفارشی -->
    <link rel="stylesheet" href="{{ asset('shop/css/styles.css') }}">
    <script src="{{ asset('shop/js/scripts.js') }}"></script>

    <!-- video -->
    <link rel="stylesheet" href="{{ asset('shop/css/video.css') }}">
    <script src="{{ asset('shop/js/video.js') }}"></script>
    <!-- footer -->
    <link rel="stylesheet" href="{{ asset('shop/css/footer.css') }}">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="{{ asset('shop/css/leaflet.css') }}" />
    <link rel="shortcut icon" href="{{ asset('/hometemplate/img/favicon.png') }}" type="image/x-icon">
    @yield('head')
</head>

<body>
    {{-- navbar --}}
    @include('shop.layouts.navbar')

    @yield('content')
    {{-- footer --}}
    @include('shop.layouts.footer')
    <!-- go to top button -->
    <button class="back-to-top" id="backToTop">
        <i class="fa-solid fa-chevron-up fa-lg" style="top: 1px;"></i>
    </button>

    <!-- Leaflet JS -->
    <script src="{{ asset('shop/js/leaflet.js') }}"></script>
    @yield('script')

    @if (session('fail'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "error",
                text: "{{ Session::get('fail') }}",
                showConfirmButton: false,
                width: 400,
                timer: 2000,
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                text: "{{ Session::get('success') }}",
                showConfirmButton: false,
                width: 400,
                timer: 2000,
            });
        </script>
    @endif
</body>

</html>
