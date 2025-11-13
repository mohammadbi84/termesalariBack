<header>
    <!-- بوکمارک -->
    <div class="bookmark-container">
        <div class="bookmark expanded" id="bookmark">
            <div class="bookmark-content">
                <div class="bookmark-text d-flex align-items-center justify-content-start h-100 gap-3">
                    <h6 class="m-0">توجه!</h6>
                    <p class="m-0">رنگ تصاویر با رنگ واقعی محصولات 20% تفاوت دارد.</p>
                    <button class="btn btn-close bg-light" id="bookmarkToggle"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- navbar -->
    <div class="main-menu rounded-3">
        <nav class="navbar navbar-expand-lg">
            <div class="container p-0 px-3 position-relative">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                    <img src="{{ asset('/hometemplate/img/logo.png') }}" alt="website logo">
                </a>
                <button class="navbar-toggler" type="button" id="mobileMenuToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 column-gap-2 px-0">
                        <!-- دکمه دسته‌بندی‌ها -->
                        <div class="categories-dropdown d-flex" id="categoryTrigger">
                            <button class="categories-btn">
                                <i class="fas fa-bars"></i>
                                دسته‌بندی‌ها
                            </button>
                            @php
                                $categories = App\Category::where('parent_id', 0)->get();
                                $chunks = $categories->chunk(ceil($categories->count() / 4)); // تقسیم به 4 قسمت
                            @endphp
                        </div>

                        <li class="nav-item">
                            <a class="nav-link" href="#specials">
                                <img src="{{ asset('shop/assets/svgs/badge-percent.svg') }}" alt="hots"
                                    width="18">
                                شگفت انگیزها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#newest">جدیدترین ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#products">پرفروش ترین‌ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#branchs">نمایندگی های فروش</a>
                        </li>
                    </ul>
                    <!-- cart ================================================================================================================== -->
                    <div class="d-flex gap-2 align-items-center justify-content-center position-relative">
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
                        <div class="dropdown" id="cart_dropdown">
                            <a class="text-decoration-none btn btn-icon border-0" id="cartBtn" data-bs-toggle="dropdown"
                                type="button" aria-expanded="false">
                                <span
                                    class="badge rounded-pill cart-badge shopping-cart-badge">{{ $sum ?? 0 }}</span>
                                <img src="{{ asset('shop/assets/svgs/cart.svg') }}" alt="cart" width="24">
                                <!-- <i class="fa-solid fa-cart-shopping fa-lg me-1 text-secondary"></i> -->
                            </a>
                            <!-- منوی دراپ‌داون با انیمیشن -->
                            <ul class="dropdown-menu dropdown-animated text-end p-1 shadow border-0"
                                id="navbarCartList">
                                <li class="bg-white w-100" style="position: fixed;top: 0px;">
                                    <h5 class="dropdown-header text-end border-bottom w-100">
                                        {{ $sum ?? 0 }} کالا
                                    </h5>
                                </li>
                                @isset($cart)
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
                                            <li class="dropdown-item">
                                                <div class="row border-bottom">
                                                    <div class="col-md-5 p-2">
                                                        <a
                                                            href="
                                                        @switch($list['models'][$key])
                                                          @case('Tablecloth')
                                                            {{ route('tablecloth.show', [$item->id]) }}
                                                        @endswitch
                                                        ">
                                                            <img src="{{ asset('storage/images/' . $item->images->first()->name) }}"
                                                                alt="name" class="w-100">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-7 p-2">
                                                        <p class="drapdown-title mt-2 text-start">
                                                            {{ Str::limit($item->title . ' طرح ' . $item->color_design->design->title . ' رنگ ' . $item->color_design->color->color, 22) }}
                                                        </p>
                                                        <div class="clearfix pt-2">
                                                            <div class="float-end">
                                                                {{ $list['quantities'][$key] }} عدد
                                                            </div>
                                                            <div class="float-start">
                                                                @if ($cartOff > 0)
                                                                    <span class="text-secondary" style="font-size: 14px"><del
                                                                            class="del">{{ number_format($p->price) }}</del></span>
                                                                    {{ number_format($cartPrice) }}
                                                                @else
                                                                    {{ number_format($cartPrice) }}
                                                                @endif
                                                                <span class="toman"><svg viewBox="0 0 15 16" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg" width="20"
                                                                        height="20">
                                                                        <path
                                                                            d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                            fill="#A3A3A3"></path>
                                                                    </svg></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        <li class="bg-white p-3 border-top" style="position: sticky;bottom: 0;">
                                            <div class="row ">
                                                <div class="col text-start">
                                                    <span class="float-end mt-0 card-price">{{ number_format($price) }}<span
                                                            class="toman"><svg viewBox="0 0 15 16" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20">
                                                                <path
                                                                    d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"
                                                                    fill="#A3A3A3"></path>
                                                            </svg></span></span>
                                                </div>
                                                <div class="col text-start">
                                                    @if (!Auth::check())
                                                        <a href="{{ route('login') }}" class="btn btn-success my-auto"
                                                            style="margin-top: 10px">ورود و ثبت سفارش</a>
                                                    @else
                                                        <a href="{{ route('cart.index') }}"
                                                            class="btn btn-success my-auto">مشاهده
                                                            سبدخرید</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endisset
                                @endisset
                            </ul>
                        </div>
                        <!-- ورود و ثبت نام -->
                        <div class="flex justify-center items-center">
                            <div class="button-container border border-secondary rounded p-2">
                                @if (!Auth::check())
                                    <a href="{{ route('login') }}" class="text-muted text-decoration-none px-1 login-link">
                                        ورود
                                    </a>
                                    |
                                    <a href="{{ route('register') }}" class="text-muted text-decoration-none px-1 login-link">
                                        ثبت نام
                                    </a>
                                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                                @else
                                    <a href="{{ route('user.profile') }}"
                                        class="text-muted text-decoration-none px-1">
                                        <i class="fa-solid fa-user me-1"></i>
                                        {{ Auth::user()->name }} {{ Auth::user()->family }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- منوی دسته‌بندی برای دسکتاپ -->
                <div class="category-menu" id="categoryMenu">
                    <div class="category-content">
                        <div class="row">
                            @foreach ($chunks as $chunk)
                                <!-- ستون 1 -->
                                <div class="col-lg-3 col-md-6 category-column">
                                    @foreach ($chunk as $category)
                                        <a href="{{ route($category->link) ?? '#' }}"
                                            class="main-categories">{{ $category->title ?? '--' }}</a>
                                        @if ($category->childs()->count() > 0)
                                            <ul class="sub-categories">
                                                @foreach ($category->childs as $cat)
                                                    <li><a
                                                            href="{{ route($category->link) ?? '#' }}">{{ $cat->title ?? '--' }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- آکاردئون موبایل -->
    <div class="mobile-category-menu" id="mobileCategoryMenu">
        <div class="mobile-category-header">
            <span>فروشگاه ترمه سالاری</span>
            <button type="button" id="closeMobileMenu" class="btn-close"></button>
        </div>
        <div class="mobile-category-content">
            <!-- ورود و ثبت نام -->
            <div class="flex justify-center items-center mb-2">
                <div class="button-container border border-secondary rounded text-center p-2">
                    @if (!Auth::check())
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none px-1">
                            ورود
                        </a>
                        |
                        <a href="{{ route('register') }}" class="text-muted text-decoration-none px-1">
                            ثبت نام
                        </a>
                        <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                    @else
                        <a href="{{ route('user.profile') }}" class="text-muted text-decoration-none px-1">
                            <i class="fa-solid fa-user me-1"></i>
                            {{ Auth::user()->name }} {{ Auth::user()->family }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="mobile-main-category py-3">
                <a href="{{ route('cart.index') }}" class="text-reset text-decoration-none fw-bold">
                    <img src="{{ asset('shop/assets/svgs/cart.svg') }}" alt="cart" width="24">
                    سبد خرید
                </a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#specials">
                    <img src="{{ asset('shop/assets/svgs/badge-percent.svg') }}" alt="hots" width="18">
                    شگفت انگیزها</a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#newest">جدیدترین ها</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#products">پرفروش ترین‌ها</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#branchs">نمایندگی های فروش</a>

            </div>
            @foreach ($categories as $category)
                <div class="mobile-main-category">
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#{{ $category->id }}">
                        {{ $category->title ?? '--' }}
                    </button>
                    @if ($category->childs()->count() > 0)
                        <ul class="mobile-sub-categories collapse" id="{{ $category->id }}">
                            @foreach ($category->childs as $cat)
                                <li><a href="{{ route($category->link) ?? '#' }}">{{ $cat->title ?? '--' }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <!-- overlay برای بستن منوی موبایل -->
    <div class="overlay" id="overlay"></div>
</header>

<script>
    $("#cart_dropdown").hover(function() {
        var dropdown = new bootstrap.Dropdown($("#cartBtn")[0]);
        dropdown.show();
    }, function() {
        var dropdown = new bootstrap.Dropdown($("#cartBtn")[0]);
        dropdown.hide();
    });
</script>
